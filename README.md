# SolvR — Site vitrine

Site vitrine de **SolvR**, activité freelance de développement web et web mobile basée dans les Alpes-Maritimes.
Sites vitrines, sites e-commerce et applications sur mesure pour les PME, commerçants et artisans.

> 🚧 **Projet en cours de développement**

## Technologies

- **HTML5** sémantique
- **CSS3** et **Bootstrap 5.3** (auto-hébergé)
- **Polices** : [Heebo](https://fonts.google.com/specimen/Heebo) (titres) et [Inter](https://rsms.me/inter/) (texte), auto-hébergées en woff2 (licence SIL Open Font License)
- **JavaScript** (amélioration progressive : le site reste utilisable sans JS) : bascule clair / sombre mémorisée, apparition des blocs au défilement, onde au clic, halo du bouton Contact, visionneuse d'images
- **PHP 8.5** : inclusions communes, formulaire de contact en POO (classes chargées par l'autoload de Composer)
- **PHPMailer** : envoi des e-mails en SMTP (tests avec Mailtrap)
- **Composer** : gestion des dépendances PHP
- **Docker** : environnement de développement Apache + PHP + Composer
- **Icônes** : [Bootstrap Icons](https://icons.getbootstrap.com/) (licence MIT)
- **Logos des technologies** : [Simple Icons](https://simpleicons.org/) (licence CC0)

## Principes du projet

- **Mobile first** et responsive
- **Accessibilité** : respect des recommandations WCAG / RGAA (balises sémantiques, contrastes AA vérifiés, navigation au clavier, lien d'évitement, focus visible, formulaires accessibles, respect de `prefers-reduced-motion`)
- **Sécurité** : en-têtes HTTP de sécurité (Content-Security-Policy stricte, `nosniff`, `Referrer-Policy`, `Permissions-Policy`, protection contre l'affichage en iframe, HSTS en HTTPS, version de PHP masquée), échappement systématique des sorties, validation côté serveur, protection CSRF, honeypot et piège temporel anti-spam, limitation des envois (3 par heure, 30 s entre deux), sessions sécurisées, secrets hors du dépôt, fichiers internes inaccessibles depuis le web
- **Référencement** : adresses propres sans extension (`/services`, les anciennes adresses en `.php` redirigent en 301), métadonnées uniques par page, Open Graph, URL canoniques, `robots.txt` et `sitemap.xml` générés depuis la configuration des pages, données structurées schema.org (`ProfessionalService`, `WebSite`) pour le référencement local
- **RGPD** : aucune ressource chargée depuis un serveur tiers (polices et Bootstrap hébergés localement), minimisation des données collectées, information sous le formulaire
- **Thème clair / sombre** : suit le réglage du système, bascule manuelle mémorisée, sans flash au chargement
- **Animations** : discrètes et accessibles. Désactivées si `prefers-reduced-motion` est activé, aucun contenu masqué sans JavaScript, aucune animation en boucle (RGAA 13.8). Transitions entre les pages avec la View Transitions API, en amélioration progressive
- **Performance** : polices variables légères (78 Ko au total) et préchargées, images WebP optimisées et chargées à la demande (`loading="lazy"`), scripts en `defer`, fichiers CSS et JS versionnés (`?v=`) pour que le navigateur recharge toujours la dernière version

## Prérequis

- [Git](https://git-scm.com/)
- [Docker Desktop](https://www.docker.com/products/docker-desktop/) (WSL 2 sous Windows)
- Un compte [Mailtrap](https://mailtrap.io/) pour tester l'envoi des e-mails

## Installation et lancement

```bash
# 1. Cloner le dépôt
git clone https://github.com/Jige06/SolvR.git
cd solvr

# 2. Construire l'image et démarrer le conteneur
docker compose up -d --build

# 3. Installer les dépendances PHP (PHPMailer)
docker compose exec web composer install
```

**4. Configurer le site** : copier `includes/config.example.php` en `includes/config.php`, puis y renseigner les coordonnées, les informations légales et les identifiants SMTP de Mailtrap (*Sandboxes → Integration → SMTP*). Ce fichier est ignoré par Git : aucune donnée personnelle ni aucun secret ne part sur GitHub. Sans lui, le site fonctionne avec les valeurs d'exemple, surlignées.

Le site est accessible sur **http://localhost:8080**.

### Commandes utiles

| Commande | Rôle |
|---|---|
| `docker compose up -d` | Démarrer le conteneur |
| `docker compose up -d --build` | Reconstruire l'image (après modification du `Dockerfile`) |
| `docker compose ps` | Vérifier que le conteneur tourne |
| `docker compose logs -f web` | Afficher les logs Apache / PHP en direct |
| `docker compose exec web composer dump-autoload` | Régénérer l'autoload après l'ajout d'une classe dans `src/` |
| `docker compose down` | Arrêter le conteneur |

## Structure du projet

```
solvr/
├── includes/
│   ├── functions.php       # Fonctions utilitaires (configuration, échappement, icônes…)
│   ├── pages.php           # Configuration des pages (SEO, menu, liens)
│   ├── technologies.php    # Logos des technologies (page À propos)
│   ├── head.php            # <head> : thème initial, métadonnées SEO, Open Graph, CSS
│   ├── header.php          # Lien d'évitement, en-tête, navigation, bouton de thème
│   ├── cta.php             # Bloc d'appel à l'action partagé entre les pages
│   ├── structured-data.php # Données structurées schema.org (JSON-LD) de la page d'accueil
│   ├── form-helpers.php    # Aides d'affichage des formulaires (attributs ARIA, messages d'erreur)
│   ├── footer.php          # Pied de page et scripts
│   └── config.example.php  # Modèle de configuration (coordonnées, infos légales, SMTP)
├── src/                    # Classes PHP (formulaire de contact)
│   ├── ContactController.php # Traitement de la requête : CSRF, honeypot, validation, envoi
│   ├── ContactStatus.php   # Résultats possibles du traitement (enum)
│   ├── SubmissionLimiter.php # Limitation des envois par session et piège temporel
│   ├── ContactForm.php     # Données, libellés et validation du formulaire
│   ├── ContactMailer.php   # Envoi de l'e-mail via PHPMailer
│   └── CsrfToken.php       # Jeton anti-CSRF
├── assets/
│   ├── css/                # Styles personnalisés (style.css)
│   ├── fonts/              # Polices Heebo et Inter (woff2) et leurs licences
│   ├── js/                 # Scripts : theme-init.js (thème avant affichage), main.js (bascule de thème), animations.js (animations, halo, visionneuse)
│   ├── img/                # Images et illustrations
│   │   ├── de-l-idee-au-site/  # Croquis, maquette et site en ligne (page Services)
│   │   ├── realisations/       # Captures de l'étude de cas Vite & Gourmand
│   │   └── services/           # Illustrations des offres (page Services)
│   └── vendor/             # Bibliothèques tierces (Bootstrap)
├── index.php               # Page d'accueil
├── services.php            # Page Services
├── realisations.php        # Page Réalisations (étude de cas Vite & Gourmand)
├── a-propos.php            # Page À propos (parcours, valeurs, outils)
├── contact.php             # Page Contact : appelle le contrôleur, redirige ou affiche
├── mentions-legales.php    # Mentions légales
├── confidentialite.php     # Politique de confidentialité
├── 404.php                 # Page d'erreur 404
├── robots.php              # Consignes aux robots, servies à l'adresse /robots.txt
├── sitemap.php             # Plan du site, servi à l'adresse /sitemap.xml
├── .htaccess               # Pages d'erreur, en-têtes de sécurité, protection des fichiers internes, robots.txt / sitemap.xml, adresses sans .php
├── .gitattributes          # Fins de ligne LF pour tous les fichiers texte
├── composer.json           # Dépendances PHP et autoload
├── Dockerfile              # Image PHP 8.5 + Apache + Composer
└── docker-compose.yml      # Lancement de l'environnement local
```

### Ajouter une page

1. Déclarer la page dans `includes/pages.php` (chemin **sans extension**, par exemple `/tarifs` pour `tarifs.php`, libellé, title, description, présence dans le menu). Elle apparaît automatiquement dans le sitemap, sauf avec `'noindex' => true`
2. Créer le fichier `.php` à la racine, du même nom que le chemin, en définissant `$currentPage` avec la clé correspondante
3. Inclure `head.php` et `header.php`, écrire le contenu dans `<main id="contenu">`, puis inclure `footer.php`

### Animer un élément

| Attribut | Effet |
|---|---|
| `data-entree="1"` à `"5"` | Entrée en cascade au chargement (hero), sans JavaScript |
| `data-reveal` | Apparition de l'élément quand il arrive à l'écran |
| `data-reveal-groupe` | Sur un parent : ses enfants directs apparaissent l'un après l'autre |
| classe `carte-survol` | La carte se soulève au survol et son icône pivote |

Ne pas placer de `data-reveal` à l'intérieur d'un élément déjà animé : il bougerait deux fois.

### Ajouter une image agrandissable

```php
<?= zoomableImage('/assets/img/dossier/image.webp', "Texte alternatif en clair", 1200, 900) ?>
```

La fonction génère un lien vers l'image, qui s'ouvre dans la visionneuse au clic (ou seule, sans JavaScript). Paramètres facultatifs : la classe CSS de l'image (`img-fluid` par défaut) et `false` pour désactiver le chargement différé d'une image visible dès l'arrivée sur la page.

## Conventions

### Sécurité du code

La Content-Security-Policy n'autorise que les fichiers du site : **aucun script ni style écrit directement dans le HTML** (pas de `<script>…</script>` en ligne, pas d'attribut `style="…"`, pas d'attribut `onclick`). Un script va dans `assets/js/`, un style dans `style.css` (une classe plutôt qu'un attribut). Une ressource externe (police, vidéo, outil de statistiques) demande de modifier la CSP dans `.htaccess`.

### Branches

Le projet suit un **Git Flow simplifié** :

| Branche | Rôle |
|---|---|
| `main` | Version stable en production — aucun commit direct |
| `develop` | Intégration du développement en cours |
| `feature/…` | Nouvelle fonctionnalité, créée depuis `develop` |
| `fix/…` | Correction de bug, créée depuis `develop` |
| `chore/…` | Configuration, outillage, créée depuis `develop` |
| `refactor/…` | Réorganisation du code sans changement de comportement, créée depuis `develop` |
| `style/…` | Mise en forme, CSS, créée depuis `develop` |
| `docs/…` | Documentation, créée depuis `develop` |
| `hotfix/…` | Correction urgente, créée depuis `main` |

### Commits

Les messages de commit suivent la convention [Conventional Commits](https://www.conventionalcommits.org/fr/) :

| Préfixe | Usage |
|---|---|
| `feat:` | Nouvelle fonctionnalité ou nouvelle page |
| `fix:` | Correction de bug |
| `style:` | Mise en forme, CSS |
| `refactor:` | Réorganisation du code sans changement de comportement |
| `docs:` | Documentation |
| `chore:` | Configuration, outillage |
| `perf:` | Amélioration des performances |

## Feuille de route

- [x] Cahier des charges
- [x] Arborescence et wireframes
- [x] Environnement Docker
- [x] Gabarit commun (head, header, footer)
- [x] Charte graphique et navigation
- [x] Page d'accueil (structure et contenus)
- [x] Mode sombre
- [x] Page Services
- [x] Page Réalisations
- [x] Page Contact et formulaire
- [x] Typographies
- [x] Pages légales et page 404
- [ ] Informations légales définitives (SIREN, adresse, hébergeur)
- [x] Animations et interactions
- [x] Captures des réalisations et illustrations des services
- [ ] Portrait
- [x] Page À propos
- [x] SEO technique (robots.txt, sitemap.xml, données structurées)
- [ ] Audit complet (code, sécurité, accessibilité, SEO, performance, validation, tests)
- [ ] Mise en ligne

## Auteur

**SolvR** — Développement web et web mobile, Alpes-Maritimes