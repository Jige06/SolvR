/**
 * Bascule entre le thème clair et le thème sombre.
 * Le thème initial est appliqué par le script du <head> (pas de flash).
 * Ce fichier gère uniquement le bouton et le suivi du réglage système.
 */
const themeToggle = document.querySelector('[data-theme-toggle]');

if (themeToggle) {
    const root = document.documentElement;
    const systemDark = window.matchMedia('(prefers-color-scheme: dark)');

    /** Lit le choix mémorisé, s'il existe et s'il est valide */
    const getSavedTheme = () => {
        try {
            const saved = localStorage.getItem('solvr-theme');
            return saved === 'light' || saved === 'dark' ? saved : null;
        } catch {
            return null;
        }
    };

    /** Applique un thème et met à jour l'état du bouton */
    const applyTheme = (theme) => {
        root.setAttribute('data-bs-theme', theme);
        themeToggle.setAttribute('aria-pressed', String(theme === 'dark'));
    };

    // Synchronise le bouton avec le thème déjà appliqué, puis l'affiche
    applyTheme(root.getAttribute('data-bs-theme'));
    themeToggle.hidden = false;

    // Clic : on inverse le thème et on mémorise le choix
    themeToggle.addEventListener('click', () => {
        const newTheme = root.getAttribute('data-bs-theme') === 'dark' ? 'light' : 'dark';
        applyTheme(newTheme);

        try {
            localStorage.setItem('solvr-theme', newTheme);
        } catch {
            /* stockage impossible : le choix vaut pour la page en cours uniquement */
        }
    });

    // Si le visiteur n'a rien choisi, on suit les changements du système en direct
    systemDark.addEventListener('change', (event) => {
        if (getSavedTheme() === null) {
            applyTheme(event.matches ? 'dark' : 'light');
        }
    });
}