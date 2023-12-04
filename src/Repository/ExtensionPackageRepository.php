<?php

namespace App\Repository;

use App\Entity\ExtensionPackage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ExtensionPackage>
 *
 * @method ExtensionPackage|null find($id, $lockMode = null, $lockVersion = null)
 * @method ExtensionPackage|null findOneBy(array $criteria, array $orderBy = null)
 * @method ExtensionPackage[]    findAll()
 * @method ExtensionPackage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ExtensionPackageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ExtensionPackage::class);
    }

//    /**
//     * @return ExtensionPackage[] Returns an array of ExtensionPackage objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('e.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?ExtensionPackage
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
