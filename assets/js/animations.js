/**
 * SolvR — animations
 * 1. Apparition des blocs au défilement
 * 2. Onde au clic sur les boutons
 * 3. État « envoi en cours » du formulaire de contact
 * 4. Position du halo lumineux autour du bouton Contact
 * 5. Visionneuse : agrandir une image au clic
 *
 * Tout est désactivé si la personne a demandé à réduire les animations.
 *
 * Module (type="module") : ses fonctions restent privées à ce fichier,
 * et le mode strict est automatique (plus besoin de 'use strict').
 */

const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)');

/* 1. Apparition au défilement ------------------------------------------- */
function initReveal() {
    // Les enfants d'un groupe apparaissent en cascade : 0 s, 0,08 s, 0,16 s…
    document.querySelectorAll('[data-reveal-group]').forEach((group) => {
        [...group.children].forEach((child, index) => {
            child.style.setProperty('--reveal-delay', `${Math.min(index, 5) * 0.08}s`);
        });
    });

    const elements = document.querySelectorAll('[data-reveal], [data-reveal-group] > *');

    // Navigateur trop ancien ou animations réduites : on affiche tout de suite.
    if (!('IntersectionObserver' in window) || reduceMotion.matches) {
        elements.forEach((element) => element.classList.add('is-visible'));
        return;
    }

    const observer = new IntersectionObserver((entries, obs) => {
        entries.forEach((entry) => {
            if (!entry.isIntersecting) return;
            entry.target.classList.add('is-visible');
            obs.unobserve(entry.target); // une seule fois par élément
        });
    }, { rootMargin: '0px 0px -10% 0px' });

    elements.forEach((element) => observer.observe(element));
}

/* 2. Onde au clic -------------------------------------------------------- */
function initRipples() {
    // Délégation d'événement : un seul écouteur pour tous les boutons de la page.
    document.addEventListener('pointerdown', (event) => {
        const button = event.target.closest('.btn');
        if (!button || reduceMotion.matches) return;

        const rect = button.getBoundingClientRect();
        const size = Math.max(rect.width, rect.height) * 2;
        const ripple = document.createElement('span');

        ripple.className = 'ripple';
        ripple.style.width = `${size}px`;
        ripple.style.height = `${size}px`;
        ripple.style.left = `${event.clientX - rect.left - size / 2}px`;
        ripple.style.top = `${event.clientY - rect.top - size / 2}px`;

        button.append(ripple);
        ripple.addEventListener('animationend', () => ripple.remove());
    });
}

/* 3. Formulaire de contact ---------------------------------------------- */
function initContactForm() {
    const form = document.querySelector('[data-contact-form]');
    if (!form) return;

    const button = form.querySelector('[type="submit"]');
    const status = form.querySelector('[data-send-status]');

    const setSending = (isSending) => {
        button.disabled = isSending; // empêche le double envoi
        button.classList.toggle('is-sending', isSending);
        form.setAttribute('aria-busy', String(isSending));
        status.textContent = isSending ? 'Envoi en cours, merci de patienter…' : '';
    };

    form.addEventListener('submit', () => setSending(true));

    // Retour arrière du navigateur : la page peut revenir du cache
    // avec le bouton encore désactivé. On la remet à zéro.
    window.addEventListener('pageshow', (event) => {
        if (event.persisted) setSending(false);
    });
}

/* 4. Halo du bouton Contact --------------------------------------------- */
function initHalo() {
    const button = document.querySelector('.site-header .btn-primary');
    if (!button) return;

    // Donne au CSS le centre exact du bouton, en pixels depuis le coin de l'écran.
    const placeHalo = () => {
        const rect = button.getBoundingClientRect();
        if (rect.width === 0) return; // bouton caché (menu mobile replié)

        const root = document.documentElement.style;
        root.setProperty('--solvr-halo-x', `${rect.left + rect.width / 2}px`);
        root.setProperty('--solvr-halo-y', `${rect.top + rect.height / 2}px`);
    };

    placeHalo();
    window.addEventListener('resize', placeHalo);
    document.fonts?.ready.then(placeHalo); // les polices peuvent décaler le bouton
}

/* 5. Visionneuse --------------------------------------------------------- */
function initLightbox() {
    const links = document.querySelectorAll('[data-zoomable]');
    if (links.length === 0 || typeof HTMLDialogElement !== 'function') return;

    // Une seule visionneuse par page, créée seulement si la page a des images à agrandir.
    const lightbox = document.createElement('dialog');
    lightbox.className = 'lightbox';
    lightbox.setAttribute('aria-label', 'Image agrandie');
    lightbox.innerHTML = `
        <button type="button" class="lightbox-close">
            <svg width="18" height="18" viewBox="0 0 16 16" fill="currentColor" aria-hidden="true" focusable="false"><path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8z"/></svg>
            <span class="visually-hidden">Fermer</span>
        </button>
        <img alt="">`;
    document.body.append(lightbox);

    const image = lightbox.querySelector('img');
    let trigger = null;

    links.forEach((link) => {
        link.addEventListener('click', (event) => {
            // Ctrl/Cmd/Maj + clic : on laisse le navigateur ouvrir l'image dans un onglet.
            if (event.ctrlKey || event.metaKey || event.shiftKey) return;
            event.preventDefault();

            image.src = link.href;
            image.alt = link.querySelector('img').alt;
            trigger = link;
            lightbox.showModal(); // modale : Échap ferme, le focus reste dedans
        });
    });

    // Un clic n'importe où (image, fond, croix) referme la visionneuse.
    lightbox.addEventListener('click', () => lightbox.close());

    // À la fermeture, le focus revient sur l'image cliquée (navigation au clavier).
    lightbox.addEventListener('close', () => trigger?.focus());
}

initReveal();
initRipples();
initContactForm();
initHalo();
initLightbox();
