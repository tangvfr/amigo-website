<?php

namespace App\Api;

use ApiPlatform\Doctrine\Orm\Extension\QueryCollectionExtensionInterface;
use ApiPlatform\Doctrine\Orm\Extension\QueryItemExtensionInterface;
use ApiPlatform\Doctrine\Orm\Util\QueryNameGeneratorInterface;
use ApiPlatform\Metadata\Operation;
use App\Entity\Event;
use App\Entity\Offer;
use App\Entity\Partner;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\QueryBuilder;
use Monolog\DateTimeImmutable;

/**
 * Classe utilisée par l'API et pas par doctrine de basse
 * Permet de cacher pour les offres, parthers, events qui ne sont pas publié ou non pas de date de publication
 */
class PublishedFilterQueryExtension implements QueryCollectionExtensionInterface, QueryItemExtensionInterface
{

    const CLASS_APPLIED = [
        Offer::class,
        Partner::class,
        Event::class,
    ];

    public function applyToCollection(QueryBuilder $queryBuilder, QueryNameGeneratorInterface $queryNameGenerator, string $resourceClass, ?Operation $operation = null, array $context = []): void
    {
        $this->apply($queryBuilder, $resourceClass);
    }

    public function applyToItem(QueryBuilder $queryBuilder, QueryNameGeneratorInterface $queryNameGenerator, string $resourceClass, array $identifiers, ?Operation $operation = null, array $context = []): void
    {
        $this->apply($queryBuilder, $resourceClass);
    }

    private function apply(QueryBuilder $qb, string $resourceClass): void
    {
        if (in_array($resourceClass, self::CLASS_APPLIED)) {//test si on l'applique à la classe
            $alias = $qb->getRootAliases()[0];
            //condition
            $qb->andWhere(
                $qb->expr()->andX(
                    $qb->expr()->isNotNull($alias . '.publicationDate'),
                    $qb->expr()->lte($alias . '.publicationDate', ':now')
                )
            );
            //set parameter
            $qb->setParameter('now', new DateTimeImmutable('now'), Types::DATETIME_IMMUTABLE);
        }
    }

}