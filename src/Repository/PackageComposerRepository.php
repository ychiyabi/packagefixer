<?php

namespace App\Repository;

use App\Entity\PackageComposer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PackageComposer>
 *
 * @method PackageComposer|null find($id, $lockMode = null, $lockVersion = null)
 * @method PackageComposer|null findOneBy(array $criteria, array $orderBy = null)
 * @method PackageComposer[]    findAll()
 * @method PackageComposer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PackageComposerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PackageComposer::class);
    }



    //    /**
    //     * @return PackageComposer[] Returns an array of PackageComposer objects
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

    //    public function findOneBySomeField($value): ?PackageComposer
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
