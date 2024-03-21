<?php

namespace App\DataFixtures;

use App\Entity\Date\BeginEndDateEmbeddable;
use App\Entity\Date\BeginEndDateTimeEmbeddable;
use DateTime;
use DateTimeInterface;
use Faker\Generator;

class UtilFixtures {

    /**
     * Créer une BeginEndDate aléatoire entre 2 dates données
     * @param Generator $faker le faker permettant d'obtenir une date aléatoire
     * @param String $dateBetweenMin l'intervalle gauche (entre cette date et now)
     * @param String $dateBetweenMax l'intervalle droite (entre now et cette date)
     * @param bool $datetime est ce que l'on veut retourner un BeginEndDate ou un BeginEndDateTime
     * @return BeginEndDateEmbeddable|BeginEndDateTimeEmbeddable la date aléatoire
     */
    public static function createDate(
        Generator $faker,
        String $dateBetweenMin, String $dateBetweenMax,
        bool $datetime, String $gapEndDate = '+30 days'
    ) : BeginEndDateEmbeddable | BeginEndDateTimeEmbeddable
    {
        $date1 = $faker->dateTimeBetween($dateBetweenMin, $dateBetweenMax);
        $date1clone = new DateTime();
        $date1clone->setTimestamp($date1->getTimestamp());
        $date2 = $date1clone->modify($gapEndDate);

        if ($datetime) {
            $date = new BeginEndDateTimeEmbeddable();
        } else {
            $date = new BeginEndDateEmbeddable();
        }

        $date->setBeginDate($date1)
            ->setEndDate($date2);
        /*if ($date1 <= $date2)
        {
            $date->setBeginDate($date1)
                ->setEndDate($date2);
        } else
        {
            $date->setBeginDate($date2)
                ->setEndDate($date1);
        }*/

        return $date;
    }

    /**
     * Permet d'obtenir une date aléatoire entre 2 dates
     * @param DateTimeInterface $date_start la date de départ
     * @param DateTimeInterface $date_end la date fin
     * @return DateTimeInterface une date aléatoire entre les 2 dates
     */
    public static function randomDateBetween(
        DateTimeInterface $date_start, DateTimeInterface $date_end) : DateTimeInterface
    {
        $randomTimestamp = mt_rand($date_start->getTimestamp(), $date_end->getTimestamp());
        $randomDate = new DateTime();
        $randomDate->setTimestamp($randomTimestamp);

        return $randomDate;
    }

    /**
     * Permet de transformer une DateTimeInterface en DateTime
     * @param ?DateTimeInterface $date la date à transformer en DateTime
     * @return DateTimeInterface $date au format DateTime
     */
    public static function bgeDateToDateTime(?DateTimeInterface $date) : DateTimeInterface
    {
        $datetime = new DateTime();
        $datetime->setDate(
            $date->format('Y'),
            $date->format('m'),
            $date->format('d')
        );

        return $datetime;
    }

}