<?php

namespace App\Repository;

use App\Entity\Hub;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Hub>
 *
 * @method Hub|null find($id, $lockMode = null, $lockVersion = null)
 * @method Hub|null findOneBy(array $criteria, array $orderBy = null)
 * @method Hub[]    findAll()
 * @method Hub[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HubRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Hub::class);
    }

    //    /**
    //     * @return Hub[] Returns an array of Hub objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('h')
    //            ->andWhere('h.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('h.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Hub
    //    {
    //        return $this->createQueryBuilder('h')
    //            ->andWhere('h.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
