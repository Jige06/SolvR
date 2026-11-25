<?php

declare(strict_types=1);

/**
 * Données structurées schema.org (JSON-LD), affichées sur la page d'accueil.
 * Elles décrivent l'entreprise et le site aux moteurs de recherche,
 * dans un format standard qu'ils comprennent sans avoir à deviner.
 *
 * Test : https://validator.schema.org (coller le code source de la page d'accueil).
 */
$contact = config()['contact'];

$structuredData = [
    '@context' => 'https://schema.org',
    '@graph'   => [
        [
            // L'entreprise : un prestataire de services local
            '@type'       => 'ProfessionalService',
            '@id'         => SITE_URL . '/#entreprise',
            'name'        => 'SolvR',
            'description' => $pages['accueil']['description'],
            'url'         => SITE_URL . '/',
            'email'       => $contact['email'],
            'telephone'   => $contact['phone_link'],
            'address'     => [
                '@type'           => 'PostalAddress',
                'addressLocality' => 'Nice',
                'addressRegion'   => 'Provence-Alpes-Côte d\'Azur',
                'addressCountry'  => 'FR',
            ],
            'areaServed'  => [
                ['@type' => 'AdministrativeArea', 'name' => 'Alpes-Maritimes'],
                ['@type' => 'Country', 'name' => 'France'],
            ],
            'hasOfferCatalog' => [
                '@type'           => 'OfferCatalog',
                'name'            => 'Services de développement web',
                'itemListElement' => array_map(
                    fn(string $service): array => [
                        '@type'       => 'Offer',
                        'itemOffered' => ['@type' => 'Service', 'name' => $service],
                    ],
                    ['Création de site vitrine', 'Création de site e-commerce', 'Application web sur mesure']
                ),
            ],
        ],
        [
            // Le site lui-même (aide Google à afficher le nom « SolvR » dans les résultats)
            '@type'      => 'WebSite',
            '@id'        => SITE_URL . '/#site',
            'name'       => 'SolvR',
            'url'        => SITE_URL . '/',
            'inLanguage' => 'fr-FR',
            'publisher'  => ['@id' => SITE_URL . '/#entreprise'],
        ],
    ],
];

// json_encode écrit un JSON toujours valide. JSON_HEX_TAG transforme < et > en < et > :
// une valeur contenant « </script> » ne pourrait pas refermer la balise et injecter du code.
$json = json_encode(
    $structuredData,
    JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_THROW_ON_ERROR
);
?>
    <!-- Données structurées : l'entreprise et le site (schema.org) -->
    <script type="application/ld+json">
<?= $json ?>

    </script>
