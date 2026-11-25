<?php
require_once __DIR__ . '/functions.php';
$pages = $pages ?? require __DIR__ . '/pages.php';   // déjà chargé par la page ? on le réutilise

// Chaque page définit $currentPage avant d'inclure ce fichier
$currentPage = $currentPage ?? '';
$page        = $pages[$currentPage] ?? [];

$pageTitle       = ($pageTitlePrefix ?? '') . ($page['title'] ?? 'SolvR — Développeur web et web mobile');
$pageDescription = $page['description'] ?? 'Création de sites internet et d\'applications sur mesure.';
$canonicalUrl    = SITE_URL . ($page['path'] ?? '/');
?>
<!DOCTYPE html>
<html lang="fr" data-bs-theme="light">

<head>
    <!-- Thème appliqué AVANT l'affichage, pour éviter un flash de couleur au chargement -->
    <script>
        document.documentElement.classList.add('js');
        (function() {
            let theme = window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
            try {
                const saved = localStorage.getItem('solvr-theme');
                if (saved === 'light' || saved === 'dark') {
                    theme = saved;
                }
            } catch (error) {
                /* localStorage indisponible (navigation privée stricte…) : on garde le thème du système */
            }
            document.documentElement.setAttribute('data-bs-theme', theme);
        })();
    </script>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <?php if (!empty($page['noindex'])): ?>
        <meta name="robots" content="noindex">
    <?php endif; ?>

    <title><?= e($pageTitle) ?></title>
    <meta name="description" content="<?= e($pageDescription) ?>">
    <link rel="canonical" href="<?= e($canonicalUrl) ?>">

    <!-- Open Graph : aperçu lors d'un partage (LinkedIn, WhatsApp…) -->
    <meta property="og:type" content="website">
    <meta property="og:locale" content="fr_FR">
    <meta property="og:site_name" content="SolvR">
    <meta property="og:title" content="<?= e($pageTitle) ?>">
    <meta property="og:description" content="<?= e($pageDescription) ?>">
    <meta property="og:url" content="<?= e($canonicalUrl) ?>">

    <?php if ($currentPage === 'accueil') require __DIR__ . '/structured-data.php'; ?>

    <!-- Préchargement des polices principales (texte et titres) -->
    <link rel="preload" href="/assets/fonts/inter-variable.woff2" as="font" type="font/woff2" crossorigin>
    <link rel="preload" href="/assets/fonts/heebo-variable.woff2" as="font" type="font/woff2" crossorigin>

    <!-- Bootstrap d'abord, nos styles ensuite pour pouvoir le surcharger -->
    <link rel="stylesheet" href="/assets/vendor/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="<?= asset('/assets/css/style.css') ?>">

    <!-- N'affiche la page qu'une fois le HTML lu jusqu'au pied de page :
         en arrivant sur une ancre (services.php#site-vitrine), la section visée
         existe déjà au premier affichage, la page s'ouvre donc directement dessus. -->
    <link rel="expect" href="#pied-de-page" blocking="render">
</head>