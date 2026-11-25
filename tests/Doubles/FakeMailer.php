<?php

declare(strict_types=1);

/**
 * Faux expéditeur pour les tests : compte les envois au lieu d'envoyer des e-mails,
 * et peut simuler une panne du serveur SMTP.
 */
class FakeMailer extends ContactMailer
{
    public int $sentCount = 0;
    public bool $failing = false;

    public function __construct()
    {
        // Pas de configuration SMTP : rien n'est réellement envoyé
    }

    public function send(ContactForm $form): void
    {
        if ($this->failing) {
            throw new RuntimeException('Serveur SMTP injoignable (simulé)');
        }

        $this->sentCount++;
    }
}
