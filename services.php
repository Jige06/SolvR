<?php

declare(strict_types=1);

$currentPage = 'services';

require __DIR__ . '/includes/head.php';
require __DIR__ . '/includes/header.php';
?>

<main id="contenu">

    <!-- ========== EN-TÊTE DE PAGE ========== -->
    <section class="hero section" aria-labelledby="page-titre">
        <div class="container">
            <div class="col-lg-9">
                <p class="hero-surtitre">Mes services</p>
                <h1 id="page-titre" class="display-5 fw-bold" data-entree="1">
                    Création de sites internet et d'applications sur mesure à Nice
                </h1>
                <p class="lead mt-3" data-entree="2">
                    Que vous ayez besoin d'être visible sur Google, de vendre en ligne ou de gagner du temps
                    au quotidien, je vous propose une solution adaptée à votre activité et à votre budget.
                </p>

                <nav class="mt-4" aria-label="Sur cette page" data-entree="3">
                    <ul class="sommaire list-unstyled d-flex flex-wrap gap-2 mb-0">
                        <li><a href="#site-vitrine"><?= icon('laptop') ?> Site vitrine</a></li>
                        <li><a href="#site-ecommerce"><?= icon('cart') ?> Site e-commerce</a></li>
                        <li><a href="#application-sur-mesure"><?= icon('phone') ?> Application sur mesure</a></li>
                    </ul>
                </nav>
            </div>
        </div>
    </section>

    <!-- ========== SITE VITRINE ========== -->
    <section id="site-vitrine" class="section section-alt" aria-labelledby="vitrine-titre">
        <div class="container">
            <div class="row gy-4 gx-lg-5 align-items-start" data-reveal-groupe>
                <div class="col-12 col-lg-7">
                    <span class="service-icon"><?= icon('laptop') ?></span>
                    <h2 id="vitrine-titre">Site vitrine</h2>
                    <p class="lead">Votre carte de visite en ligne, disponible jour et nuit.</p>
                    <p>
                        Un site vitrine présente votre entreprise, vos services et vos coordonnées. C'est souvent
                        le premier contact avec un futur client : il doit inspirer confiance en quelques secondes
                        et vous rendre facile à trouver sur Google.
                    </p>

                    <h3 class="h5 mt-4">Ce qui est inclus</h3>
                    <ul class="list-unstyled atouts mt-3 mb-0">
                        <li><?= icon('check', 'icon-accent') ?> <span>Un design sur mesure, à vos couleurs</span></li>
                        <li><?= icon('check', 'icon-accent') ?> <span>Les pages essentielles : accueil, services, réalisations, contact…</span></li>
                        <li><?= icon('check', 'icon-accent') ?> <span>Un formulaire de contact sécurisé</span></li>
                        <li><?= icon('check', 'icon-accent') ?> <span>L'optimisation pour Google et le référencement local</span></li>
                        <li><?= icon('check', 'icon-accent') ?> <span>Les mentions légales et la conformité RGPD</span></li>
                    </ul>
                </div>

                <div class="col-12 col-lg-5">
                    <div class="mb-4">
                        <?= zoomableImage(
                            '/assets/img/services/vitrine-etre-trouve.webp',
                            "Recherche « plombier Nice » sur un téléphone : la fiche « Votre entreprise » apparaît en premier résultat, avec ses avis et un bouton Appeler, et un client appelle",
                            1200, 900,
                            sizes: 'offer'
                        ) ?>
                    </div>
                    <div class="encart carte-survol">
                        <h3 class="h5 d-flex align-items-center gap-2">
                            <?= icon('people', 'icon-accent') ?> Idéal pour<span class="visually-hidden"> un site vitrine</span>
                        </h3>
                        <p class="mb-0">Artisans, commerçants, professions libérales, restaurants, associations… toute activité qui veut être trouvée et contactée facilement.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ========== SITE E-COMMERCE ========== -->
    <section id="site-ecommerce" class="section" aria-labelledby="ecommerce-titre">
        <div class="container">
            <div class="row gy-4 gx-lg-5 align-items-start" data-reveal-groupe>
                <div class="col-12 col-lg-7 order-lg-2">
                    <span class="service-icon"><?= icon('cart') ?></span>
                    <h2 id="ecommerce-titre">Site e-commerce</h2>
                    <p class="lead">Vendez vos produits en ligne, même quand votre boutique est fermée.</p>
                    <p>
                        Une boutique en ligne vous ouvre à de nouveaux clients, au-delà de votre quartier.
                        Vous gérez vos produits, vos stocks et vos commandes depuis un espace simple,
                        et vos clients paient en toute sécurité.
                    </p>

                    <h3 class="h5 mt-4">Ce qui est inclus</h3>
                    <ul class="list-unstyled atouts mt-3 mb-0">
                        <li><?= icon('check', 'icon-accent') ?> <span>Un catalogue de produits avec photos et fiches détaillées</span></li>
                        <li><?= icon('check', 'icon-accent') ?> <span>Un panier et un paiement en ligne sécurisé</span></li>
                        <li><?= icon('check', 'icon-accent') ?> <span>Un espace de gestion des produits, des stocks et des commandes</span></li>
                        <li><?= icon('check', 'icon-accent') ?> <span>Des e-mails de confirmation automatiques pour vos clients</span></li>
                        <li><?= icon('check', 'icon-accent') ?> <span>Les conditions générales de vente et les obligations légales</span></li>
                    </ul>
                </div>

                <div class="col-12 col-lg-5 order-lg-1">
                    <div class="mb-4">
                        <?= zoomableImage(
                            '/assets/img/services/ecommerce-commande-nuit.webp',
                            "Page produit d'une boutique en ligne avec le bouton « Ajouter au panier », et une notification de nouvelle commande reçue à 23 h 47",
                            1200, 900,
                            sizes: 'offer'
                        ) ?>
                    </div>
                    <div class="encart carte-survol">
                        <h3 class="h5 d-flex align-items-center gap-2">
                            <?= icon('people', 'icon-accent') ?> Idéal pour<span class="visually-hidden"> un site e-commerce</span>
                        </h3>
                        <p class="mb-0">Commerçants, créateurs, producteurs locaux… toute activité qui veut vendre au-delà de sa boutique physique.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ========== APPLICATION SUR MESURE ========== -->
    <section id="application-sur-mesure" class="section section-alt" aria-labelledby="app-titre">
        <div class="container">
            <div class="row gy-4 gx-lg-5 align-items-start" data-reveal-groupe>
                <div class="col-12 col-lg-7">
                    <span class="service-icon"><?= icon('phone') ?></span>
                    <h2 id="app-titre">Application sur mesure</h2>
                    <p class="lead">Un outil pensé pour votre façon de travailler.</p>
                    <p>
                        Quand les logiciels du marché ne correspondent pas à votre activité, une application
                        sur mesure s'adapte à vous, et pas l'inverse. Elle automatise les tâches répétitives
                        et vous fait gagner du temps chaque jour.
                    </p>

                    <h3 class="h5 mt-4">Quelques exemples</h3>
                    <ul class="list-unstyled atouts mt-3 mb-0">
                        <li><?= icon('check', 'icon-accent') ?> <span>La prise de commande en ligne</span></li>
                        <li><?= icon('check', 'icon-accent') ?> <span>La réservation et la prise de rendez-vous</span></li>
                        <li><?= icon('check', 'icon-accent') ?> <span>Un espace client ou un espace employé</span></li>
                        <li><?= icon('check', 'icon-accent') ?> <span>La gestion des plannings, des stocks ou des devis</span></li>
                        <li><?= icon('check', 'icon-accent') ?> <span>Un tableau de bord pour suivre votre activité</span></li>
                    </ul>
                </div>

                <div class="col-12 col-lg-5">
                    <div class="mb-4">
                        <?= zoomableImage(
                            '/assets/img/realisations/traiteur/gerants-statistiques.webp',
                            "Tableau de bord de l'application Vite & Gourmand sur ordinateur et téléphone : graphiques des commandes et du chiffre d'affaires par menu",
                            1200, 900,
                            sizes: 'offer'
                        ) ?>
                    </div>
                    <div class="encart carte-survol">
                        <h3 class="h5 d-flex align-items-center gap-2">
                            <?= icon('people', 'icon-accent') ?> Idéal pour<span class="visually-hidden"> une application sur mesure</span>
                        </h3>
                        <p>PME, restaurateurs, traiteurs, prestataires de services… toute entreprise qui perd du temps sur des tâches répétitives.</p>
                        <a class="link-fleche" href="<?= e($pages['realisations']['path']) ?>#traiteur">
                            Voir un exemple : l'application traiteur <?= icon('arrow-right') ?>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ========== DE L'IDÉE AU SITE ========== -->
    <section class="section" aria-labelledby="idee-titre">
        <div class="container">
            <h2 id="idee-titre" class="section-titre" data-reveal>De l'idée au site en ligne</h2>
            <p class="lead mb-5" data-reveal>
                Avant d'écrire la moindre ligne de code, on construit votre site pas à pas.
                Voici les trois étapes, illustrées avec la page d'accueil de ce site.
            </p>

            <ol class="list-unstyled row g-4 g-lg-5 mb-0 etapes-projet" data-reveal-groupe>
                <li class="col-12 col-md-4">
                    <figure class="mb-0">
                        <?= zoomableImage(
                            '/assets/img/de-l-idee-au-site/1-croquis.webp',
                            "Croquis au crayon de la page d'accueil de SolvR : l'emplacement du titre, du texte, des boutons et de l'illustration",
                            1200, 900,
                            sizes: 'step'
                        ) ?>
                        <figcaption>
                            <h3 class="h5 d-flex align-items-center gap-2"><span class="etape-numero" aria-hidden="true">1</span> Le croquis</h3>
                            <p class="mb-0">On organise ensemble le contenu de chaque page : ce qu'il faut montrer, et dans quel ordre. Rien n'est encore figé.</p>
                        </figcaption>
                    </figure>
                </li>
                <li class="col-12 col-md-4">
                    <figure class="mb-0">
                        <?= zoomableImage(
                            '/assets/img/de-l-idee-au-site/2-maquette.webp',
                            "Maquette de la page d'accueil de SolvR dans un logiciel de design, avec les couleurs, les typographies et les boutons du site",
                            1200, 900,
                            sizes: 'step'
                        ) ?>
                        <figcaption>
                            <h3 class="h5 d-flex align-items-center gap-2"><span class="etape-numero" aria-hidden="true">2</span> La maquette</h3>
                            <p class="mb-0">Je mets en forme votre site à vos couleurs : typographies, boutons, espacements. Vous validez avant la première ligne de code.</p>
                        </figcaption>
                    </figure>
                </li>
                <li class="col-12 col-md-4">
                    <figure class="mb-0">
                        <?= zoomableImage(
                            '/assets/img/de-l-idee-au-site/3-site-en-ligne.webp',
                            "La page d'accueil de SolvR en ligne, affichée sur un ordinateur et sur un téléphone",
                            1200, 900,
                            sizes: 'step'
                        ) ?>
                        <figcaption>
                            <h3 class="h5 d-flex align-items-center gap-2"><span class="etape-numero" aria-hidden="true">3</span> Le site en ligne</h3>
                            <p class="mb-0">Je développe le site, adapté à tous les écrans, puis je le mets en ligne. Il ne reste plus qu'à le faire connaître.</p>
                        </figcaption>
                    </figure>
                </li>
            </ol>
        </div>
    </section>

    <!-- ========== INCLUS DANS CHAQUE PROJET ========== -->
    <section class="section section-alt" aria-labelledby="inclus-titre">
        <div class="container">
            <h2 id="inclus-titre" class="section-titre" data-reveal>Inclus dans chaque projet</h2>

            <ul class="list-unstyled row g-4 mb-0" data-reveal-groupe>
                <li class="col-12 col-sm-6 col-lg-4">
                    <span class="service-icon"><?= icon('phone') ?></span>
                    <h3 class="h5">Adapté au mobile</h3>
                    <p class="mb-0">Un affichage impeccable sur téléphone, tablette et ordinateur.</p>
                </li>
                <li class="col-12 col-sm-6 col-lg-4">
                    <span class="service-icon"><?= icon('access') ?></span>
                    <h3 class="h5">Accessible à tous</h3>
                    <p class="mb-0">Un site utilisable par tous vos clients, y compris les personnes en situation de handicap.</p>
                </li>
                <li class="col-12 col-sm-6 col-lg-4">
                    <span class="service-icon"><?= icon('search') ?></span>
                    <h3 class="h5">Pensé pour Google</h3>
                    <p class="mb-0">Une structure et des contenus optimisés pour être trouvé dans votre secteur.</p>
                </li>
                <li class="col-12 col-sm-6 col-lg-4">
                    <span class="service-icon"><?= icon('shield') ?></span>
                    <h3 class="h5">Sécurisé</h3>
                    <p class="mb-0">Connexion HTTPS, formulaires protégés et données de vos clients respectées.</p>
                </li>
                <li class="col-12 col-sm-6 col-lg-4">
                    <span class="service-icon"><?= icon('lightning') ?></span>
                    <h3 class="h5">Rapide</h3>
                    <p class="mb-0">Des pages légères qui s'affichent vite, même avec une connexion mobile.</p>
                </li>
                <li class="col-12 col-sm-6 col-lg-4">
                    <span class="service-icon"><?= icon('formation') ?></span>
                    <h3 class="h5">Prise en main</h3>
                    <p class="mb-0">Je vous explique comment utiliser votre site, simplement et sans jargon.</p>
                </li>
            </ul>
        </div>
    </section>

    <!-- ========== QUESTIONS FRÉQUENTES ========== -->
    <section class="section" aria-labelledby="faq-titre">
        <div class="container">
            <div class="col-lg-9 mx-auto">
                <h2 id="faq-titre" class="section-titre" data-reveal>Questions fréquentes</h2>

                <div class="faq" data-reveal-groupe>
                    <details>
                        <summary>Combien coûte un site internet ?</summary>
                        <div class="faq-reponse">
                            <p class="mb-0">Chaque projet est différent : le prix dépend du nombre de pages, des fonctionnalités et du contenu à créer. Après un premier échange, je vous remets un devis gratuit, détaillé et sans engagement.</p>
                        </div>
                    </details>

                    <details>
                        <summary>Combien de temps faut-il pour créer mon site ?</summary>
                        <div class="faq-reponse">
                            <p class="mb-0">Le délai dépend de l'ampleur du projet et de la rapidité avec laquelle les contenus (textes, photos) sont prêts. Il est précisé dans le devis, avec les grandes étapes du projet.</p>
                        </div>
                    </details>

                    <details>
                        <summary>Pourrai-je modifier mon site moi-même ?</summary>
                        <div class="faq-reponse">
                            <p class="mb-0">Selon vos besoins, je peux prévoir un espace d'administration pour modifier vous-même certains contenus (actualités, horaires, produits…), ou m'occuper des mises à jour pour vous.</p>
                        </div>
                    </details>

                    <details>
                        <summary>Qui s'occupe de l'hébergement et du nom de domaine ?</summary>
                        <div class="faq-reponse">
                            <p class="mb-0">Je vous accompagne dans leur choix et leur mise en place. Ils sont enregistrés au nom de votre entreprise : vous en restez propriétaire.</p>
                        </div>
                    </details>

                    <details>
                        <summary>Mon site sera-t-il bien placé sur Google ?</summary>
                        <div class="faq-reponse">
                            <p class="mb-0">Votre site est construit selon les bonnes pratiques du référencement : structure, rapidité, contenus, référencement local. Personne ne peut honnêtement garantir une première place, mais un site bien construit vous donne toutes les chances d'être trouvé.</p>
                        </div>
                    </details>

                    <details>
                        <summary>Et après la mise en ligne ?</summary>
                        <div class="faq-reponse">
                            <p class="mb-0">Je reste disponible pour répondre à vos questions, faire évoluer votre site et assurer sa maintenance (mises à jour, sauvegardes, sécurité).</p>
                        </div>
                    </details>
                </div>
            </div>
        </div>
    </section>

    <?php require __DIR__ . '/includes/cta.php'; ?>

</main>

<?php require __DIR__ . '/includes/footer.php'; ?>
