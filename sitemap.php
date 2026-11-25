<?php

declare(strict_types=1);

/**
 * Plan du site pour les moteurs de recherche, servi à l'adresse /sitemap.xml
 * (voir .htaccess). Généré depuis includes/pages.php : une page ajoutée là
 * apparaît ici automatiquement, sauf si elle est marquée 'noindex'.
 *
 * Pas de <lastmod> : avec un déploiement par Git, la date de modification des
 * fichiers serait celle du déploiement pour toutes les pages. Une date fausse
 * est pire que pas de date : Google finit par ignorer celles qui ne sont pas fiables.
 */
require_once __DIR__ . '/includes/bootstrap.php';
$pages = require __DIR__ . '/includes/pages.php';

header('Content-Type: application/xml; charset=UTF-8');

echo '<?xml version="1.0" encoding="UTF-8"?>', "\n";
?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
<?php foreach ($pages as $page): ?>
<?php if (!empty($page['noindex'])) continue; ?>
    <url>
        <loc><?= e(SITE_URL . $page['path']) ?></loc>
    </url>
<?php endforeach; ?>
</urlset>
