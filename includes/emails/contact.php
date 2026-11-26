<?php

/**
 * Gabarit de l'e-mail HTML d'une demande de contact (rempli par src/ContactEmail.php).
 *
 * Un e-mail ne suit pas les règles du web : Gmail et surtout Outlook ignorent
 * une bonne partie du CSS. D'où :
 * - une mise en page en tableaux (role="presentation" : ignorés par les lecteurs d'écran)
 * - des styles écrits dans chaque balise, pas de feuille de style
 * - une largeur de 600 px au plus, des polices système
 *
 * Variables : $form, $receivedAt, $replyLink, $phoneLink (ou null), $esc (échappement).
 * Toute saisie du visiteur passe par $esc() : aucun HTML ne peut être glissé dans le mail.
 */

declare(strict_types=1);

$font  = "font-family: -apple-system, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;";
$label = "padding: 6px 16px 6px 0; color: #64626E; font-size: 14px; vertical-align: top; white-space: nowrap; $font";
$value = "padding: 6px 0; color: #2B2A31; font-size: 16px; vertical-align: top; $font";
$link  = 'color: #254BEB; text-decoration: underline;';
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="color-scheme" content="light">
    <meta name="supported-color-schemes" content="light">
    <title>Nouvelle demande de contact</title>
</head>

<body style="margin: 0; padding: 0; background-color: #F0E7D8;">
    <!-- Aperçu : la ligne affichée sous l'objet dans la liste des mails.
         mso-hide : Outlook sur Windows ignore display: none, il comprend cette propriété-là -->
    <div style="display: none; max-height: 0; overflow: hidden; mso-hide: all;">
        <?= $esc($form->getProjectTypeLabel()) ?> · <?= $esc(mb_strimwidth($form->get('message'), 0, 90, '…')) ?>
    </div>

    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color: #F0E7D8;">
        <tr>
            <td align="center" style="padding: 24px 12px;">
                <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0"
                    style="max-width: 600px; background-color: #FFFDFA; border-radius: 12px;">

                    <!-- En-tête aux couleurs de SolvR -->
                    <tr>
                        <td style="padding: 24px 32px; background-color: #254BEB; border-radius: 12px 12px 0 0; <?= $font ?>">
                            <p style="margin: 0; color: #FFFFFF; font-size: 24px; font-weight: 700;">SolvR</p>
                            <p style="margin: 4px 0 0; color: #FFFFFF; font-size: 16px;">Nouvelle demande de contact</p>
                        </td>
                    </tr>

                    <!-- Coordonnées du visiteur -->
                    <tr>
                        <td style="padding: 28px 32px 8px;">
                            <table role="presentation" cellpadding="0" cellspacing="0" border="0">
                                <tr>
                                    <td style="<?= $label ?>">Nom</td>
                                    <td style="<?= $value ?> font-weight: 600;"><?= $esc($form->get('name')) ?></td>
                                </tr>
                                <tr>
                                    <td style="<?= $label ?>">E-mail</td>
                                    <td style="<?= $value ?>">
                                        <a href="<?= $esc($replyLink) ?>" style="<?= $link ?>"><?= $esc($form->get('email')) ?></a>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="<?= $label ?>">Téléphone</td>
                                    <td style="<?= $value ?>">
                                        <?php if ($phoneLink !== null): ?>
                                            <a href="<?= $esc($phoneLink) ?>" style="<?= $link ?>"><?= $esc($form->get('phone')) ?></a>
                                        <?php else: ?>
                                            Non renseigné
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="<?= $label ?>">Projet</td>
                                    <td style="<?= $value ?>"><?= $esc($form->getProjectTypeLabel()) ?></td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Message : les retours à la ligne du visiteur sont conservés -->
                    <tr>
                        <td style="padding: 16px 32px; <?= $font ?>">
                            <p style="margin: 0 0 8px; color: #64626E; font-size: 14px;">Message</p>
                            <div style="padding: 16px 20px; background-color: #F0E7D8; border-left: 4px solid #254BEB; border-radius: 4px; color: #2B2A31; font-size: 16px; line-height: 1.6;">
                                <?= nl2br($esc($form->get('message')), false) ?>
                            </div>
                        </td>
                    </tr>

                    <!-- Actions en un clic -->
                    <tr>
                        <td style="padding: 16px 32px 28px; <?= $font ?>">
                            <a href="<?= $esc($replyLink) ?>"
                                style="display: inline-block; margin: 0 8px 8px 0; padding: 12px 22px; background-color: #254BEB; border: 2px solid #254BEB; border-radius: 8px; color: #FFFFFF; font-size: 16px; font-weight: 600; text-decoration: none;">Répondre par e-mail</a>
                            <?php if ($phoneLink !== null): ?>
                                <a href="<?= $esc($phoneLink) ?>"
                                    style="display: inline-block; margin: 0 0 8px; padding: 12px 22px; background-color: #FFFDFA; border: 2px solid #254BEB; border-radius: 8px; color: #254BEB; font-size: 16px; font-weight: 600; text-decoration: none;">Appeler</a>
                            <?php endif; ?>
                        </td>
                    </tr>

                    <!-- Pied : origine du mail -->
                    <tr>
                        <td style="padding: 16px 32px 24px; border-top: 1px solid #E6DCCB; color: #64626E; font-size: 13px; line-height: 1.5; <?= $font ?>">
                            Reçue le <?= $esc($receivedAt) ?> par le formulaire de contact du site SolvR.<br>
                            Un simple « Répondre » écrit directement à <?= $esc($form->get('email')) ?>.
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>
