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

    private SubmissionLimiter $limiter;

    /**
     * @param array                  $config  Configuration du site (SMTP, adresses…)
     * @param ContactMailer|null     $mailer  Expéditeur à utiliser. Laissé vide, le vrai est créé
     *                                        au moment d'envoyer ; un test peut en fournir un faux.
     * @param SubmissionLimiter|null $limiter Limitation des envois (un test peut lui donner une fausse horloge)
     */
    public function __construct(
        private array $config,
        private ?ContactMailer $mailer = null,
        ?SubmissionLimiter $limiter = null,
    ) {
        $this->form    = new ContactForm();
        $this->limiter = $limiter ?? new SubmissionLimiter();
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
            return $this->display();
        }

        // On garde toujours la saisie : en cas d'erreur, rien n'est à retaper.
        $this->form = new ContactForm($post);

        if (!CsrfToken::isValid($post['csrf_token'] ?? null)) {
            // Jeton absent ou faux : session expirée, ou tentative d'attaque CSRF
            $this->status = ContactStatus::Csrf;
            return $this->display();
        }

        if (($post['site_web'] ?? '') !== '' || $this->limiter->isTooFast()) {
            // Honeypot rempli, ou formulaire envoyé en quelques secondes : c'est un robot.
            // On répond comme pour un succès, pour ne pas lui apprendre qu'il a été bloqué.
            return $this->succeed();
        }

        if (!$this->limiter->canSend()) {
            // Trop d'envois récents : on garde la saisie, le visiteur pourra renvoyer plus tard
            $this->status = ContactStatus::TooManyRequests;
            return $this->display();
        }

        if (!$this->form->validate()) {
            $this->status = ContactStatus::Invalid;
            return $this->display();
        }

        try {
            ($this->mailer ?? new ContactMailer($this->config))->send($this->form);
        } catch (Throwable $exception) {
            // Le détail technique va dans le journal du serveur, jamais à l'écran
            error_log('Échec de l\'envoi du formulaire de contact : ' . $exception->getMessage());
            $this->status = ContactStatus::SendError;
            return $this->display();
        }

        $this->limiter->recordSend();

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

    /** Le formulaire va être (ré)affiché : on note l'heure pour le piège temporel */
    private function display(): bool
    {
        $this->limiter->markFormDisplayed();
        return false;
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
