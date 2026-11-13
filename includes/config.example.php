<?php
/**
 * Modèle de configuration.
 * 1. Copier ce fichier sous le nom config.php (dans le même dossier)
 * 2. Renseigner les vraies valeurs dans config.php
 * config.php est ignoré par Git : les secrets ne partent jamais sur GitHub.
 */
return [
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