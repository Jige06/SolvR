<?php

declare(strict_types=1);

/**
 * Résultat du traitement du formulaire de contact.
 * Un enum plutôt que des chaînes ('success', 'csrf'…) : une faute de frappe
 * devient une erreur PHP immédiate au lieu d'un bug silencieux.
 */
enum ContactStatus: string
{
    case Success   = 'success';     // message envoyé (affiché après la redirection)
    case Invalid   = 'invalid';     // champs mal remplis
    case Csrf      = 'csrf';        // jeton absent ou expiré
    case SendError = 'send-error';  // problème technique à l'envoi
    case TooManyRequests = 'too-many-requests';  // trop d'envois en peu de temps

    /** Vrai pour tous les statuts sauf le succès */
    public function isError(): bool
    {
        return $this !== self::Success;
    }
}
