<?php

namespace App\DataFixtures;

abstract class ConstantesFixtures {

    //constantes pour companyTypeFixtures
    public const COMPANY_NB = 4;
    public const ACTIVITY_MIN_NB = 1;
    public const ACTIVITY_MAX_NB = 3;


    //constantes pour companyTypeFixtures
    public const COMPANY_TYPE_NB = 10;


    //constantes pour eventFixtures
    public const EVENT_NB = 30;
    public const PROBA_ONLY_MIAGIST = 80;
    public const TWO_TYPES_PROBA = 80;
    public const PRICE_EVENT_NADH_MAX = 110;
    public const DIFF_PRICE_NADH_ADH = 3;
    public const QUOTA_STU_MIN = 20;
    public const QUOTA_MAX = 50;
    public const NOTE_MAX = 5;
    public const EVENT_CANCEL_PROBA = 10;
    public const EVENT_DATE_BETWEEN_MIN = '-8 months';
    public const EVENT_DATE_BETWEEN_MAX = '+1 months';


    //constantes pour eventTypeFixtures
    public const EVENT_TYPE_NB = 10;


    //constantes pour hubFixtures
    public const HUB_NB = 5;


    //constantes pour locationFixtures
    public const LOCATION_NB = 50;
    public const ADDRESS_COORD_PROBA = 50;


    //constantes pour mandateFixtures
    public const MANDATE_NB = 10;
    public const VISIBLE_PROBA = 95;

    public const MANDATE_DATE_BETWEEN_MIN = '-18 months';
    public const MANDATE_DATE_BETWEEN_MAX = '+18 months';


    //constantes pour offerFixtures
    public const OFFER_NB = 15;
    public const OFFER_DATE_BETWEEN_MIX = '-8 months';
    public const OFFER_DATE_BETWEEN_MAX = '+1 months';


    //constantes pour partnerFixtures
    public const PARTNER_NB = 20;
    public const CHALLENGE_PROBA = 66;
    public const PARTNER_DATE_BETWEEN_MIN = '-12 months';
    public const PARTNER_DATE_BETWEEN_MAX = '+12 months';


    //constantes pour roleFixtures
    public const ROLE_NB = 5;


    //constantes pour StudentFixtures
    public const STUDENT_NB = 50;
    public const STUDENT_NUMBER_MIN = 10000000;
    public const STUDENT_NUMBER_MAX = 99999999;


    //utilisation dans plusieurs fixtures
    public const NB_WORD_LABEL = 3;
    public const PRIORITY_MIN = -10;
    public const PRIORITY_MAX = 10;

}
