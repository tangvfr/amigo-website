# Projet AMIGOWS parties Vitrine
This project was generated with [Angular CLI](https://github.com/angular/angular-cli) version 17.2.2.

## Générer les fichiers .ts en fonction de l'api
- `symfony console api:openapi:export --output ../amigows.openapi.json` creation format openapi
- `npm i -D openapi-typescript typescript` intalaltion dépendence
- `npx openapi-typescript ../amigows.openapi.json -o ./src/app/models/schema.api.ts` creation du shema pour ts

## Instalation material
`ng add @angular/material`

## Development server
Est déja par default --configuration=development
Command pour en dev`ng serve --host 0.0.0.0`
Run `ng serve` for a dev server. Navigate to `http://localhost:4200/`. The application will automatically reload if you change any of the source files.

## Code scaffolding

Run `ng generate component component-name` to generate a new component. You can also use `ng generate directive|pipe|service|class|guard|interface|enum|module`.

## Build

Run `ng build` to build the project. The build artifacts will be stored in the `dist/` directory.

## Running unit tests

Run `ng test` to execute the unit tests via [Karma](https://karma-runner.github.io).

## Running end-to-end tests

Run `ng e2e` to execute the end-to-end tests via a platform of your choice. To use this command, you need to first add a package that implements end-to-end testing capabilities.

## Further help

To get more help on the Angular CLI use `ng help` or go check out the [Angular CLI Overview and Command Reference](https://angular.io/cli) page.
