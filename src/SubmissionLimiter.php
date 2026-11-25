<?php

declare(strict_types=1);

/**
 * Limite les envois du formulaire de contact, par session (aucune adresse IP stockée) :
 * - au plus MAX_PER_HOUR messages par heure ;
 * - au moins MIN_INTERVAL secondes entre deux messages ;
 * - « piège temporel » : un envoi reçu moins de MIN_FILL_TIME secondes après l'affichage
 *   du formulaire vient d'un robot (un humain met bien plus longtemps à le remplir).
 */
class SubmissionLimiter
{
    public const MAX_PER_HOUR  = 3;
    public const MIN_INTERVAL  = 30;   // secondes
    public const MIN_FILL_TIME = 3;    // secondes

    private const SESSION_KEY = 'contact_limiter';
    private const ONE_HOUR    = 3600;

    /** Horloge : time() sur le site, une fausse horloge dans les tests */
    private Closure $clock;

    public function __construct(?Closure $clock = null)
    {
        $this->clock = $clock ?? time(...);
    }

    /** À appeler chaque fois que le formulaire est affiché */
    public function markFormDisplayed(): void
    {
        $_SESSION[self::SESSION_KEY]['displayed_at'] = $this->now();
    }

    /** Vrai si le formulaire a été envoyé trop vite après son affichage */
    public function isTooFast(): bool
    {
        $displayedAt = $_SESSION[self::SESSION_KEY]['displayed_at'] ?? null;

        // Heure d'affichage inconnue (session antérieure à cette protection) : on laisse passer
        return $displayedAt !== null && $this->now() - $displayedAt < self::MIN_FILL_TIME;
    }

    /** Vrai si un nouvel envoi respecte le quota horaire et le délai entre deux envois */
    public function canSend(): bool
    {
        $sent = $this->recentSends();

        if (count($sent) >= self::MAX_PER_HOUR) {
            return false;
        }

        $last = end($sent);

        return $last === false || $this->now() - $last >= self::MIN_INTERVAL;
    }

    /** Enregistre un envoi réussi */
    public function recordSend(): void
    {
        $sent   = $this->recentSends();
        $sent[] = $this->now();

        $_SESSION[self::SESSION_KEY]['sent'] = $sent;
    }

    /** Heures des envois de la dernière heure (les plus anciens sont oubliés) */
    private function recentSends(): array
    {
        $now  = $this->now();
        $sent = $_SESSION[self::SESSION_KEY]['sent'] ?? [];

        return array_values(array_filter($sent, fn(int $time): bool => $now - $time < self::ONE_HOUR));
    }

    private function now(): int
    {
        return ($this->clock)();
    }
}
