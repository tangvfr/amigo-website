<?php

namespace App\Api\Filter;

use App\Entity\Partner;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\QueryBuilder;
use Monolog\DateTimeImmutable;

/**
 * Classe utilisée par l'API et pas par doctrine de basse
 * Permet de cacher pour les partenariats qui ne doivent pas être affiché
 */
class PartherFilterQueryExtension extends AbstractFilterQueryExtension
{

    const CLASS_APPLIED = Partner::class;

    protected function apply(QueryBuilder $qb, string $resourceClass, string $operationName): void
    {
        if ($resourceClass === self::CLASS_APPLIED) {//test si on l'applique à la classe
            $alias = $qb->getRootAliases()[0];
            //condition
            $qb->andWhere(
                $qb->expr()->orX(
                    $qb->expr()->isNull($alias.'.bgedDate.beginDate'),
                    $qb->expr()->lte($alias.'.bgedDate.beginDate', ':now')
                ),
                $qb->expr()->orX(
                    $qb->expr()->isNull($alias.'.bgedDate.endDate'),
                    $qb->expr()->lte(':now', $alias.'.bgedDate.endDate')
                )
            );
            //set parameter
            $qb->setParameter('now', new DateTimeImmutable('now'), Types::DATETIME_IMMUTABLE);
        }
    }

}