<?php

declare(strict_types=1);

/* ==========================================================
   Aides d'affichage des formulaires (page Contact)
   Nécessite includes/functions.php (pour e()).
   ========================================================== */

/**
 * Attributs d'accessibilité d'un champ selon qu'il est en erreur ou non.
 * Retourne par exemple : class="form-control is-invalid" aria-invalid="true" aria-describedby="name-error"
 */
function fieldAttributes(
    ContactForm $form,
    string $field,
    string $baseClass = 'form-control',
    string $describedBy = '',
): string {
    $hasError = $form->getError($field) !== null;
    $ids = trim($describedBy . ($hasError ? ' ' . $field . '-error' : ''));

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
        : '<p id="' . $field . '-error" class="invalid-feedback d-block">' . e($error) . '</p>';
}
