<?php

namespace App\Repository;

use App\Entity\Offer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\Persistence\ManagerRegistry;
use Monolog\DateTimeImmutable;

/**
 * @extends ServiceEntityRepository<Offer>
 *
 * @method Offer|null find($id, $lockMode = null, $lockVersion = null)
 * @method Offer|null findOneBy(array $criteria, array $orderBy = null)
 * @method Offer[]    findAll()
 * @method Offer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OfferRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Offer::class);
    }
    public function findPublished()
    {
        //querry
        $qb = $this->createQueryBuilder('o');
        //select
        $qb->addSelect('c');
        //joined
        $qb->innerJoin('o.provider', 'c');
        //where
        $qb->where($qb->expr()->andX(
                $qb->expr()->isNotNull('o.publicationDate'),
                $qb->expr()->lte('o.publicationDate', ':now')
            ));
        //order
        $qb->orderBy( 'o.publicationDate', 'DESC')
            ->addOrderBy('o.bgedDate.beginDate', 'DESC');
        //parameters
        $qb->setParameter('now', new DateTimeImmutable('now'), Types::DATETIME_IMMUTABLE);
        //result
        return $qb->getQuery()->getResult();
    }

}
