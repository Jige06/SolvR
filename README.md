# SolvR — Site vitrine

Site vitrine de **SolvR**, activité freelance de développement web et web mobile basée dans les Alpes-Maritimes.
Sites vitrines, sites e-commerce et applications sur mesure pour les PME, commerçants et artisans.

> 🚧 **Projet en cours de développement**

## Technologies

- **HTML5** sémantique
- **CSS3** et **Bootstrap 5.3** (auto-hébergé)
- **JavaScript** (amélioration progressive : le site reste utilisable sans JS)
- **PHP 8.5** (inclusions communes, traitement du formulaire de contact)
- **Docker** (environnement de développement Apache + PHP)

## Principes du projet

- **Mobile first** et responsive
- **Accessibilité** : respect des recommandations WCAG / RGAA (balises sémantiques, contrastes AA, navigation au clavier, lien d'évitement)
- **Sécurité** : validation côté serveur, protection CSRF, anti-spam, secrets hors du dépôt
- **Référencement** : métadonnées uniques par page, données structurées, référencement local
- **RGPD** : aucune ressource chargée depuis un serveur tiers (polices et Bootstrap hébergés localement)

## Prérequis

- [Git](https://git-scm.com/)
- [Docker Desktop](https://www.docker.com/products/docker-desktop/) (WSL 2 sous Windows)

## Installation et lancement

```bash
# Cloner le dépôt
git clone https://github.com/Jige06/SolvR.git
cd solvr

# Construire l'image et démarrer le conteneur
docker compose up -d --build
```

Le site est accessible sur **http://localhost:8080**.

### Commandes utiles

| Commande | Rôle |
|---|---|
| `docker compose up -d` | Démarrer le conteneur |
| `docker compose up -d --build` | Reconstruire l'image (après modification du `Dockerfile`) |
| `docker compose logs -f web` | Afficher les logs Apache / PHP en direct |
| `docker compose down` | Arrêter le conteneur |

## Structure du projet

```
solvr/
├── includes/          # Morceaux communs à toutes les pages (head, header, footer)
├── assets/
│   ├── css/           # Styles personnalisés
│   └── vendor/        # Bibliothèques tierces (Bootstrap)
├── index.php          # Page d'accueil
├── Dockerfile         # Image PHP 8.5 + Apache
└── docker-compose.yml # Lancement de l'environnement local
```

## Conventions

### Branches

Le projet suit un **Git Flow simplifié** :

| Branche | Rôle |
|---|---|
| `main` | Version stable en production — aucun commit direct |
| `develop` | Intégration du développement en cours |
| `feature/…` | Nouvelle fonctionnalité, créée depuis `develop` |
| `fix/…` | Correction de bug, créée depuis `develop` |
| `chore/…` | Configuration, outillage, créée depuis `develop` |
| `hotfix/…` | Correction urgente, créée depuis `main` |

### Commits

Les messages de commit suivent la convention [Conventional Commits](https://www.conventionalcommits.org/fr/) :

| Préfixe | Usage |
|---|---|
| `feat:` | Nouvelle fonctionnalité ou nouvelle page |
| `fix:` | Correction de bug |
| `style:` | Mise en forme, CSS |
| `docs:` | Documentation |
| `chore:` | Configuration, outillage |
## Feuille de route

- [x] Cahier des charges
- [x] Arborescence et wireframes
- [x] Environnement Docker
- [ ] Gabarit commun (head, header, footer)
- [ ] Page d'accueil
- [ ] Pages Services, Réalisations, À propos
- [ ] Page Contact et formulaire
- [ ] Pages légales (mentions légales, confidentialité)
- [ ] Audit accessibilité, SEO et sécurité
- [ ] Mise en ligne

## Auteur

**SolvR** — Développement web et web mobile, Alpes-Maritimes