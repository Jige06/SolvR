<?php
$currentPage = 'a-propos';
$technologies = require __DIR__ . '/includes/technologies.php';

require __DIR__ . '/includes/head.php';
require __DIR__ . '/includes/header.php';
?>

<main id="contenu">

    <!-- ========== EN-TÊTE ========== -->
    <section class="hero section" aria-labelledby="page-titre">
        <div class="container">
            <div class="row align-items-center gy-5 gx-lg-5">
                <div class="col-12 col-lg-7">
                    <p class="hero-surtitre">À propos</p>
                    <h1 id="page-titre" class="display-5 fw-bold">Un développeur qui connaît le terrain</h1>
                    <p class="lead mt-3">
                        <strong>SolvR</strong>, c'est le « solveur » : celui qui trouve des solutions.
                        C'est exactement mon métier : comprendre votre besoin, puis concevoir l'outil numérique qui y répond.
                    </p>
                    <p class="lead mb-0">
                        Pendant 17 ans, j'ai travaillé aux côtés d'artisans, de commerçants et de dirigeants de PME.
                        Aujourd'hui, je mets cette expérience au service de leurs projets : des sites internet qui
                        les rendent visibles, et des applications qui leur font gagner du temps au quotidien.
                    </p>
                </div>

                <div class="col-8 col-sm-6 col-lg-4 offset-lg-1 mx-auto mx-lg-0">
                    <!-- À remplacer par ta photo quand elle sera prête :
                    <img src="/assets/img/portrait-developpeur-web-nice.webp"
                         alt="Portrait du fondateur de SolvR, développeur web à Nice"
                         width="800" height="1000" class="img-fluid portrait">
                    -->
                    <div class="ratio media-placeholder" style="--bs-aspect-ratio: 125%;">
                        <div class="d-flex align-items-center justify-content-center">Photo à venir</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ========== PARCOURS ========== -->
    <section class="section section-alt" aria-labelledby="parcours-titre">
        <div class="container">
            <div class="col-lg-9">
                <h2 id="parcours-titre" class="section-titre">Mon parcours</h2>

                <ol class="parcours">
                    <li>
                        <span class="parcours-icone" aria-hidden="true"><?= icon('flask') ?></span>
                        <h3 class="h5">La rigueur scientifique</h3>
                        <p class="mb-0">
                            Titulaire d'un master 2 en chimie et électrochimie des matériaux, j'ai travaillé deux ans
                            dans un laboratoire de recherche du CNRS. J'y ai appris la méthode : analyser, tester,
                            mesurer, et recommencer jusqu'à ce que ça fonctionne.
                        </p>
                    </li>
                    <li>
                        <span class="parcours-icone" aria-hidden="true"><?= icon('shop') ?></span>
                        <h3 class="h5">17 ans dans le commerce</h3>
                        <p class="mb-0">
                            J'ai ensuite choisi le terrain : pendant 17 ans, j'ai été responsable d'un magasin de peinture
                            pour le bâtiment, au service des artisans peintres et des entreprises du second œuvre. Conseil,
                            relation client, gestion d'équipe et de stocks, objectifs : je connais les contraintes des
                            artisans, des TPE et des PME, parce que je les ai vécues au quotidien.
                        </p>
                    </li>
                    <li>
                        <span class="parcours-icone" aria-hidden="true"><?= icon('code') ?></span>
                        <h3 class="h5">Le développement web</h3>
                        <p class="mb-0">
                            Pour changer de mode de vie et construire un projet qui me ressemble, je me suis reconverti :
                            j'ai obtenu le titre professionnel de Développeur Web et Web Mobile, puis j'ai créé SolvR.
                        </p>
                    </li>
                </ol>
            </div>
        </div>
    </section>

    <!-- ========== CE QUE ÇA CHANGE POUR VOUS ========== -->
    <section class="section" aria-labelledby="apport-titre">
        <div class="container">
            <h2 id="apport-titre" class="section-titre">Ce que ça change pour vous</h2>

            <div class="row g-4">
                <div class="col-12 col-lg-4">
                    <div class="encart h-100">
                        <span class="service-icon"><?= icon('chat') ?></span>
                        <h3 class="h5">Je parle votre langage</h3>
                        <p class="mb-0">Pas de jargon technique : je comprends vos priorités de chef d'entreprise et je vous explique chaque choix simplement.</p>
                    </div>
                </div>
                <div class="col-12 col-lg-4">
                    <div class="encart h-100">
                        <span class="service-icon"><?= icon('clipboard') ?></span>
                        <h3 class="h5">Un travail rigoureux</h3>
                        <p class="mb-0">La méthode héritée de la recherche : chaque fonctionnalité est pensée, testée et vérifiée avant d'arriver chez vous.</p>
                    </div>
                </div>
                <div class="col-12 col-lg-4">
                    <div class="encart h-100">
                        <span class="service-icon"><?= icon('person-check') ?></span>
                        <h3 class="h5">Un seul interlocuteur, de A à Z</h3>
                        <p class="mb-0">De l'écoute de votre besoin jusqu'à la mise en ligne et au suivi, vous parlez toujours à la même personne.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ========== MA FAÇON DE TRAVAILLER ========== -->
    <section class="section section-alt" aria-labelledby="methode-titre">
        <div class="container">
            <div class="row gy-5 gx-lg-5">
                <div class="col-12 col-lg-6">
                    <h2 id="methode-titre" class="section-titre">Ma façon de travailler</h2>
                    <ul class="list-unstyled atouts mb-0">
                        <li><?= icon('check', 'icon-accent') ?> <span><strong>À l'écoute</strong> : je commence toujours par comprendre votre activité, vos clients et vos objectifs.</span></li>
                        <li><?= icon('check', 'icon-accent') ?> <span><strong>Transparent</strong> : un devis clair et détaillé, sans mauvaise surprise.</span></li>
                        <li><?= icon('check', 'icon-accent') ?> <span><strong>Sur mesure</strong> : pas de modèle tout fait, une solution pensée pour vous.</span></li>
                        <li><?= icon('check', 'icon-accent') ?> <span><strong>Exigeant</strong> : des sites rapides, accessibles à tous et bien référencés.</span></li>
                        <li><?= icon('check', 'icon-accent') ?> <span><strong>Présent après la livraison</strong> : je vous accompagne dans la prise en main et l'évolution de votre site.</span></li>
                    </ul>
                </div>

                <div class="col-12 col-lg-6">
                    <h2 class="section-titre">Mes outils</h2>
                    <p>
                        Je travaille avec des technologies standards et éprouvées, connues de tous les développeurs :
                        votre site reste facile à faire évoluer.
                    </p>
                    <ul class="technos mt-4">
                        <?php foreach ($technologies as $tech): ?>
                            <li>
                                <svg class="techno-logo" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true" focusable="false">
                                    <path d="<?= $tech['path'] ?>" />
                                </svg>
                                <span><?= e($tech['label']) ?></span>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- ========== EN DEHORS DU CODE ========== -->
    <section class="section" aria-labelledby="perso-titre">
        <div class="container">
            <div class="col-lg-9">
                <h2 id="perso-titre" class="section-titre">En dehors du code</h2>
                <p>
                    Originaire de Picardie, je vis dans les Alpes-Maritimes depuis 17 ans et je ne m'en lasse pas :
                    la mer, le soleil, les collines, le relief… C'est ici que j'ai choisi de vivre, et c'est ici que
                    je veux accompagner les entreprises.
                </p>
                <p class="mb-0">
                    Ce relief, je le parcours aussi en courant : le trail est ma façon de décompresser. Une discipline
                    qui demande de l'endurance, de la préparation et de la régularité… des qualités qui servent aussi
                    à mener un projet web jusqu'au bout.
                </p>
            </div>
        </div>
    </section>

    <?php require __DIR__ . '/includes/cta.php'; ?>

</main>

<?php require __DIR__ . '/includes/footer.php'; ?>