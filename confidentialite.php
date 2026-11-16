<?php
$currentPage = 'confidentialite';
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
                <h1 id="page-titre" class="mb-2">Politique de confidentialité</h1>
                <p class="text-body-secondary mb-4">Dernière mise à jour : <?= e($legal['updated']) ?></p>

                <p class="lead mb-5">
                    Je collecte uniquement les données nécessaires pour répondre à vos demandes.
                    Elles ne sont jamais vendues, ni utilisées à des fins publicitaires.
                </p>

                <h2>Responsable du traitement</h2>
                <p>
                    <?= legalValue($legal['editor']['name']) ?>, entrepreneur individuel exerçant sous le nom SolvR,
                    <?= legalValue($legal['editor']['address']) ?>.<br>
                    Contact : <a href="mailto:<?= e($contact['email']) ?>"><?= e($contact['email']) ?></a>
                </p>

                <h2>Données collectées</h2>
                <p>Lorsque vous utilisez le formulaire de contact, les données suivantes sont collectées :</p>
                <ul>
                    <li>votre nom et votre adresse e-mail (obligatoires) ;</li>
                    <li>votre numéro de téléphone (facultatif) ;</li>
                    <li>le type de projet et le contenu de votre message.</li>
                </ul>
                <p>
                    Comme sur tout site internet, l'hébergeur enregistre aussi des données techniques de connexion
                    (adresse IP, date et heure, page consultée), utilisées uniquement pour la sécurité et le bon
                    fonctionnement du site.
                </p>

                <h2>Pourquoi et sur quelle base légale</h2>
                <div class="table-responsive">
                    <table class="table tableau-legal">
                        <caption class="visually-hidden">Finalités des traitements et bases légales</caption>
                        <thead>
                            <tr>
                                <th scope="col">Finalité</th>
                                <th scope="col">Base légale (RGPD, article 6)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Répondre à votre demande et, le cas échéant, établir un devis</td>
                                <td>Mesures précontractuelles prises à votre demande</td>
                            </tr>
                            <tr>
                                <td>Protéger le formulaire contre les envois automatisés (spam) et assurer la sécurité du site</td>
                                <td>Intérêt légitime</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <h2>Durée de conservation</h2>
                <p>
                    Les données transmises via le formulaire sont conservées <strong>3 ans au plus à compter de
                    notre dernier échange</strong>, puis supprimées. Si votre demande aboutit à une collaboration,
                    les documents commerciaux et comptables (devis, factures) sont conservés pendant les durées
                    imposées par la loi.
                </p>

                <h2>Destinataires</h2>
                <p>
                    Vos données sont destinées uniquement à SolvR. Elles transitent par des prestataires techniques
                    qui agissent pour mon compte et ne peuvent pas les utiliser à d'autres fins :
                </p>
                <ul>
                    <li>l'hébergeur du site : <?= legalValue($legal['host']['name']) ?> ;</li>
                    <li>le prestataire d'envoi des e-mails : <?= legalValue($legal['mail_provider']) ?>.</li>
                </ul>
                <p>Vos données ne sont ni vendues, ni louées, ni cédées à des tiers.</p>

                <h2 id="cookies">Cookies et stockage local</h2>
                <p>
                    Ce site n'utilise <strong>aucun cookie publicitaire ni outil de mesure d'audience</strong>,
                    et ne charge aucune ressource depuis un service tiers (polices, bibliothèques…).
                    Seuls deux éléments strictement nécessaires sont utilisés, ce qui ne demande pas votre consentement :
                </p>
                <div class="table-responsive">
                    <table class="table tableau-legal">
                        <caption class="visually-hidden">Cookies et stockage local utilisés par le site</caption>
                        <thead>
                            <tr>
                                <th scope="col">Nom</th>
                                <th scope="col">Rôle</th>
                                <th scope="col">Durée</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><code>PHPSESSID</code> (cookie)</td>
                                <td>Sécuriser l'envoi du formulaire de contact (protection contre les envois frauduleux)</td>
                                <td>Supprimé à la fermeture du navigateur</td>
                            </tr>
                            <tr>
                                <td><code>solvr-theme</code> (stockage local)</td>
                                <td>Mémoriser votre choix de thème clair ou sombre. Reste sur votre appareil, jamais transmis.</td>
                                <td>Jusqu'à ce que vous l'effaciez</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <h2>Sécurité</h2>
                <p>
                    Le site est accessible en connexion chiffrée (HTTPS), et le formulaire est protégé contre les
                    envois frauduleux et automatisés. L'accès aux messages reçus est limité au seul responsable du site.
                </p>

                <h2>Vos droits</h2>
                <p>Conformément au RGPD, vous disposez des droits suivants sur vos données :</p>
                <ul>
                    <li>droit d'accès et de rectification ;</li>
                    <li>droit à l'effacement ;</li>
                    <li>droit à la limitation du traitement et droit d'opposition ;</li>
                    <li>droit à la portabilité.</li>
                </ul>
                <p>
                    Pour les exercer, écrivez-moi à <a href="mailto:<?= e($contact['email']) ?>"><?= e($contact['email']) ?></a>.
                    Je vous réponds dans un délai d'un mois.
                </p>
                <p class="mb-0">
                    Si vous estimez, après m'avoir contacté, que vos droits ne sont pas respectés, vous pouvez
                    adresser une réclamation à la <a href="https://www.cnil.fr/fr/plaintes">CNIL</a>.
                </p>
            </div>
        </div>
    </section>
</main>

<?php require __DIR__ . '/includes/footer.php'; ?>