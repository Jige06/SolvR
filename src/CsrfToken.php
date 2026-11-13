<?php
declare(strict_types=1);

/**
 * Jeton anti-CSRF (Cross-Site Request Forgery).
 *
 * Un jeton aléatoire est stocké en session et inséré dans le formulaire.
 * À l'envoi, on vérifie que le jeton reçu est identique à celui de la session :
 * un site malveillant ne peut pas le connaître, donc ne peut pas soumettre
 * le formulaire à la place du visiteur.
 */
class CsrfToken
{
    private const SESSION_KEY = 'csrf_token';

    /** Retourne le jeton de la session (et le crée s'il n'existe pas encore) */
    public static function get(): string
    {
        if (empty($_SESSION[self::SESSION_KEY])) {
            $_SESSION[self::SESSION_KEY] = bin2hex(random_bytes(32));
        }

        return $_SESSION[self::SESSION_KEY];
    }

    /** Vérifie le jeton reçu (comparaison à temps constant avec hash_equals) */
    public static function isValid(mixed $token): bool
    {
        return is_string($token)
            && isset($_SESSION[self::SESSION_KEY])
            && hash_equals($_SESSION[self::SESSION_KEY], $token);
    }
}