<?php

namespace App\Repository;

use App\Entity\RequiredPackage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<RequiredPackage>
 *
 * @method RequiredPackage|null find($id, $lockMode = null, $lockVersion = null)
 * @method RequiredPackage|null findOneBy(array $criteria, array $orderBy = null)
 * @method RequiredPackage[]    findAll()
 * @method RequiredPackage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RequiredPackageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RequiredPackage::class);
    }

//    /**
//     * @return RequiredPackage[] Returns an array of RequiredPackage objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('r.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?RequiredPackage
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
