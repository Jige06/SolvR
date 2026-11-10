<?php
declare(strict_types=1);

// URL du site en production (à remplacer par le vrai domaine)
const SITE_URL = 'https://www.solvr.fr';

/**
 * Échappe une valeur avant de l'afficher dans le HTML.
 * Protège contre les failles XSS : <script> devient &lt;script&gt;
 */
function e(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}