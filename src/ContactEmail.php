<?php

declare(strict_types=1);

/**
 * Contenu de l'e-mail envoyé à SolvR pour chaque demande de contact :
 * l'objet, la version HTML (gabarit includes/emails/contact.php) et la version texte.
 *
 * Séparée de ContactMailer : ici le contenu, là-bas l'envoi.
 * Le contenu se teste ainsi sans serveur SMTP (voir tests/ContactEmailTest.php).
 */
class ContactEmail
{
    private const TEMPLATE = __DIR__ . '/../includes/emails/contact.php';

    /**
     * @param ContactForm       $form       Le formulaire validé
     * @param DateTimeImmutable $receivedAt Date de réception, affichée dans le mail
     */
    public function __construct(
        private ContactForm $form,
        private DateTimeImmutable $receivedAt,
    ) {
    }

    /** Objet du mail : on sait de qui il s'agit et pour quoi, avant même de l'ouvrir */
    public function subject(): string
    {
        $subject = 'Nouvelle demande : ' . $this->form->get('name');

        // Le type de projet seulement s'il a été choisi : « (Non précisé) » n'apporterait rien
        if ($this->form->get('type') === '') {
            return $subject;
        }

        return $subject . ' (' . $this->form->getProjectTypeLabel() . ')';
    }

    /** Version HTML. Chaque saisie du visiteur est échappée dans le gabarit avec $esc() */
    public function html(): string
    {
        // Variables mises à disposition du gabarit
        $form       = $this->form;
        $receivedAt = $this->formattedDate();
        $replyLink  = $this->replyLink();
        $phoneLink  = $this->phoneLink();
        $esc        = static fn(string $value): string
            => htmlspecialchars($value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');

        ob_start();
        require self::TEMPLATE;

        return (string) ob_get_clean();
    }

    /** Version texte : affichée par les logiciels qui refusent le HTML, appréciée des filtres anti-spam */
    public function text(): string
    {
        $phone = $this->form->get('phone') !== '' ? $this->form->get('phone') : 'Non renseigné';

        return "Nouvelle demande de contact sur le site SolvR\n"
            . 'Reçue le ' . $this->formattedDate() . "\n\n"
            . 'Nom : ' . $this->form->get('name') . "\n"
            . 'E-mail : ' . $this->form->get('email') . "\n"
            . 'Téléphone : ' . $phone . "\n"
            . 'Type de projet : ' . $this->form->getProjectTypeLabel() . "\n\n"
            . "Message :\n"
            . $this->form->get('message') . "\n\n"
            . '---' . "\n"
            . 'Pour répondre, utilisez simplement « Répondre » : la réponse part vers '
            . $this->form->get('email') . ".\n";
    }

    /** Exemple : 26/11/2026 à 19:52 */
    private function formattedDate(): string
    {
        return $this->receivedAt->format('d/m/Y') . ' à ' . $this->receivedAt->format('H:i');
    }

    /** Lien « Répondre » : l'adresse du visiteur, encodée pour une adresse mailto: valide */
    private function replyLink(): string
    {
        $address = str_replace('%40', '@', rawurlencode($this->form->get('email')));

        return 'mailto:' . $address . '?subject=' . rawurlencode('Votre demande de projet web');
    }

    /** Lien « Appeler » (chiffres et + uniquement), ou null si le visiteur n'a pas donné de numéro */
    private function phoneLink(): ?string
    {
        $phone = $this->form->get('phone');

        return $phone === '' ? null : 'tel:' . preg_replace('/[^\d+]/', '', $phone);
    }
}
