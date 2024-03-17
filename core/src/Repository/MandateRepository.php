<?php

namespace App\Repository;

use App\Entity\Mandate;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\Persistence\ManagerRegistry;
use Monolog\DateTimeImmutable;

/**
 * @extends ServiceEntityRepository<Mandate>
 *
 * @method Mandate|null find($id, $lockMode = null, $lockVersion = null)
 * @method Mandate|null findOneBy(array $criteria, array $orderBy = null)
 * @method Mandate[]    findAll()
 * @method Mandate[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MandateRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Mandate::class);
    }

    /**
     * @return Mandate[] Retourne la liste des mandats en cours
     */
    public function findCurrents(): array
    {
        //querry
        $qb = $this->createQueryBuilder('m');
        //select
        $qb->addSelect('r', 'h', 's');
        //joined
        $qb->innerJoin('m.roles', 'r')
            ->innerJoin('r.hub', 'h')
            ->innerJoin('m.student', 's');
        //where
        $qb->where($qb->expr()->eq('m.visible', 'true'))
            ->andWhere($qb->expr()->orX(
                $qb->expr()->isNull('m.bgedDate.beginDate'),
                $qb->expr()->lte('m.bgedDate.beginDate', ':now')
            ))
            ->andWhere($qb->expr()->orX(
                $qb->expr()->isNull('m.bgedDate.endDate'),
                $qb->expr()->lte(':now', 'm.bgedDate.endDate')
            ));
        //order
        $qb->orderBy( 'h.priority', 'DESC')
            ->addOrderBy('r.priority', 'DESC')
            ->addOrderBy('m.bgedDate.beginDate', 'ASC');
        //parameters
        $qb->setParameter('now', new DateTimeImmutable('now'), Types::DATETIME_IMMUTABLE);
        //result
        return $qb->getQuery()->getResult();
    }

}
