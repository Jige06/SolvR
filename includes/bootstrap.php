<?php

/**
 * Démarrage commun : chargé en premier par chaque page (directement, ou via head.php).
 *
 * 1. Met la page en mémoire tampon avant de l'envoyer au navigateur.
 * 2. En production, remplace toute erreur fatale par la page 500.
 * 3. Charge les dépendances (Composer) et nos fonctions.
 */

declare(strict_types=1);

// 1. La page est construite en mémoire, puis envoyée d'un bloc à la fin du script.
//    Si une erreur survient au milieu, on peut jeter le début et afficher une page propre.
ob_start();

// 2. Erreurs fatales.
//    En développement (display_errors activé, comme dans notre Dockerfile), on ne change rien :
//    PHP affiche l'erreur détaillée, c'est ce qu'il faut pour corriger.
//    En production (display_errors désactivé), le visiteur voit la page 500,
//    et les détails partent dans le journal d'erreurs du serveur, jamais à l'écran.
if (!filter_var(ini_get('display_errors'), FILTER_VALIDATE_BOOL)) {
    $showErrorPage = static function (): void {
        while (ob_get_level() > 0) {
            ob_end_clean();                  // jette la page à moitié construite
        }

        if (!headers_sent()) {
            http_response_code(500);
            header('Content-Type: text/html; charset=UTF-8');   // même si la page prévoyait du XML (sitemap)
            header('Cache-Control: no-store');                  // une panne ne doit pas rester en cache
        }

        readfile(dirname(__DIR__) . '/500.html');
    };

    // Exception que personne n'a attrapée : on la note, puis on affiche la page 500
    set_exception_handler(static function (Throwable $exception) use ($showErrorPage): void {
        error_log('Exception non attrapée : ' . $exception);
        $showErrorPage();
    });

    // Erreur fatale (mémoire épuisée, erreur de syntaxe dans un fichier inclus…) :
    // ce n'est pas une exception, on la détecte à l'arrêt du script. PHP l'a déjà notée dans le journal.
    register_shutdown_function(static function () use ($showErrorPage): void {
        $error      = error_get_last();
        $fatalTypes = [E_ERROR, E_PARSE, E_CORE_ERROR, E_COMPILE_ERROR];

        if ($error !== null && in_array($error['type'], $fatalTypes, true)) {
            $showErrorPage();
        }
    });
}

// 3. Dépendances : l'autoload de Composer (PHPMailer et nos classes de src/), puis nos fonctions
require_once dirname(__DIR__) . '/vendor/autoload.php';
require_once __DIR__ . '/functions.php';
