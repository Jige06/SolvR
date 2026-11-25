<?php
declare(strict_types=1);

/**
 * Contrôleur de la page Contact : décide quoi faire d'une requête.
 *
 * Il ne fait ni affichage, ni redirection, ni exit : il répond seulement
 * « il faut rediriger » ou « il faut afficher », et c'est contact.php qui agit.
 * La logique reste ainsi testable et réutilisable (par exemple pour une future API).
 */
class ContactController
{
    /** Clé de session du message de confirmation « flash » (affiché une seule fois) */
    private const FLASH_KEY = 'contact_success';

    private ContactForm $form;
    private ?ContactStatus $status = null;

    /**
     * @param array              $config Configuration du site (SMTP, adresses…)
     * @param ContactMailer|null $mailer Expéditeur à utiliser. Laissé vide, le vrai est créé
     *                                   au moment d'envoyer ; un test peut en fournir un faux.
     */
    public function __construct(
        private array $config,
        private ?ContactMailer $mailer = null,
    ) {
        $this->form = new ContactForm();
    }

    /**
     * Traite la requête.
     *
     * @param string $method Méthode HTTP (en pratique : $_SERVER['REQUEST_METHOD'])
     * @param array  $post   Données envoyées (en pratique : $_POST)
     * @return bool          true s'il faut rediriger vers la page Contact (Post/Redirect/Get)
     */
    public function handle(string $method, array $post): bool
    {
        if ($method !== 'POST') {
            $this->readFlashMessage();
            return false;
        }

        // On garde toujours la saisie : en cas d'erreur, rien n'est à retaper.
        $this->form = new ContactForm($post);

        if (!CsrfToken::isValid($post['csrf_token'] ?? null)) {
            // Jeton absent ou faux : session expirée, ou tentative d'attaque CSRF
            $this->status = ContactStatus::Csrf;
            return false;
        }

        if (($post['site_web'] ?? '') !== '') {
            // Honeypot rempli : c'est un robot. On répond comme pour un succès,
            // pour ne pas lui apprendre que son envoi a été bloqué.
            return $this->succeed();
        }

        if (!$this->form->validate()) {
            $this->status = ContactStatus::Invalid;
            return false;
        }

        try {
            ($this->mailer ?? new ContactMailer($this->config))->send($this->form);
        } catch (Throwable $exception) {
            // Le détail technique va dans le journal du serveur, jamais à l'écran
            error_log('Échec de l\'envoi du formulaire de contact : ' . $exception->getMessage());
            $this->status = ContactStatus::SendError;
            return false;
        }

        return $this->succeed();
    }

    public function getForm(): ContactForm
    {
        return $this->form;
    }

    /** null tant qu'il n'y a rien à signaler (premier affichage de la page) */
    public function getStatus(): ?ContactStatus
    {
        return $this->status;
    }

    /** Mémorise le succès pour l'afficher après la redirection */
    private function succeed(): bool
    {
        $_SESSION[self::FLASH_KEY] = true;
        return true;
    }

    /** Lit le message flash puis l'efface : il ne s'affiche qu'une fois */
    private function readFlashMessage(): void
    {
        if (!empty($_SESSION[self::FLASH_KEY])) {
            $this->status = ContactStatus::Success;
            unset($_SESSION[self::FLASH_KEY]);
        }
    }
}
