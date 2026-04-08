# Interface IHM (PHP/HTML)

Cette mini application implemente uniquement le composant **IHM**.
Elle consomme les APIs REST des composants:

- Plats et Utilisateurs
- Menus
- Commandes

Le projet contient deja les fichiers JSON/YAML pour mocker ces APIs (JSON-Server).

## Fonctionnalites IHM

- Affichage des plats depuis l'API Plats/Utilisateurs
- Selection d'un menu existant
- Creation d'un menu (nom + createur)
- Ajout/retrait de plats dans le menu courant (via API Menus)
- Passage de commande sur le menu courant (via API Commandes)
- Calcul du total commande en temps reel (JavaScript)

## Fichiers principaux

- `src/main/index.php` : routeur
- `src/main/Controllers.php` : actions IHM
- `src/main/model.php` : client HTTP REST + etat de session minimal (menu courant)
- `src/main/config.php` : URLs des APIs
- `src/main/View/*.php` : vues

## Configuration des APIs

Par defaut, l'IHM appelle les mocks JSON-Server suivants:

- `http://localhost:3003`
- `http://localhost:3002`
- `http://localhost:3001`

Surcharge possible via variables d'environnement:

- `PLATS_UTILISATEURS_API_BASE`
- `MENUS_API_BASE`
- `COMMANDES_API_BASE`

## Lancer en local

### 1) Lancer les APIs mock (3 terminaux)

Depuis la racine du projet:

```powershell
npx json-server --watch src/main/json/plats-utilisateurs.json --port 3003
npx json-server --watch src/main/json/menus.json --port 3002
npx json-server --watch src/main/json/commandes.json --port 3001
```

### 2) Lancer l'IHM PHP

Depuis la racine du projet:

```powershell
php -S localhost:8000 -t src/main
```

Puis ouvrir:

- `http://localhost:8000/index.php/plats`

## Routes IHM actives

- `GET /index.php/plats`
- `GET /index.php/menu`
- `POST /index.php/menu/selectionner`
- `POST /index.php/menu/creer`
- `POST /index.php/menu/ajouter`
- `POST /index.php/menu/retirer`
- `GET /index.php/commande`
- `POST /index.php/commande/valider`

## Notes

- L'IHM ne gere pas de base locale: la logique metier est dans les APIs REST.
- La session PHP sert uniquement a memoriser le menu courant selectionne.
- Les routes historiques (`/login`, `/annonces`, `/post`) restent marquees obsolete.
