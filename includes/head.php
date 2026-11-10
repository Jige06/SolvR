<?php
require_once __DIR__ . '/functions.php';
$pages = require __DIR__ . '/pages.php';

// Chaque page définit $currentPage avant d'inclure ce fichier
$currentPage = $currentPage ?? '';
$page        = $pages[$currentPage] ?? [];

$pageTitle       = $page['title']       ?? 'SolvR — Développeur web et web mobile';
$pageDescription = $page['description'] ?? 'Création de sites internet et d\'applications sur mesure.';
$canonicalUrl    = SITE_URL . ($page['path'] ?? '/');
?>
<!DOCTYPE html>
<html lang="fr">
<head>
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

    <!-- Bootstrap d'abord, nos styles ensuite pour pouvoir le surcharger -->
    <link rel="stylesheet" href="/assets/vendor/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/css/style.css">
</head>