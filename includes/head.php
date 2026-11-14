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

    <!-- Préchargement des polices principales (texte et titres) -->
    <link rel="preload" href="/assets/fonts/inter-variable.woff2" as="font" type="font/woff2" crossorigin>
    <link rel="preload" href="/assets/fonts/heebo-variable.woff2" as="font" type="font/woff2" crossorigin>

    <!-- Bootstrap d'abord, nos styles ensuite pour pouvoir le surcharger -->
    <link rel="stylesheet" href="/assets/vendor/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/css/style.css">
</head>