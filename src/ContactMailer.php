<?php

declare(strict_types=1);

use PHPMailer\PHPMailer\PHPMailer;

/**
 * Envoie le message du formulaire de contact par e-mail (SMTP, via PHPMailer).
 * Le reste du site ne connaît que cette classe : si on change un jour
 * de bibliothèque d'envoi, c'est le seul fichier à modifier.
 * Le contenu du mail (objet, HTML, texte) est préparé par ContactEmail.
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
        // Heure de Paris, quel que soit le fuseau du serveur
        $email = new ContactEmail($form, new DateTimeImmutable('now', new DateTimeZone('Europe/Paris')));
        $mail  = new PHPMailer(true);   // true : les erreurs lèvent des exceptions

        // Connexion au serveur SMTP
        $mail->isSMTP();
        $mail->Host       = $this->config['smtp']['host'];
        $mail->Port       = (int) $this->config['smtp']['port'];
        $mail->SMTPAuth   = true;
        $mail->Timeout    = 10;   // secondes (300 par défaut : un serveur lent bloquerait la page 5 min)
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
        $mail->addReplyTo($form->get('email'), $form->get('name'));

        // Contenu : HTML, avec une version texte pour les logiciels qui n'affichent pas le HTML
        $mail->isHTML(true);
        $mail->Subject = $email->subject();
        $mail->Body    = $email->html();
        $mail->AltBody = $email->text();

        $mail->send();
    }
}
