<?php
/**
 * Modèle de configuration.
 * 1. Copier ce fichier sous le nom config.php (dans le même dossier)
 * 2. Renseigner les vraies valeurs dans config.php
 * config.php est ignoré par Git : secrets et informations personnelles ne partent jamais sur GitHub.
 */
return [
    // Coordonnées affichées sur le site (footer, page Contact, mentions légales)
    'contact' => [
        'email'      => '[contact@exemple.fr]',
        'phone'      => '[06 00 00 00 00]',
        'phone_link' => '[+33600000000]',   // format international pour les liens tel:
    ],

    // Informations légales (mentions légales, politique de confidentialité)
    // Laisser 'tva' vide ('') pour masquer la ligne (franchise en base de TVA).
    'legal' => [
        'updated' => '16 novembre 2026',
        'editor'  => [
            'name'    => '[Prénom Nom]',
            'status'  => 'Entrepreneur individuel (EI), nom commercial SolvR',
            'address' => '[Adresse professionnelle ou de domiciliation]',
            'siren'   => '[Numéro SIREN]',
            'tva'     => '',
        ],
        'host' => [
            'name'    => '[Nom de l\'hébergeur]',
            'address' => '[Adresse de l\'hébergeur]',
            'phone'   => '[Téléphone de l\'hébergeur]',
        ],
        'mail_provider' => '[Prestataire d\'envoi des e-mails]',
    ],

    'smtp' => [
        'host'       => 'sandbox.smtp.mailtrap.io',  // Mailtrap en développement
        'port'       => 2525,
        'username'   => 'votre_username_mailtrap',
        'password'   => 'votre_password_mailtrap',
        'encryption' => 'tls',                       // 'tls' (ports 587/2525) ou 'ssl' (port 465)
    ],
    'mail' => [
        'from'      => 'noreply@solvr.fr',   // expéditeur (adresse de votre domaine)
        'from_name' => 'Site SolvR',
        'to'        => 'contact@solvr.fr',   // destinataire des demandes
    ],
];