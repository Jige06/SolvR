<?php
declare(strict_types=1);

use PHPMailer\PHPMailer\PHPMailer;

/**
 * Envoie le message du formulaire de contact par e-mail (SMTP, via PHPMailer).
 * Le reste du site ne connaît que cette classe : si on change un jour
 * de bibliothèque d'envoi, c'est le seul fichier à modifier.
 */
class ContactMailer
{
    /**
     * @param array $config Configuration SMTP et adresses (voir includes/config.php)
     */
    public function __construct(private array $config)
    {
    }

    /**
     * Envoie le message.
     * @throws \PHPMailer\PHPMailer\Exception si l'envoi échoue
     */
    public function send(ContactForm $form): void
    {
        $mail = new PHPMailer(true);   // true : les erreurs lèvent des exceptions

        // Connexion au serveur SMTP
        $mail->isSMTP();
        $mail->Host       = $this->config['smtp']['host'];
        $mail->Port       = (int) $this->config['smtp']['port'];
        $mail->SMTPAuth   = true;
        $mail->Username   = $this->config['smtp']['username'];
        $mail->Password   = $this->config['smtp']['password'];
        $mail->SMTPSecure = match ($this->config['smtp']['encryption'] ?? 'tls') {
            'ssl'   => PHPMailer::ENCRYPTION_SMTPS,     // port 465
            'tls'   => PHPMailer::ENCRYPTION_STARTTLS,  // ports 587 ou 2525
            default => '',
        };
        $mail->CharSet    = PHPMailer::CHARSET_UTF8;

        // Expéditeur : TOUJOURS une adresse de notre domaine (sinon le mail finit en spam).
        // L'adresse du visiteur va dans « Répondre à » : il suffit de cliquer sur Répondre.
        $mail->setFrom($this->config['mail']['from'], $this->config['mail']['from_name']);
        $mail->addAddress($this->config['mail']['to']);
        $mail->addReplyTo($form->get('email'), $form->get('nom'));

        // Contenu en texte brut : aucun risque d'injection HTML dans le message reçu
        $mail->isHTML(false);
        $mail->Subject = 'Nouvelle demande de contact : ' . $form->get('nom');
        $mail->Body    = $this->buildBody($form);

        $mail->send();
    }

    /** Construit le corps du message */
    private function buildBody(ContactForm $form): string
    {
        $telephone = $form->get('telephone') !== '' ? $form->get('telephone') : 'Non renseigné';

        return "Nouvelle demande depuis le site SolvR\n"
            . "=====================================\n\n"
            . 'Nom : ' . $form->get('nom') . "\n"
            . 'E-mail : ' . $form->get('email') . "\n"
            . 'Téléphone : ' . $telephone . "\n"
            . 'Type de projet : ' . $form->getProjectTypeLabel() . "\n\n"
            . "Message :\n"
            . $form->get('message') . "\n";
    }
}