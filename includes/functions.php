<?php

declare(strict_types=1);

// Adresse officielle du site, à confirmer à l'achat du nom de domaine.
// Une constante, et non un réglage de config.php : les URL canoniques, le sitemap et les données
// structurées doivent toujours désigner le site en production, quel que soit l'environnement.
const SITE_URL = 'https://www.solvr.fr';

/**
 * Configuration du site (coordonnées, informations légales, SMTP).
 * Lit includes/config.php (non versionné). S'il manque, on s'arrête net plutôt que
 * d'utiliser le modèle config.example.php : en production, le site afficherait
 * de fausses coordonnées et enverrait les mails nulle part, sans que personne ne s'en aperçoive.
 * « static » : le fichier n'est lu qu'une seule fois, même si la fonction est appelée plusieurs fois.
 */
function config(): array
{
    static $config = null;

    if ($config === null) {
        $file = __DIR__ . '/config.php';

        if (!is_file($file)) {
            throw new RuntimeException(
                'includes/config.php introuvable : copier includes/config.example.php en config.php et le compléter.'
            );
        }

        $config = require $file;
    }

    return $config;
}

/**
 * Démarre une session avec un cookie sécurisé.
 * À appeler avant tout affichage : le cookie part dans les en-têtes HTTP.
 */
function startSecureSession(): void
{
    if (session_status() === PHP_SESSION_ACTIVE) {
        return;   // déjà démarrée : rien à faire
    }

    session_set_cookie_params([
        'httponly' => true,                       // cookie inaccessible au JavaScript
        'samesite' => 'Lax',                      // pas envoyé par les requêtes d'autres sites
        'secure'   => !empty($_SERVER['HTTPS']),  // HTTPS uniquement quand le site l'utilise
    ]);
    session_start();
}

/**
 * Échappe une valeur avant de l'afficher dans le HTML.
 * Protège contre les failles XSS : <script> devient &lt;script&gt;
 */
function e(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

/**
 * Retourne une icône SVG (tracés dans includes/icons.php).
 * L'icône prend la couleur du texte (currentColor) et la taille de la police (1em).
 * aria-hidden : icône décorative, ignorée par les lecteurs d'écran.
 */
function icon(string $name, string $class = ''): string
{
    static $paths = null;
    $paths ??= require __DIR__ . '/icons.php';   // fichier lu une seule fois, au premier appel

    if (!isset($paths[$name])) {
        return '';
    }

    return '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" width="1em" height="1em"'
        . ' fill="currentColor" aria-hidden="true" focusable="false" class="bi ' . e($class) . '">'
        . $paths[$name]
        . '</svg>';
}

/**
 * Affiche une information légale. Si la valeur est encore un emplacement à compléter
 * (elle commence par « [ »), elle est surlignée pour ne pas être oubliée avant la mise en ligne.
 */
function legalValue(string $value): string
{
    $safe = e($value);

    return str_starts_with($value, '[') ? '<mark>' . $safe . '</mark>' : $safe;
}

/**
 * Retourne le chemin d'un fichier statique avec sa date de modification,
 * pour forcer le navigateur à recharger le fichier quand il change.
 * Exemple : /assets/css/style.css?v=1732465000
 */
function asset(string $path): string
{
    $file = __DIR__ . '/..' . $path;
    $version = is_file($file) ? filemtime($file) : 0;

    return $path . '?v=' . $version;
}

/** Largeurs des variantes d'images (nom-480.webp, nom-800.webp), en plus de l'originale */
const IMAGE_WIDTHS = [480, 800];

/**
 * Largeur d'affichage des images selon leur colonne Bootstrap (attribut sizes).
 * Calculée à partir des conteneurs Bootstrap (540, 720, 960, 1140, 1320 px) et des gouttières :
 * le navigateur s'en sert pour choisir la plus petite variante assez nette.
 *
 * Première valeur : sur un téléphone de densité ×3, la largeur annoncée est multipliée par 0,67.
 * Il prend ainsi la variante de 800 px au lieu de l'originale : une densité ×2 suffit largement
 * pour des captures de cette taille, et la différence est invisible à l'œil.
 */
// phpcs:disable Generic.Files.LineLength -- valeurs sizes : une condition par écran, sur une ligne
const IMAGE_SIZES = [
    // Colonne col-lg-6 (accueil, en-tête de l'étude de cas)
    'half'  => '(max-width: 575.98px) and (min-resolution: 2.5dppx) calc((100vw - 24px) * 0.67), (min-width: 1400px) 612px, (min-width: 1200px) 522px, (min-width: 992px) 432px, (min-width: 768px) 696px, (min-width: 576px) 516px, calc(100vw - 24px)',
    // Colonne col-lg-5 (illustrations des offres, page Services)
    'offer' => '(max-width: 575.98px) and (min-resolution: 2.5dppx) calc((100vw - 24px) * 0.67), (min-width: 1400px) 502px, (min-width: 1200px) 427px, (min-width: 992px) 352px, (min-width: 768px) 696px, (min-width: 576px) 516px, calc(100vw - 24px)',
    // Encart dans une colonne col-lg-4 (captures « Un espace pour chacun »)
    'card'  => '(max-width: 575.98px) and (min-resolution: 2.5dppx) calc((100vw - 74px) * 0.67), (min-width: 1400px) 366px, (min-width: 1200px) 306px, (min-width: 992px) 246px, (min-width: 768px) 646px, (min-width: 576px) 466px, calc(100vw - 74px)',
    // Colonne col-md-4 (étapes « De l'idée au site »)
    'step'  => '(max-width: 575.98px) and (min-resolution: 2.5dppx) calc((100vw - 24px) * 0.67), (min-width: 1400px) 392px, (min-width: 1200px) 332px, (min-width: 992px) 272px, (min-width: 768px) 216px, (min-width: 576px) 516px, calc(100vw - 24px)',
];
// phpcs:enable Generic.Files.LineLength

/**
 * Liste des tailles disponibles d'une image (attribut srcset) : les variantes
 * présentes sur le disque, puis l'originale. Une variante absente est ignorée.
 * Exemple : /img/a-480.webp 480w, /img/a-800.webp 800w, /img/a.webp 1200w
 */
function responsiveSrcset(string $src, int $width): string
{
    $info    = pathinfo($src);
    $sources = [];

    foreach (IMAGE_WIDTHS as $variantWidth) {
        $variant = $info['dirname'] . '/' . $info['filename'] . '-' . $variantWidth . '.' . $info['extension'];

        if ($variantWidth < $width && is_file(__DIR__ . '/..' . $variant)) {
            $sources[] = $variant . ' ' . $variantWidth . 'w';
        }
    }

    $sources[] = $src . ' ' . $width . 'w';

    return implode(', ', $sources);
}

/**
 * Image responsive qui s'ouvre en grand au clic, dans la visionneuse (voir animations.js).
 * Le navigateur télécharge la variante adaptée à l'écran (srcset + sizes) ;
 * la visionneuse et le lien sans JavaScript ouvrent l'originale en pleine taille.
 * Le texte alternatif est passé en clair : il est échappé ici avec e().
 *
 * @param string $sizes Largeur d'affichage : une clé de IMAGE_SIZES ou une valeur sizes complète
 */
function zoomableImage(
    string $src,
    string $alt,
    int $width,
    int $height,
    string $class = 'img-fluid',
    bool $lazy = true,
    string $sizes = '100vw',
): string {
    $sizes = IMAGE_SIZES[$sizes] ?? $sizes;

    return '<a class="zoomable" href="' . e($src) . '" data-zoomable>'
        . '<img src="' . e($src) . '" srcset="' . e(responsiveSrcset($src, $width)) . '" sizes="' . e($sizes) . '"'
        . ' alt="' . e($alt) . '" width="' . $width . '" height="' . $height . '"'
        . ' class="' . e($class) . '"' . ($lazy ? ' loading="lazy"' : '') . '>'
        . '<span class="visually-hidden"> (agrandir l\'image)</span>'
        . '<span class="zoomable-badge" aria-hidden="true">' . icon('zoom') . '</span>'
        . '</a>';
}
