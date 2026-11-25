/**
 * Thème appliqué AVANT l'affichage, pour éviter un flash de couleur au chargement.
 * Chargé dans le <head> sans defer : il s'exécute avant que la page soit dessinée.
 * Fichier séparé (et non script en ligne) : la Content-Security-Policy n'autorise
 * que les scripts venant du site.
 */
(function () {
    // Indique au CSS que JavaScript fonctionne (les animations peuvent masquer puis révéler)
    document.documentElement.classList.add('js');

    let theme = window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';

    try {
        const saved = localStorage.getItem('solvr-theme');
        if (saved === 'light' || saved === 'dark') {
            theme = saved;
        }
    } catch (error) {
        /* localStorage indisponible (navigation privée stricte…) : on garde le thème du système */
    }

    document.documentElement.setAttribute('data-bs-theme', theme);
})();
