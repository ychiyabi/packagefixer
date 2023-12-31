<?php

namespace App\Repository;

use App\Entity\PhpVersion;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PhpVersion>
 *
 * @method PhpVersion|null find($id, $lockMode = null, $lockVersion = null)
 * @method PhpVersion|null findOneBy(array $criteria, array $orderBy = null)
 * @method PhpVersion[]    findAll()
 * @method PhpVersion[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PhpVersionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PhpVersion::class);
    }

//    /**
//     * @return PhpVersion[] Returns an array of PhpVersion objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?PhpVersion
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
