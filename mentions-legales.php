<?php
$currentPage = 'mentions-legales';
require_once __DIR__ . '/includes/functions.php';

$legal   = config()['legal'];
$contact = config()['contact'];

require __DIR__ . '/includes/head.php';
require __DIR__ . '/includes/header.php';
?>

<main id="contenu">
    <section class="section page-legale" aria-labelledby="page-titre">
        <div class="container">
            <div class="col-lg-9 col-xl-8">
                <h1 id="page-titre" class="mb-2">Mentions légales</h1>
                <p class="text-body-secondary mb-5">Dernière mise à jour : <?= e($legal['updated']) ?></p>

                <h2>Éditeur du site</h2>
                <dl class="infos-legales">
                    <dt>Responsable</dt>
                    <dd><?= legalValue($legal['editor']['name']) ?></dd>

                    <dt>Statut</dt>
                    <dd><?= legalValue($legal['editor']['status']) ?></dd>

                    <dt>Adresse</dt>
                    <dd><?= legalValue($legal['editor']['address']) ?></dd>

                    <dt>SIREN</dt>
                    <dd><?= legalValue($legal['editor']['siren']) ?></dd>

                    <?php if ($legal['editor']['tva'] !== ''): ?>
                        <dt>N° de TVA intracommunautaire</dt>
                        <dd><?= legalValue($legal['editor']['tva']) ?></dd>
                    <?php endif; ?>

                    <dt>E-mail</dt>
                    <dd><a href="mailto:<?= e($contact['email']) ?>"><?= e($contact['email']) ?></a></dd>

                    <dt>Téléphone</dt>
                    <dd><a href="tel:<?= e($contact['phone_link']) ?>"><?= e($contact['phone']) ?></a></dd>
                </dl>

                <h2>Directeur de la publication</h2>
                <p><?= legalValue($legal['editor']['name']) ?></p>

                <h2>Hébergement</h2>
                <dl class="infos-legales">
                    <dt>Hébergeur</dt>
                    <dd><?= legalValue($legal['host']['name']) ?></dd>

                    <dt>Adresse</dt>
                    <dd><?= legalValue($legal['host']['address']) ?></dd>

                    <dt>Téléphone</dt>
                    <dd><?= legalValue($legal['host']['phone']) ?></dd>
                </dl>

                <h2>Propriété intellectuelle</h2>
                <p>
                    Les textes, le logo et la conception de ce site sont la propriété de SolvR.
                    Toute reproduction, totale ou partielle, sans autorisation préalable est interdite.
                </p>
                <p>Ressources tierces utilisées, dans le respect de leur licence :</p>
                <ul>
                    <li>illustrations : <a href="https://undraw.co/">unDraw</a> (licence unDraw) ;</li>
                    <li>icônes : <a href="https://icons.getbootstrap.com/">Bootstrap Icons</a> (licence MIT) ;</li>
                    <li>logos des technologies : <a href="https://simpleicons.org/">Simple Icons</a> (licence CC0) ;</li>
                    <li>polices : Heebo et Inter (licence SIL Open Font License).</li>
                </ul>

                <h2>Données personnelles</h2>
                <p>
                    Les informations transmises via le formulaire de contact sont traitées conformément au
                    Règlement général sur la protection des données (RGPD). Pour tout savoir sur la gestion
                    de vos données et vos droits, consultez la
                    <a href="<?= e($pages['confidentialite']['path']) ?>">politique de confidentialité</a>.
                </p>

                <h2>Cookies</h2>
                <p class="mb-0">
                    Ce site n'utilise aucun cookie publicitaire ni outil de mesure d'audience.
                    Seuls des éléments strictement nécessaires à son fonctionnement sont utilisés : ils sont
                    détaillés dans la <a href="<?= e($pages['confidentialite']['path']) ?>#cookies">politique de confidentialité</a>.
                </p>
            </div>
        </div>
    </section>
</main>

<?php require __DIR__ . '/includes/footer.php'; ?>
