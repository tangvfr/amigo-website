<?php

namespace App\Controller\Admin;

abstract class ConstantesCrud {

    //contantes générales + entités
    const SITE_NAME = 'Amigo Website';
    const DASHBOARD_NAME = 'Tableau de bord';
    const EXPOSED_NAME = 'Données exposées';
    const OFFICE_NAME = 'Bureau';
    const COMPANY_NAME = 'Entreprise';
    const COMPANY_TYPE_NAME = 'Entreprise Type';
    const EVENT_NAME = 'Évènement';
    const EVENT_TYPE_NAME = 'Évènement Type';
    const HUB_NAME = 'Pole';
    const LOCATION_NAME = 'Localisation';
    const MANDATE_NAME = 'Mandat';
    const OFFER_NAME = 'Offre';
    const PARTNER_NAME = 'Partenaire';
    const ROLE_NAME = 'Role';
    const STUDENT_NAME = 'Étudiant';


    //icons
    const DASHBOARD_ICON = 'fa fa-home';
    const EXPOSED_ICON = 'fa-solid fa-signs-post';
    const OFFICE_ICON = 'fa-solid fa-briefcase';
    const PASSWORD_ICON = 'fa-solid fa-key';
    const COMPANY_ICON = 'fas fa-building';
    const COMPANY_TYPE_ICON = 'fas fa-chart-line';
    const EVENT_ICON = 'fas fa-calendar';
    const EVENT_TYPE_ICON = 'fas fa-champagne-glasses';
    const LOCATION_ICON = 'fas fa-map-location-dot';
    const OFFER_ICON = 'fas fa-user-tie';
    const PARTNER_ICON = 'fas fa-handshake';
    const STUDENT_ICON = 'fas fa-user';
    const MANDATE_ICON = 'fas fa-person';
    const HUB_ICON = 'fas fa-flag';
    const ROLE_ICON = 'fas fa-key';


    //propriétés et label des cruds
    const COMPANY_PROPERTY_NAME = 'name';
    const COMPANY_LABEL_NAME = 'Name';
    const COMPANY_PROPERTY_DESC = 'description';
    const COMPANY_LABEL_DESC = 'Description';
    const COMPANY_PROPERTY_IMG = 'img';
    const COMPANY_LABEL_IMG = 'Image';
    const COMPANY_PATTERN_IMG = '[randomhash].[extension]';
    const COMPANY_PROPERTY_BANNER = 'banner';
    const COMPANY_LABEL_BANNER = 'Bannière';
    const COMPANY_PROPERTY_LOCALISATION = 'located';
    const COMPANY_LABEL_LOCALISATION = 'Localisation';
    const COMPANY_HELP_LOCALISATION = 'Sélectionnez les emplacements où l\'entreprise est présente';
    const COMPANY_LABEL_ACT = 'activities';
    const COMPANY_PROPERTY_ACT = 'Activités';
    const COMPANY_HELP_ACT = 'Sélectionnez les activités de l\'entreprise';


    //constantes configure crud
    const SEARCH_FIELD = 'name';
    const ID = 'id';
    const DESC = 'DESC';
    const PAGE_NAME = 'index';
    const RESULT_BY_PAGE = 10;


    // Taille des panels
    const PANEL_COLUMN_MOITIE_ECRAN = 'col-lg-8 col-xl-6';
    const PANEL_COLUMN_ECRAN_8 = 'col-lg-8 col-xl-8';
    // nom des panels
    const PANEL_NAME_INFOS_PRINCIPALES = 'INFORMATIONS PRINCIPALES';
    const PANEL_NAME_INFO_PRINCIPALE = 'INFORMATION PRINCIPALE';
    const PANEL_NAME_HISTORIQUE = 'HISTORIQUE';
    const PANEL_NAME_DATES = 'DATES';
    const PANEL_NAME_FOURNISSEUR = 'FOURNISSEUR';
    const PANEL_NAME_NOM = 'NOM';
    const PANEL_NAME_ADRESSE = 'ADRESSE';
    const PANEL_NAME_COORDONNEES = 'COORDONNEES';
    const PANEL_NAME_BANNIERE = 'BANNIERE';
    const PANEL_NAME_PRIX = 'PRIX';
    const PANEL_NAME_QUOTAS = 'QUOTAS';
    const PANEL_NAME_INFOS = 'INFOS';
    const PASSWORD_NAME = 'Changer de mot de passe';

}