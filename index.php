<?php
$currentPage = 'accueil';

require __DIR__ . '/includes/head.php';
require __DIR__ . '/includes/header.php';
?>

<main id="contenu">

    <!-- ========== HERO ========== -->
    <section class="hero section" aria-labelledby="hero-titre">
        <div class="container">
            <div class="row align-items-center gy-5">
                <div class="col-12 col-lg-7">
                    <p class="hero-surtitre">Développeur web freelance · Nice et Alpes-Maritimes</p>
                    <h1 id="hero-titre" class="display-5 fw-bold">
                        Des sites internet qui font grandir votre activité à Nice et dans les Alpes-Maritimes
                    </h1>
                    <p class="lead mt-3">
                        Artisans, commerçants, PME : je crée votre site vitrine, votre boutique en ligne
                        ou votre application sur mesure. Un seul interlocuteur, des explications claires,
                        un résultat à votre image.
                    </p>

                    <div class="d-flex flex-column flex-sm-row gap-3 mt-4">
                        <a class="btn btn-primary btn-lg" href="<?= e($pages['contact']['path']) ?>">Parlons de votre projet</a>
                        <a class="btn btn-outline-primary btn-lg" href="<?= e($pages['services']['path']) ?>">Découvrir mes services</a>
                    </div>

                    <ul class="hero-atouts list-unstyled d-flex flex-wrap gap-3 gap-md-4 mt-4 mb-0">
                        <li><?= icon('check', 'icon-accent') ?> Devis gratuit</li>
                        <li><?= icon('check', 'icon-accent') ?> Réponse sous 48 h</li>
                        <li><?= icon('check', 'icon-accent') ?> Sites pensés pour le mobile</li>
                    </ul>
                </div>

                <!-- Illustration décorative : affichée à partir du desktop uniquement -->
                <div class="col-lg-5 d-none d-lg-block">
                    <img src="/assets/img/hero-creation-site-internet.svg"
                        alt="" width="805" height="745" class="img-fluid">
                </div>
            </div>
        </div>
    </section>

    <!-- ========== SERVICES ========== -->
    <section class="section section-alt" aria-labelledby="services-titre">
        <div class="container">
            <h2 id="services-titre" class="section-titre">Ce que je peux faire pour vous</h2>

            <div class="row g-4">
                <div class="col-12 col-lg-4">
                    <article class="service-card h-100">
                        <span class="service-icon"><?= icon('laptop') ?></span>
                        <h3 class="h4">Site vitrine</h3>
                        <p>Présentez votre activité, vos horaires et vos réalisations, et soyez trouvé sur Google par les clients de votre secteur.</p>
                        <a class="link-fleche" href="<?= e($pages['services']['path']) ?>#site-vitrine">
                            En savoir plus<span class="visually-hidden"> sur les sites vitrines</span> <?= icon('arrow-right') ?>
                        </a>
                    </article>
                </div>

                <div class="col-12 col-lg-4">
                    <article class="service-card h-100">
                        <span class="service-icon"><?= icon('cart') ?></span>
                        <h3 class="h4">Site e-commerce</h3>
                        <p>Vendez vos produits en ligne, jour et nuit, avec un paiement sécurisé et une gestion simple de vos commandes.</p>
                        <a class="link-fleche" href="<?= e($pages['services']['path']) ?>#site-ecommerce">
                            En savoir plus<span class="visually-hidden"> sur les sites e-commerce</span> <?= icon('arrow-right') ?>
                        </a>
                    </article>
                </div>

                <div class="col-12 col-lg-4">
                    <article class="service-card h-100">
                        <span class="service-icon"><?= icon('phone') ?></span>
                        <h3 class="h4">Application sur mesure</h3>
                        <p>Prise de commande, réservation, espace client… Un outil pensé pour votre façon de travailler, qui vous fait gagner du temps.</p>
                        <a class="link-fleche" href="<?= e($pages['services']['path']) ?>#application-sur-mesure">
                            En savoir plus<span class="visually-hidden"> sur les applications sur mesure</span> <?= icon('arrow-right') ?>
                        </a>
                    </article>
                </div>
            </div>
        </div>
    </section>

    <!-- ========== RÉALISATION ========== -->
    <section class="section" aria-labelledby="realisation-titre">
        <div class="container">
            <div class="row align-items-center gy-4 gx-lg-5">
                <div class="col-12 col-lg-6">
                    <!-- À remplacer par la capture quand elle sera prête :
                    <img src="/assets/img/realisations/traiteur/traiteur-menus-mobile.webp"
                         alt="Capture de l'application traiteur : liste des menus sur mobile"
                         width="800" height="600" class="img-fluid rounded-4" loading="lazy">
                    -->
                    <div class="ratio ratio-4x3 media-placeholder">
                        <div class="d-flex align-items-center justify-content-center">Capture à venir</div>
                    </div>
                </div>

                <div class="col-12 col-lg-6">
                    <h2 id="realisation-titre" class="section-titre">Un exemple concret</h2>
                    <h3 class="h4">Application de commande en ligne pour un traiteur</h3>
                    <p>
                        Les clients consultent les menus et passent commande en ligne. Le traiteur et son équipe
                        gèrent les commandes et les menus depuis leur espace, sans appels téléphoniques à rallonge.
                    </p>
                    <p><span class="badge-formation">Projet réalisé en formation</span></p>
                    <a class="link-fleche" href="<?= e($pages['realisations']['path']) ?>#traiteur">
                        Voir l'étude de cas <?= icon('arrow-right') ?>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- ========== MÉTHODE ========== -->
    <section class="section section-alt" aria-labelledby="methode-titre">
        <div class="container">
            <h2 id="methode-titre" class="section-titre">Comment ça se passe ?</h2>

            <ol class="list-unstyled row g-4 mb-0">
                <li class="col-12 col-sm-6 col-lg-3 methode-etape">
                    <div class="methode-visuel" aria-hidden="true">
                        <?= icon('chat') ?>
                        <span class="methode-numero">1</span>
                    </div>
                    <h3 class="h5">On échange</h3>
                    <p class="mb-0">Vous me parlez de votre activité et de vos besoins, par téléphone ou en rendez-vous.</p>
                </li>
                <li class="col-12 col-sm-6 col-lg-3 methode-etape">
                    <div class="methode-visuel" aria-hidden="true">
                        <?= icon('devis') ?>
                        <span class="methode-numero">2</span>
                    </div>
                    <h3 class="h5">Je vous propose un devis</h3>
                    <p class="mb-0">Clair, détaillé, sans jargon. Gratuit et sans engagement.</p>
                </li>
                <li class="col-12 col-sm-6 col-lg-3 methode-etape">
                    <div class="methode-visuel" aria-hidden="true">
                        <?= icon('code') ?>
                        <span class="methode-numero">3</span>
                    </div>
                    <h3 class="h5">Je réalise votre projet</h3>
                    <p class="mb-0">Vous suivez l'avancement et validez chaque étape importante.</p>
                </li>
                <li class="col-12 col-sm-6 col-lg-3 methode-etape">
                    <div class="methode-visuel" aria-hidden="true">
                        <?= icon('rocket') ?>
                        <span class="methode-numero">4</span>
                    </div>
                    <h3 class="h5">Mise en ligne et suivi</h3>
                    <p class="mb-0">Je vous montre comment utiliser votre site et je reste disponible après la mise en ligne.</p>
                </li>
            </ol>
        </div>
    </section>

    <!-- ========== ZONE ========== -->
    <section class="section" aria-labelledby="zone-titre">
        <div class="container">
            <div class="row align-items-center gy-4 gx-lg-5">
                <div class="col-8 col-sm-6 col-md-5 col-lg-4 mx-auto mx-md-0">
                    <!-- À remplacer par ta photo quand elle sera prête :
                    <img src="/assets/img/portrait-developpeur-web-nice.webp"
                         alt="Portrait du fondateur de SolvR, développeur web à Nice"
                         width="800" height="1000" class="img-fluid portrait" loading="lazy">
                    -->
                    <div class="ratio media-placeholder" style="--bs-aspect-ratio: 125%;">
                        <div class="d-flex align-items-center justify-content-center">Photo à venir</div>
                    </div>
                </div>

                <div class="col-12 col-md-7 col-lg-8">
                    <h2 id="zone-titre" class="section-titre">Un développeur près de chez vous</h2>
                    <p class="d-flex gap-2">
                        <?= icon('geo', 'icon-accent flex-shrink-0 mt-1') ?>
                        <span>Basé à Nice, j'interviens dans tout le département : Nice, Antibes, Cannes, Grasse, Menton… et partout en France à distance.</span>
                    </p>

                    <ul class="list-unstyled atouts mt-4 mb-0">
                        <li><?= icon('check', 'icon-accent') ?> <span><strong>Un interlocuteur unique</strong> : vous parlez directement à la personne qui crée votre site.</span></li>
                        <li><?= icon('check', 'icon-accent') ?> <span><strong>Des sites rapides et accessibles</strong> : agréables pour tous vos visiteurs, et appréciés par Google.</span></li>
                        <li><?= icon('check', 'icon-accent') ?> <span><strong>Vous restez propriétaire</strong> de votre site et de votre nom de domaine.</span></li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- ========== APPEL À L'ACTION FINAL ========== -->
    <?php require __DIR__ . '/includes/cta.php'; ?>

</main>

<?php require __DIR__ . '/includes/footer.php'; ?>