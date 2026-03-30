# Interface ultra basique (PHP)

Mini appli en PHP natif avec 3 pages:
- Liste des plats
- Composition du menu
- Commande

Le menu est stocke en session (pas de base de donnees pour cette version).

## Fonctionnalites

- Affichage des plats (nom, description, prix)
- Ajout/retrait de plats dans un menu
- Nom du createur + dates creation/modification
- Commande avec quantite, adresse, date de livraison
- Calcul du total en temps reel (JavaScript)
- Recalcul serveur a la validation

## Fichiers principaux

- `src/main/index.php` : routeur ultra simple
- `src/main/Controllers.php` : actions
- `src/main/model.php` : donnees plats + logique session
- `src/main/view/plats.php`
- `src/main/view/menu.php`
- `src/main/view/commande.php`
- `src/main/view/confirmation.php`

## Lancer en local

Depuis la racine du projet:

```bat
php -S localhost:8000 -t src/main
```

Puis ouvrir:

- `http://localhost:8000/index.php/plats`

## Notes

- Version volontairement minimale, orientee demo.
- Les plats sont definis en dur dans `src/main/model.php`.
- Routes actives:
  - `GET /index.php/plats`
  - `GET /index.php/menu`
  - `POST /index.php/menu/ajouter`
  - `POST /index.php/menu/retirer`
  - `POST /index.php/menu/sauver`
  - `GET /index.php/commande`
  - `POST /index.php/commande/valider`
- Anciennes routes (`/login`, `/annonces`, `/post`) marquees obsolete.
