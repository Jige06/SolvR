<?php
declare(strict_types=1);

/* ==========================================================
   1. TRAITEMENT (avant tout affichage HTML)
   ========================================================== */

// Session sécurisée : nécessaire pour le jeton CSRF et le message de confirmation
session_set_cookie_params([
    'httponly' => true,                              // cookie inaccessible au JavaScript
    'samesite' => 'Lax',                             // pas envoyé par les requêtes d'autres sites
    'secure'   => !empty($_SERVER['HTTPS']),         // HTTPS uniquement quand le site l'utilise
]);
session_start();

require_once __DIR__ . '/vendor/autoload.php';      // PHPMailer + nos classes (src/)
require_once __DIR__ . '/includes/functions.php';
$pages  = require __DIR__ . '/includes/pages.php';
$config = require __DIR__ . '/includes/config.php';

$form   = new ContactForm();
$status = null;   // null | 'success' | 'invalid' | 'csrf' | 'send-error'

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (!CsrfToken::isValid($_POST['csrf_token'] ?? null)) {
        // Jeton absent ou faux : session expirée, ou tentative d'attaque CSRF
        $status = 'csrf';
        $form = new ContactForm($_POST);   // on garde la saisie pour ne pas la faire perdre

    } elseif (($_POST['site_web'] ?? '') !== '') {
        // Honeypot rempli : c'est un robot. On fait comme si tout s'était bien passé,
        // pour ne pas lui apprendre que son envoi a été bloqué.
        $_SESSION['contact_success'] = true;
        header('Location: ' . $pages['contact']['path'], true, 303);
        exit;

    } else {
        $form = new ContactForm($_POST);

        if (!$form->validate()) {
            $status = 'invalid';
        } else {
            try {
                (new ContactMailer($config))->send($form);

                // Post/Redirect/Get : on redirige pour qu'un F5 ne renvoie pas le formulaire
                $_SESSION['contact_success'] = true;
                header('Location: ' . $pages['contact']['path'], true, 303);
                exit;
            } catch (Throwable $exception) {
                // Le détail technique va dans le journal du serveur, jamais à l'écran
                error_log('Échec de l\'envoi du formulaire de contact : ' . $exception->getMessage());
                $status = 'send-error';
            }
        }
    }

} elseif (!empty($_SESSION['contact_success'])) {
    // Message de confirmation « flash » : affiché une seule fois après la redirection
    $status = 'success';
    unset($_SESSION['contact_success']);
}

/* ==========================================================
   2. AFFICHAGE
   ========================================================== */
$currentPage = 'contact';

// En cas d'erreur, le titre de l'onglet le signale (premier élément lu par un lecteur d'écran)
if (in_array($status, ['invalid', 'csrf', 'send-error'], true)) {
    $pageTitlePrefix = 'Erreur : ';
} elseif ($status === 'success') {
    $pageTitlePrefix = 'Message envoyé : ';
}

/**
 * Attributs d'accessibilité d'un champ selon qu'il est en erreur ou non.
 * Retourne par exemple : class="form-control is-invalid" aria-invalid="true" aria-describedby="nom-erreur"
 */
function fieldAttributes(ContactForm $form, string $field, string $baseClass = 'form-control', string $describedBy = ''): string
{
    $hasError = $form->getError($field) !== null;
    $ids = trim($describedBy . ($hasError ? ' ' . $field . '-erreur' : ''));

    return 'class="' . $baseClass . ($hasError ? ' is-invalid' : '') . '"'
        . ($hasError ? ' aria-invalid="true"' : '')
        . ($ids !== '' ? ' aria-describedby="' . $ids . '"' : '');
}

/** Message d'erreur sous un champ (rien si pas d'erreur) */
function fieldError(ContactForm $form, string $field): string
{
    $error = $form->getError($field);

    return $error === null
        ? ''
        : '<p id="' . $field . '-erreur" class="invalid-feedback d-block">' . e($error) . '</p>';
}

/** Libellés des champs, pour le récapitulatif des erreurs */
$fieldLabels = [
    'nom'       => 'Nom',
    'email'     => 'E-mail',
    'telephone' => 'Téléphone',
    'type'      => 'Type de projet',
    'message'   => 'Votre projet',
];

require __DIR__ . '/includes/head.php';
require __DIR__ . '/includes/header.php';
?>

<main id="contenu">

    <!-- ========== EN-TÊTE DE PAGE ========== -->
    <section class="hero section pb-4" aria-labelledby="page-titre">
        <div class="container">
            <div class="col-lg-9">
                <p class="hero-surtitre">Contact</p>
                <h1 id="page-titre" class="display-5 fw-bold">Parlons de votre projet</h1>
                <p class="lead mt-3 mb-0">
                    Décrivez-moi votre besoin en quelques lignes : je vous réponds sous 48 h.
                    Le devis est gratuit et sans engagement.
                </p>
            </div>
        </div>
    </section>

    <!-- ========== FORMULAIRE + COORDONNÉES ========== -->
    <section class="section pt-4" aria-labelledby="formulaire-titre">
        <div class="container">
            <div class="row gy-5 gx-lg-5">

                <!-- Formulaire -->
                <div class="col-12 col-lg-8">
                    <h2 id="formulaire-titre" class="visually-hidden">Formulaire de contact</h2>

                    <!-- Zone de messages : annoncée par les lecteurs d'écran -->
                    <div aria-live="polite">
                        <?php if ($status === 'success'): ?>
                            <div class="alert alert-success" role="status">
                                <p class="fw-bold mb-1">Merci, votre message a bien été envoyé !</p>
                                <p class="mb-0">Je vous réponds sous 48 h à l'adresse e-mail indiquée.</p>
                            </div>

                        <?php elseif ($status === 'invalid'): ?>
                            <div class="alert alert-danger" role="alert">
                                <p class="fw-bold mb-1">Le formulaire contient <?= count($form->getErrors()) ?> erreur(s) :</p>
                                <ul class="mb-0">
                                    <?php foreach ($form->getErrors() as $field => $error): ?>
                                        <li><a href="#<?= e($field) ?>" class="alert-link"><?= e($fieldLabels[$field] ?? $field) ?></a> : <?= e($error) ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>

                        <?php elseif ($status === 'csrf'): ?>
                            <div class="alert alert-danger" role="alert">
                                <p class="mb-0">Votre session a expiré. Vérifiez vos informations et renvoyez le formulaire.</p>
                            </div>

                        <?php elseif ($status === 'send-error'): ?>
                            <div class="alert alert-danger" role="alert">
                                <p class="mb-0">
                                    Désolé, votre message n'a pas pu être envoyé suite à un problème technique.
                                    Réessayez dans quelques minutes, ou contactez-moi directement par téléphone
                                    au <a href="tel:<?= e(CONTACT_PHONE_LINK) ?>" class="alert-link"><?= e(CONTACT_PHONE) ?></a>.
                                </p>
                            </div>
                        <?php endif; ?>
                    </div>

                    <p>Les champs marqués d'un astérisque (<span class="champ-requis">*</span>) sont obligatoires.</p>

                    <form action="<?= e($pages['contact']['path']) ?>" method="post" class="formulaire-contact">
                        <input type="hidden" name="csrf_token" value="<?= e(CsrfToken::get()) ?>">

                        <div class="row g-3">
                            <div class="col-12 col-md-6">
                                <label for="nom" class="form-label">Nom <span class="champ-requis">*</span></label>
                                <input type="text" id="nom" name="nom" required maxlength="100"
                                       autocomplete="name" value="<?= e($form->get('nom')) ?>"
                                       <?= fieldAttributes($form, 'nom') ?>>
                                <?= fieldError($form, 'nom') ?>
                            </div>

                            <div class="col-12 col-md-6">
                                <label for="email" class="form-label">E-mail <span class="champ-requis">*</span></label>
                                <input type="email" id="email" name="email" required maxlength="254"
                                       autocomplete="email" value="<?= e($form->get('email')) ?>"
                                       <?= fieldAttributes($form, 'email') ?>>
                                <?= fieldError($form, 'email') ?>
                            </div>

                            <div class="col-12 col-md-6">
                                <label for="telephone" class="form-label">Téléphone <span class="text-body-secondary">(facultatif)</span></label>
                                <p id="telephone-aide" class="form-text mt-0 mb-2">Format : 06 12 34 56 78</p>
                                <input type="tel" id="telephone" name="telephone" maxlength="17"
                                       pattern="(0|\+33 ?)[1-9]([ .\-]?\d{2}){4}"
                                       autocomplete="tel" value="<?= e($form->get('telephone')) ?>"
                                       <?= fieldAttributes($form, 'telephone', 'form-control', 'telephone-aide') ?>>
                                <?= fieldError($form, 'telephone') ?>
                            </div>

                            <div class="col-12 col-md-6">
                                <label for="type" class="form-label">Type de projet <span class="text-body-secondary">(facultatif)</span></label>
                                <select id="type" name="type" <?= fieldAttributes($form, 'type', 'form-select') ?>>
                                    <option value="">Choisir…</option>
                                    <?php foreach (ContactForm::PROJECT_TYPES as $value => $label): ?>
                                        <option value="<?= e($value) ?>" <?= $form->get('type') === $value ? 'selected' : '' ?>>
                                            <?= e($label) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <?= fieldError($form, 'type') ?>
                            </div>

                            <div class="col-12">
                                <label for="message" class="form-label">Votre projet <span class="champ-requis">*</span></label>
                                <p id="message-aide" class="form-text mt-0 mb-2">
                                    Votre activité, ce dont vous avez besoin, vos délais éventuels…
                                </p>
                                <textarea id="message" name="message" rows="6" required minlength="10" maxlength="5000"
                                          <?= fieldAttributes($form, 'message', 'form-control', 'message-aide') ?>><?= e($form->get('message')) ?></textarea>
                                <?= fieldError($form, 'message') ?>
                            </div>

                            <!-- Honeypot : invisible pour les humains, rempli par les robots -->
                            <div class="champ-piege" aria-hidden="true">
                                <label for="site_web">Ne remplissez pas ce champ</label>
                                <input type="text" id="site_web" name="site_web" value="" tabindex="-1" autocomplete="off">
                            </div>

                            <div class="col-12">
                                <!-- Mention d'information RGPD (premier niveau) -->
                                <p class="mention-rgpd">
                                    Les informations saisies sont utilisées uniquement par SolvR pour répondre à votre
                                    demande et, le cas échéant, établir un devis. Elles sont conservées 3 ans au plus
                                    après notre dernier échange. Vous pouvez y accéder, les rectifier ou demander leur
                                    suppression à tout moment.
                                    <a href="<?= e($pages['confidentialite']['path']) ?>">En savoir plus sur la gestion de vos données</a>.
                                </p>

                                <button type="submit" class="btn btn-primary btn-lg">Envoyer ma demande</button>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Coordonnées -->
                <div class="col-12 col-lg-4">
                    <aside class="encart" aria-labelledby="coordonnees-titre">
                        <h2 id="coordonnees-titre" class="h5">Me contacter directement</h2>
                        <ul class="list-unstyled atouts mt-3">
                            <li><?= icon('phone', 'icon-accent') ?> <a href="tel:<?= e(CONTACT_PHONE_LINK) ?>"><?= e(CONTACT_PHONE) ?></a></li>
                            <li><?= icon('mail', 'icon-accent') ?> <a href="mailto:<?= e(CONTACT_EMAIL) ?>"><?= e(CONTACT_EMAIL) ?></a></li>
                            <li><?= icon('geo', 'icon-accent') ?> <span>Nice et les Alpes-Maritimes, toute la France à distance</span></li>
                        </ul>

                        <h2 class="h5 mt-4">Et ensuite ?</h2>
                        <ol class="etapes-contact mt-3 mb-0">
                            <li>Je lis votre message et je vous réponds sous 48 h.</li>
                            <li>Nous échangeons sur votre projet, par téléphone ou en rendez-vous.</li>
                            <li>Je vous envoie un devis détaillé, gratuit et sans engagement.</li>
                        </ol>
                    </aside>
                </div>

            </div>
        </div>
    </section>

</main>

<?php require __DIR__ . '/includes/footer.php'; ?>