<?php

namespace App\Api\Filter;

use ApiPlatform\Doctrine\Orm\Extension\QueryCollectionExtensionInterface;
use ApiPlatform\Doctrine\Orm\Extension\QueryItemExtensionInterface;
use ApiPlatform\Doctrine\Orm\Util\QueryNameGeneratorInterface;
use ApiPlatform\Metadata\Operation;
use App\Entity\Event;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\QueryBuilder;
use Monolog\DateTimeImmutable;

/**
 * Classe utilisée par l'API et pas par doctrine de basse
 * Permet de cacher pour les events qui ne doivent pas être affiché
 */
class EventFilterQueryExtension implements QueryCollectionExtensionInterface, QueryItemExtensionInterface
{

    const CLASS_APPLIED = Event::class;

    public function applyToCollection(QueryBuilder $queryBuilder, QueryNameGeneratorInterface $queryNameGenerator, string $resourceClass, ?Operation $operation = null, array $context = []): void
    {
        $this->apply($queryBuilder, $resourceClass, $operation->getName());
    }

    public function applyToItem(QueryBuilder $queryBuilder, QueryNameGeneratorInterface $queryNameGenerator, string $resourceClass, array $identifiers, ?Operation $operation = null, array $context = []): void
    {
        $this->apply($queryBuilder, $resourceClass, $operation->getName());
    }

    private function apply(QueryBuilder $qb, string $resourceClass, string $operationName): void
    {
        if ($resourceClass === self::CLASS_APPLIED) {//test si on l'applique à la classe
            $alias = $qb->getRootAliases()[0];
            $needNow = false;
            //condition
            //si note supérieur a 0
            $qb->andWhere($qb->expr()->gt($alias.'.note', 0));

            if ($operationName === Event::NOW_EVENT_API_NAME) { //event en cours
                $qb->andWhere(
                    $qb->expr()->orX(
                        $qb->expr()->isNull($alias . '.bgedDate.endDate'),//fin de l'event pas définie
                        $qb->expr()->gte($alias . '.bgedDate.endDate', ':now')
                    )
                );
                $needNow = true;
            } elseif ($operationName === Event::PAST_EVENT_API_NAME) {//event passé
                $qb->andWhere(
                    $qb->expr()->andX(
                        $qb->expr()->isNotNull($alias . '.bgedDate.endDate'),//fin de l'event pas définie
                        $qb->expr()->lt($alias . '.bgedDate.endDate', ':now')
                    )
                );
                $needNow = true;
            }
            //set parameter
            if ($needNow) {
                $qb->setParameter('now', new DateTimeImmutable('now'), Types::DATETIME_IMMUTABLE);
            }
        }
    }

}