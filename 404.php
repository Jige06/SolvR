<?php
// Envoie le vrai code HTTP 404 : les moteurs de recherche n'indexent pas cette page
http_response_code(404);

$currentPage = 'erreur-404';

require __DIR__ . '/includes/head.php';
require __DIR__ . '/includes/header.php';
?>

<main id="contenu">
    <section class="hero section page-404" aria-labelledby="page-titre">
        <div class="container text-center">
            <p class="code-erreur" aria-hidden="true">404</p>
            <h1 id="page-titre" class="display-6">Cette page est introuvable</h1>
            <p class="lead mt-3">
                Elle a peut-être été déplacée ou supprimée, ou l'adresse contient une faute de frappe.
            </p>

            <div class="d-flex flex-column flex-sm-row justify-content-center gap-3 mt-4">
                <a class="btn btn-primary btn-lg" href="<?= e($pages['accueil']['path']) ?>">Retour à l'accueil</a>
                <a class="btn btn-outline-primary btn-lg" href="<?= e($pages['contact']['path']) ?>">Me contacter</a>
            </div>
        </div>
    </section>
</main>

<?php require __DIR__ . '/includes/footer.php'; ?>
