<?php
/**
 * Configuration des pages du site.
 * Source unique pour : le <head> (SEO), le menu, les liens du footer, et plus tard le sitemap.
 *
 * nav = true : la page apparaît dans le menu principal
 * (Contact est à false car il est affiché à part, sous forme de bouton)
 */
return [
    'accueil' => [
        'path'        => '/',
        'label'       => 'Accueil',
        'title'       => 'Création de sites internet à Nice | SolvR',
        'description' => 'SolvR, développeur web freelance à Nice : sites vitrines, e-commerce et applications sur mesure pour PME, commerçants et artisans des Alpes-Maritimes.',
        'nav'         => true,
    ],
    'services' => [
        'path'        => '/services.php',
        'label'       => 'Services',
        'title'       => 'Sites vitrines, e-commerce et applications | SolvR',
        'description' => 'Création de sites vitrines, de boutiques en ligne et d\'applications web sur mesure à Nice et dans les Alpes-Maritimes.',
        'nav'         => true,
    ],
    'realisations' => [
        'path'        => '/realisations.php',
        'label'       => 'Réalisations',
        'title'       => 'Réalisations et projets | SolvR',
        'description' => 'Découvrez les projets web réalisés par SolvR : études de cas, fonctionnalités et technologies utilisées.',
        'nav'         => true,
    ],
    'a-propos' => [
        'path'        => '/a-propos.php',
        'label'       => 'À propos',
        'title'       => 'À propos de SolvR, développeur web à Nice',
        'description' => 'Parcours, valeurs et méthode de travail de SolvR, développeur web et web mobile freelance basé à Nice.',
        'nav'         => true,
    ],
    'contact' => [
        'path'        => '/contact.php',
        'label'       => 'Contact',
        'title'       => 'Contact et devis gratuit | SolvR',
        'description' => 'Parlez-moi de votre projet de site internet ou d\'application : réponse sous 48 h et devis gratuit.',
        'nav'         => false,
    ],
    'mentions-legales' => [
        'path'        => '/mentions-legales.php',
        'label'       => 'Mentions légales',
        'title'       => 'Mentions légales | SolvR',
        'description' => 'Mentions légales du site SolvR : éditeur, hébergeur et informations légales.',
        'nav'         => false,
    ],
    'confidentialite' => [
        'path'        => '/confidentialite.php',
        'label'       => 'Confidentialité',
        'title'       => 'Politique de confidentialité | SolvR',
        'description' => 'Comment SolvR collecte et protège vos données personnelles, et comment exercer vos droits.',
        'nav'         => false,
    ],
];