<?php
$currentPage = 'realisations';

// Liens externes du projet (un seul endroit à modifier si une URL change)
$demoUrl   = 'https://vite-et-gourmand.up.railway.app';
$githubUrl = 'https://github.com/Jige06/vite-et-gourmand';

require __DIR__ . '/includes/head.php';
require __DIR__ . '/includes/header.php';
?>

<main id="contenu">

    <!-- ========== EN-TÊTE DE PAGE ========== -->
    <section class="hero section" aria-labelledby="page-titre">
        <div class="container">
            <div class="col-lg-9">
                <p class="hero-surtitre">Réalisations</p>
                <h1 id="page-titre" class="display-5 fw-bold">
                    Des projets concrets, de la conception à la mise en ligne
                </h1>
                <p class="lead mt-3">
                    Je lance mon activité freelance. Voici un projet complet que j'ai conçu et développé seul
                    pendant ma formation de développeur web et web mobile : il montre ce que je peux
                    réaliser pour votre entreprise.
                </p>
            </div>
        </div>
    </section>

    <!-- ========== ÉTUDE DE CAS : VITE & GOURMAND ========== -->
    <article id="traiteur" aria-labelledby="traiteur-titre">

        <!-- Présentation -->
        <section class="section section-alt" aria-label="Présentation du projet">
            <div class="container">
                <div class="row align-items-center gy-5 gx-lg-5">
                    <div class="col-12 col-lg-6">
                        <ul class="tags mb-3">
                            <li>Projet de formation</li>
                            <li>Application web</li>
                            <li>Application installable</li>
                        </ul>

                        <h2 id="traiteur-titre">Vite &amp; Gourmand : la commande en ligne pour un traiteur</h2>
                        <p class="lead">
                            Une application web complète qui permet aux clients d'un traiteur bordelais de consulter
                            les menus et de commander en ligne, et à son équipe de tout gérer depuis un espace dédié.
                        </p>

                        <div class="d-flex flex-column flex-sm-row gap-3 mt-4">
                            <a class="btn btn-primary" href="<?= e($demoUrl) ?>">
                                Voir l'application en ligne <?= icon('external') ?>
                                <span class="visually-hidden">(site externe)</span>
                            </a>
                            <a class="btn btn-outline-primary" href="<?= e($githubUrl) ?>">
                                <?= icon('github') ?> Voir le code sur GitHub
                                <span class="visually-hidden">(site externe)</span>
                            </a>
                        </div>

                        <p class="etude-note mt-3 mb-0">
                            Cas client fictif, issu de l'examen du titre professionnel Développeur Web et Web Mobile (Studi).
                        </p>
                    </div>

                    <div class="col-12 col-lg-6">
                        <!-- À remplacer par une capture quand elle sera prête :
                        <img src="/assets/img/realisations/traiteur/vite-et-gourmand-accueil.webp"
                             alt="Page d'accueil de l'application Vite & Gourmand sur ordinateur et mobile"
                             width="1200" height="900" class="img-fluid rounded-4">
                        -->
                        <div class="ratio ratio-4x3 media-placeholder">
                            <div class="d-flex align-items-center justify-content-center">Capture à venir</div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Besoin et solution -->
        <section class="section" aria-labelledby="besoin-titre">
            <div class="container">
                <h3 id="besoin-titre" class="visually-hidden">Le besoin et la solution</h3>
                <div class="row gy-4 gx-lg-5">
                    <div class="col-12 col-lg-6">
                        <h4 class="h3">Le besoin</h4>
                        <p class="mb-0">
                            Julie et José, à la tête du traiteur Vite &amp; Gourmand, voulaient que leurs clients puissent
                            découvrir les menus et commander en ligne, sans passer par le téléphone. Ils avaient aussi
                            besoin d'un outil pour gérer les commandes, les menus et les avis avec leur équipe,
                            et pour suivre l'activité de l'entreprise.
                        </p>
                    </div>
                    <div class="col-12 col-lg-6">
                        <h4 class="h3">La solution</h4>
                        <p class="mb-0">
                            J'ai conçu et développé une application sur mesure, de la base de données jusqu'à la mise
                            en ligne : un site public pour les clients, un espace pour l'équipe et un tableau de bord
                            pour les gérants. Elle s'installe sur un téléphone comme une application, et les menus
                            restent consultables même sans connexion.
                        </p>
                    </div>
                </div>

                <!-- Un espace pour chacun -->
                <h3 class="h2 section-titre mt-5 pt-lg-4">Un espace pour chacun</h3>
                <div class="row g-4">
                    <div class="col-12 col-lg-4">
                        <div class="encart h-100">
                            <span class="service-icon"><?= icon('people') ?></span>
                            <h4 class="h5">Pour les clients</h4>
                            <ul class="list-unstyled atouts mt-3 mb-0">
                                <li><?= icon('check', 'icon-accent') ?> <span>Consultation des menus, avec filtres</span></li>
                                <li><?= icon('check', 'icon-accent') ?> <span>Commande en plusieurs étapes, avec calcul automatique des frais de livraison</span></li>
                                <li><?= icon('check', 'icon-accent') ?> <span>Suivi, modification ou annulation de ses commandes</span></li>
                                <li><?= icon('check', 'icon-accent') ?> <span>Avis après la prestation</span></li>
                                <li><?= icon('check', 'icon-accent') ?> <span>Compte sécurisé, mot de passe oublié par e-mail</span></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-12 col-lg-4">
                        <div class="encart h-100">
                            <span class="service-icon"><?= icon('team') ?></span>
                            <h4 class="h5">Pour l'équipe</h4>
                            <ul class="list-unstyled atouts mt-3 mb-0">
                                <li><?= icon('check', 'icon-accent') ?> <span>Suivi des commandes et mise à jour de leur statut</span></li>
                                <li><?= icon('check', 'icon-accent') ?> <span>Gestion des menus et des plats, avec photos</span></li>
                                <li><?= icon('check', 'icon-accent') ?> <span>Modération des avis clients</span></li>
                                <li><?= icon('check', 'icon-accent') ?> <span>Mise à jour des horaires d'ouverture</span></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-12 col-lg-4">
                        <div class="encart h-100">
                            <span class="service-icon"><?= icon('chart') ?></span>
                            <h4 class="h5">Pour les gérants</h4>
                            <ul class="list-unstyled atouts mt-3 mb-0">
                                <li><?= icon('check', 'icon-accent') ?> <span>Statistiques des commandes et du chiffre d'affaires, en graphiques</span></li>
                                <li><?= icon('check', 'icon-accent') ?> <span>Création des comptes des employés</span></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Sous le capot -->
        <section class="section section-alt" aria-labelledby="capot-titre">
            <div class="container">
                <h3 id="capot-titre" class="h2 section-titre mb-3">Sous le capot</h3>
                <p class="mb-5">Pour les plus curieux : les choix techniques du projet.</p>

                <div class="row gy-5 gx-lg-5">
                    <div class="col-12 col-lg-6">
                        <h4 class="h5">Technologies</h4>
                        <ul class="tags mt-3">
                            <li>PHP natif (POO, MVC)</li>
                            <li>MySQL</li>
                            <li>MongoDB</li>
                            <li>PDO</li>
                            <li>HTML5</li>
                            <li>CSS3</li>
                            <li>Bootstrap 5.3</li>
                            <li>JavaScript</li>
                            <li>Chart.js</li>
                            <li>PHPMailer</li>
                            <li>API OpenRouteService</li>
                            <li>PWA (service worker)</li>
                            <li>Docker</li>
                            <li>Railway</li>
                            <li>Git et GitHub</li>
                        </ul>
                    </div>
                    <div class="col-12 col-lg-6">
                        <h4 class="h5">Sécurité</h4>
                        <ul class="list-unstyled atouts mt-3 mb-0">
                            <li><?= icon('shield', 'icon-accent') ?> <span>Requêtes préparées contre les injections SQL</span></li>
                            <li><?= icon('shield', 'icon-accent') ?> <span>Mots de passe hachés (bcrypt)</span></li>
                            <li><?= icon('shield', 'icon-accent') ?> <span>Protection CSRF et XSS</span></li>
                            <li><?= icon('shield', 'icon-accent') ?> <span>Validation des données côté serveur et côté client</span></li>
                            <li><?= icon('shield', 'icon-accent') ?> <span>Contrôle d'accès par rôle et sessions sécurisées</span></li>
                            <li><?= icon('shield', 'icon-accent') ?> <span>Envoi de fichiers sécurisé (vérification du type réel)</span></li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>

    </article>

    <?php require __DIR__ . '/includes/cta.php'; ?>

</main>

<?php require __DIR__ . '/includes/footer.php'; ?>