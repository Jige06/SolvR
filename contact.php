<?php

declare(strict_types=1);

/* ==========================================================
   1. TRAITEMENT : délégué au contrôleur (src/ContactController.php)
   ========================================================== */
require_once __DIR__ . '/includes/bootstrap.php';   // autoload (PHPMailer + nos classes) et fonctions
require_once __DIR__ . '/includes/form-helpers.php';

startSecureSession();   // nécessaire pour le jeton CSRF et le message de confirmation

$pages   = require __DIR__ . '/includes/pages.php';
$config  = config();
$contact = $config['contact'];

// Le contrôleur décide, la page agit : c'est ici, et seulement ici, qu'on redirige.
$controller = new ContactController($config);

if ($controller->handle($_SERVER['REQUEST_METHOD'], $_POST)) {
    // Post/Redirect/Get : un F5 ne renverra pas le formulaire
    header('Location: ' . $pages['contact']['path'], true, 303);
    exit;
}

$form   = $controller->getForm();
$status = $controller->getStatus();   // null au premier affichage, sinon un ContactStatus

// Trop d'envois : le code HTTP 429 (« Too Many Requests ») le dit aussi aux machines
if ($status === ContactStatus::TooManyRequests) {
    http_response_code(429);
}

/* ==========================================================
   2. AFFICHAGE
   ========================================================== */
$currentPage = 'contact';

// Le titre de l'onglet annonce le résultat (premier élément lu par un lecteur d'écran)
if ($status !== null) {
    $pageTitlePrefix = $status->isError() ? 'Erreur : ' : 'Message envoyé : ';
}

require __DIR__ . '/includes/head.php';
require __DIR__ . '/includes/header.php';
?>

<main id="main-content">

    <!-- ========== EN-TÊTE DE PAGE ========== -->
    <section class="hero section pb-4" aria-labelledby="page-title">
        <div class="container">
            <div class="col-lg-9">
                <p class="hero-eyebrow">Contact</p>
                <h1 id="page-title" class="display-5 fw-bold" data-entrance="1">Parlons de votre projet</h1>
                <p class="lead mt-3 mb-0" data-entrance="2">
                    Décrivez-moi votre besoin en quelques lignes : je vous réponds sous 48 h.
                    Le devis est gratuit et sans engagement.
                </p>
            </div>
        </div>
    </section>

    <!-- ========== FORMULAIRE + COORDONNÉES ========== -->
    <section class="section pt-4" aria-labelledby="form-title">
        <div class="container">
            <div class="row gy-5 gx-lg-5">

                <!-- Formulaire -->
                <div class="col-12 col-lg-8" data-entrance="3">
                    <h2 id="form-title" class="visually-hidden">Formulaire de contact</h2>

                    <!-- Zone de messages : annoncée par les lecteurs d'écran -->
                    <div aria-live="polite">
                        <?php if ($status === ContactStatus::Success): ?>
                            <div class="alert alert-success d-flex align-items-center gap-3" role="status">
                                <svg class="animated-check" viewBox="0 0 52 52" aria-hidden="true" focusable="false">
                                    <circle cx="26" cy="26" r="24" pathLength="1" />
                                    <path d="M15 27l7 7 15-15" pathLength="1" />
                                </svg>
                                <div>
                                    <p class="fw-bold mb-1">Merci, votre message a bien été envoyé !</p>
                                    <p class="mb-0">Je vous réponds sous 48 h à l'adresse e-mail indiquée.</p>
                                </div>
                            </div>

                        <?php elseif ($status === ContactStatus::Invalid): ?>
                            <div class="alert alert-danger" role="alert">
                                <p class="fw-bold mb-1">Le formulaire contient <?= count($form->getErrors()) ?> erreur(s) :</p>
                                <ul class="mb-0">
                                    <?php foreach ($form->getErrors() as $field => $error): ?>
                                        <li><a href="#<?= e($field) ?>" class="alert-link"><?= e(ContactForm::FIELD_LABELS[$field] ?? $field) ?></a> : <?= e($error) ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>

                        <?php elseif ($status === ContactStatus::Csrf): ?>
                            <div class="alert alert-danger" role="alert">
                                <p class="mb-0">Votre session a expiré. Vérifiez vos informations et renvoyez le formulaire.</p>
                            </div>

                        <?php elseif ($status === ContactStatus::SendError): ?>
                            <div class="alert alert-danger" role="alert">
                                <p class="mb-0">
                                    Désolé, votre message n'a pas pu être envoyé suite à un problème technique.
                                    Réessayez dans quelques minutes, ou contactez-moi directement par téléphone
                                    au <a href="tel:<?= e($contact['phone_link']) ?>" class="alert-link"><?= e($contact['phone']) ?></a>.
                                </p>
                            </div>

                        <?php elseif ($status === ContactStatus::TooManyRequests): ?>
                            <div class="alert alert-danger" role="alert">
                                <p class="mb-0">
                                    Vous avez envoyé plusieurs messages en peu de temps. Merci de patienter
                                    quelques minutes avant de réessayer : votre saisie est conservée.
                                    Vous pouvez aussi me joindre directement par téléphone
                                    au <a href="tel:<?= e($contact['phone_link']) ?>" class="alert-link"><?= e($contact['phone']) ?></a>.
                                </p>
                            </div>
                        <?php endif; ?>
                    </div>

                    <p>Les champs marqués d'un astérisque (<span class="required-mark">*</span>) sont obligatoires.</p>

                    <form action="<?= e($pages['contact']['path']) ?>" method="post" data-contact-form>
                        <input type="hidden" name="csrf_token" value="<?= e(CsrfToken::get()) ?>">

                        <div class="row g-3">
                            <div class="col-12 col-md-6">
                                <label for="name" class="form-label">Nom <span class="required-mark">*</span></label>
                                <input type="text" id="name" name="name" required maxlength="100"
                                    autocomplete="name" value="<?= e($form->get('name')) ?>"
                                    <?= fieldAttributes($form, 'name') ?>>
                                <?= fieldError($form, 'name') ?>
                            </div>

                            <div class="col-12 col-md-6">
                                <label for="email" class="form-label">E-mail <span class="required-mark">*</span></label>
                                <input type="email" id="email" name="email" required maxlength="254"
                                    autocomplete="email" value="<?= e($form->get('email')) ?>"
                                    <?= fieldAttributes($form, 'email') ?>>
                                <?= fieldError($form, 'email') ?>
                            </div>

                            <div class="col-12 col-md-6">
                                <label for="phone" class="form-label">Téléphone <span class="text-body-secondary">(facultatif)</span></label>
                                <p id="phone-help" class="form-text mt-0 mb-2">Format : 06 12 34 56 78</p>
                                <input type="tel" id="phone" name="phone" maxlength="17"
                                    pattern="(0|\+33 ?)[1-9]([ .\-]?\d{2}){4}"
                                    autocomplete="tel" value="<?= e($form->get('phone')) ?>"
                                    <?= fieldAttributes($form, 'phone', 'form-control', 'phone-help') ?>>
                                <?= fieldError($form, 'phone') ?>
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
                                <label for="message" class="form-label">Votre projet <span class="required-mark">*</span></label>
                                <p id="message-help" class="form-text mt-0 mb-2">
                                    Votre activité, ce dont vous avez besoin, vos délais éventuels…
                                </p>
                                <textarea id="message" name="message" rows="6" required minlength="10" maxlength="5000"
                                    <?= fieldAttributes($form, 'message', 'form-control', 'message-help') ?>><?= e($form->get('message')) ?></textarea>
                                <?= fieldError($form, 'message') ?>
                            </div>

                            <!-- Honeypot : invisible pour les humains, rempli par les robots -->
                            <div class="honeypot" aria-hidden="true">
                                <label for="website">Ne remplissez pas ce champ</label>
                                <input type="text" id="website" name="website" value="" tabindex="-1" autocomplete="off">
                            </div>

                            <div class="col-12">
                                <!-- Mention d'information RGPD (premier niveau) -->
                                <p class="gdpr-notice">
                                    Les informations saisies sont utilisées uniquement par SolvR pour répondre à votre
                                    demande et, le cas échéant, établir un devis. Elles sont conservées 3 ans au plus
                                    après notre dernier échange. Vous pouvez y accéder, les rectifier ou demander leur
                                    suppression à tout moment.
                                    <a href="<?= e($pages['confidentialite']['path']) ?>">En savoir plus sur la gestion de vos données</a>.
                                </p>

                                <button type="submit" class="btn btn-primary btn-lg btn-send">
                                    <span class="btn-send-label">Envoyer ma demande <?= icon('arrow-right', 'icon-arrow') ?></span>
                                    <span class="btn-send-loading">
                                        <span class="spinner-border spinner-border-sm" aria-hidden="true"></span>
                                        Envoi…
                                    </span>
                                </button>
                                <p class="visually-hidden" role="status" data-send-status></p>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Coordonnées -->
                <div class="col-12 col-lg-4">
                    <aside class="callout" aria-labelledby="contact-details-title" data-reveal>
                        <h2 id="contact-details-title" class="h5">Me contacter directement</h2>
                        <ul class="list-unstyled highlights mt-3">
                            <li><?= icon('phone', 'icon-accent') ?> <a href="tel:<?= e($contact['phone_link']) ?>"><?= e($contact['phone']) ?></a></li>
                            <li><?= icon('mail', 'icon-accent') ?> <a href="mailto:<?= e($contact['email']) ?>"><?= e($contact['email']) ?></a></li>
                            <li><?= icon('geo', 'icon-accent') ?> <span>Nice et les Alpes-Maritimes, toute la France à distance</span></li>
                        </ul>

                        <h2 class="h5 mt-4">Et ensuite ?</h2>
                        <ol class="contact-steps mt-3 mb-0">
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
