<?php

namespace App\Repository;

use App\Entity\CouponCode;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CouponCode>
 *
 * @method CouponCode|null find($id, $lockMode = null, $lockVersion = null)
 * @method CouponCode|null findOneBy(array $criteria, array $orderBy = null)
 * @method CouponCode[]    findAll()
 * @method CouponCode[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CouponCodeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CouponCode::class);
    }

    //    /**
    //     * @return CouponCode[] Returns an array of CouponCode objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('c.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?CouponCode
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
