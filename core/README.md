# Projet AMIGOWS parties API & Admin
## Commandes propres au projet
```
Available commands for the "user" namespace:
    user:create      Permet de créer un utilisateur à un étudiant.
    user:delete      Permet de supprimer l'utilisateur d'un étudiant.
    user:list        Permet de voir la liste des utilisateurs.
    user:tmp:clear   Permet de supprimer tous les utilisateurs root temporaire.
    user:tmp:create  Permet d'ajouter un utilisateur root temporaire
```
## Avant tout choses pour configurer votre bd ou environment
- Copier et renommer le fichier `.env` vers `.env.local` pour que ce dernier avec vos clefs ou mdp ne sois pas commit.
## Commandes qui peuvent dépanner
- `symfony composer install`
- `symfony composer update` important quand on ajoute des bundles
- `symfony console doctrine:migrations:migrate`
- `symfony console doctrine:fixture:load`
- `npm install`
- `npm update`
- `npm run dev`
## Commandes pour clear la db
- `symfony console d:d:d --force` supprime la db
- `symfony console c:c` vide le cache
- `symfony console d:d:c` crée la db
- `symfony console d:m:m` crée les tables de la db
- `symfony console d:f:l` load les fixtures
- `php -d memory_limit=-1 bin/console d:f:l` load les fixtures sans contraintes de ram
## Installation simple de Webpack Encore
- `symfony composer require symfony/webpack-encore-bundle`
- `npm install`
- `npm install bootstrap`
- `npm install bootstrap-icons`
- Dans `assets/app.js`, mettre
```javascript
import './styles/app.css';
import 'bootstrap';
import 'bootstrap/dist/css/bootstrap.min.css';
import 'bootstrap-icons/font/bootstrap-icons.css';
```
- Dans `config/package/twig.yaml`, ajouter dans `twig`
`form_themes: ['bootstrap_5_layout.html.twig']`
- À chaque modification de `app.js` et `app.css`, faire `npm run dev`
## symfony/webpack-encore-bundle  instructions:
* Install NPM and run: `npm install`
* Compile your assets: `npm run dev`
* Or start the development server: `npm run watch`
