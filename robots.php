<?php

declare(strict_types=1);

/**
 * Consignes pour les robots d'indexation, servies à l'adresse /robots.txt
 * (voir .htaccess). Généré en PHP pour que l'adresse du sitemap suive SITE_URL.
 *
 * Rappel : robots.txt est public et n'est pas une protection. Les dossiers
 * internes (includes/, src/, vendor/) sont protégés par .htaccess, pas ici.
 */
require_once __DIR__ . '/includes/bootstrap.php';

header('Content-Type: text/plain; charset=UTF-8');
?>
# Tous les robots peuvent explorer tout le site
User-agent: *
Allow: /

Sitemap: <?= SITE_URL ?>/sitemap.xml
