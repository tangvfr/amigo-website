# Projet AMIGOWS parties API & Admin
## Commandes qui peuvent dépanner
- `symfony composer install`
- `symfony composer update`
- `symfony console doctrine:migrations:migrate`
- `symfony console doctrine:fixture:load`
- `npm install`
- `npm run dev`
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
