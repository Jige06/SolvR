/**
 * SolvR — animations
 * 1. Apparition des blocs au défilement
 * 2. Onde au clic sur les boutons
 * 3. État « envoi en cours » du formulaire de contact
 * 4. Position du halo lumineux autour du bouton Contact
 * 5. Visionneuse : agrandir une image au clic
 *
 * Tout est désactivé si la personne a demandé à réduire les animations.
 */
'use strict';

const reduireAnimations = window.matchMedia('(prefers-reduced-motion: reduce)');

/* 1. Apparition au défilement ------------------------------------------- */
function initApparitions() {
  // Les enfants d'un groupe apparaissent en cascade : 0 s, 0,08 s, 0,16 s…
  document.querySelectorAll('[data-reveal-groupe]').forEach((groupe) => {
    [...groupe.children].forEach((enfant, index) => {
      enfant.style.setProperty('--reveal-delai', `${Math.min(index, 5) * 0.08}s`);
    });
  });

  const elements = document.querySelectorAll('[data-reveal], [data-reveal-groupe] > *');

  // Navigateur trop ancien ou animations réduites : on affiche tout de suite.
  if (!('IntersectionObserver' in window) || reduireAnimations.matches) {
    elements.forEach((element) => element.classList.add('est-visible'));
    return;
  }

  const observateur = new IntersectionObserver((entrees, obs) => {
    entrees.forEach((entree) => {
      if (!entree.isIntersecting) return;
      entree.target.classList.add('est-visible');
      obs.unobserve(entree.target); // une seule fois par élément
    });
  }, { rootMargin: '0px 0px -10% 0px' });

  elements.forEach((element) => observateur.observe(element));
}

/* 2. Onde au clic -------------------------------------------------------- */
function initOndes() {
  // Délégation d'événement : un seul écouteur pour tous les boutons de la page.
  document.addEventListener('pointerdown', (event) => {
    const bouton = event.target.closest('.btn');
    if (!bouton || reduireAnimations.matches) return;

    const zone = bouton.getBoundingClientRect();
    const taille = Math.max(zone.width, zone.height) * 2;
    const onde = document.createElement('span');

    onde.className = 'onde';
    onde.style.width = `${taille}px`;
    onde.style.height = `${taille}px`;
    onde.style.left = `${event.clientX - zone.left - taille / 2}px`;
    onde.style.top = `${event.clientY - zone.top - taille / 2}px`;

    bouton.append(onde);
    onde.addEventListener('animationend', () => onde.remove());
  });
}

/* 3. Formulaire de contact ---------------------------------------------- */
function initFormulaireContact() {
  const formulaire = document.querySelector('[data-formulaire-contact]');
  if (!formulaire) return;

  const bouton = formulaire.querySelector('[type="submit"]');
  const statut = formulaire.querySelector('[data-statut-envoi]');

  const definirEnvoi = (enCours) => {
    bouton.disabled = enCours; // empêche le double envoi
    bouton.classList.toggle('est-en-cours', enCours);
    formulaire.setAttribute('aria-busy', String(enCours));
    statut.textContent = enCours ? 'Envoi en cours, merci de patienter…' : '';
  };

  formulaire.addEventListener('submit', () => definirEnvoi(true));

  // Retour arrière du navigateur : la page peut revenir du cache
  // avec le bouton encore désactivé. On la remet à zéro.
  window.addEventListener('pageshow', (event) => {
    if (event.persisted) definirEnvoi(false);
  });
}

/* 4. Halo du bouton Contact --------------------------------------------- */
function initHalo() {
  const bouton = document.querySelector('.site-header .btn-primary');
  if (!bouton) return;

  // Donne au CSS le centre exact du bouton, en pixels depuis le coin de l'écran.
  const placerHalo = () => {
    const zone = bouton.getBoundingClientRect();
    if (zone.width === 0) return; // bouton caché (menu mobile replié)

    const racine = document.documentElement.style;
    racine.setProperty('--solvr-halo-x', `${zone.left + zone.width / 2}px`);
    racine.setProperty('--solvr-halo-y', `${zone.top + zone.height / 2}px`);
  };

  placerHalo();
  window.addEventListener('resize', placerHalo);
  document.fonts?.ready.then(placerHalo); // les polices peuvent décaler le bouton
}

/* 5. Visionneuse --------------------------------------------------------- */
function initVisionneuse() {
  const liens = document.querySelectorAll('[data-agrandir]');
  if (liens.length === 0 || typeof HTMLDialogElement !== 'function') return;

  // Une seule visionneuse par page, créée seulement si la page a des images à agrandir.
  const visionneuse = document.createElement('dialog');
  visionneuse.className = 'visionneuse';
  visionneuse.setAttribute('aria-label', 'Image agrandie');
  visionneuse.innerHTML = `
    <button type="button" class="visionneuse-fermer">
      <svg width="18" height="18" viewBox="0 0 16 16" fill="currentColor" aria-hidden="true" focusable="false"><path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8z"/></svg>
      <span class="visually-hidden">Fermer</span>
    </button>
    <img alt="">`;
  document.body.append(visionneuse);

  const image = visionneuse.querySelector('img');
  let declencheur = null;

  liens.forEach((lien) => {
    lien.addEventListener('click', (event) => {
      // Ctrl/Cmd/Maj + clic : on laisse le navigateur ouvrir l'image dans un onglet.
      if (event.ctrlKey || event.metaKey || event.shiftKey) return;
      event.preventDefault();

      image.src = lien.href;
      image.alt = lien.querySelector('img').alt;
      declencheur = lien;
      visionneuse.showModal(); // modale : Échap ferme, le focus reste dedans
    });
  });

  // Un clic n'importe où (image, fond, croix) referme la visionneuse.
  visionneuse.addEventListener('click', () => visionneuse.close());

  // À la fermeture, le focus revient sur l'image cliquée (navigation au clavier).
  visionneuse.addEventListener('close', () => declencheur?.focus());
}

initApparitions();
initOndes();
initFormulaireContact();
initHalo();
initVisionneuse();