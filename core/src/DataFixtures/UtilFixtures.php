<?php

namespace App\DataFixtures;

use App\Entity\Date\BeginEndDateEmbeddable;
use App\Entity\Date\BeginEndDateTimeEmbeddable;

class UtilFixtures {

    public static function createDate(
        $faker,
        String $dateBetweenMin, String $dateBetweenMax,
        bool $datetime) : BeginEndDateEmbeddable | BeginEndDateTimeEmbeddable
    {
        $date1 = $faker->dateTimeBetween($dateBetweenMin, $dateBetweenMax);
        $date2 = $faker->dateTimeBetween($dateBetweenMin, $dateBetweenMax);

        if ($datetime) {
            $date = new BeginEndDateTimeEmbeddable();
        } else {
            $date = new BeginEndDateEmbeddable();
        }

        if ($date1 <= $date2)
        {
            $date->setBeginDate($date1)
                ->setEndDate($date2);
        } else
        {
            $date->setBeginDate($date2)
                ->setEndDate($date1);
        }

        return $date;
    }


}