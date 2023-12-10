<?php

namespace App\Repository;

use App\Entity\ExtensionComposer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ExtensionComposer>
 *
 * @method ExtensionComposer|null find($id, $lockMode = null, $lockVersion = null)
 * @method ExtensionComposer|null findOneBy(array $criteria, array $orderBy = null)
 * @method ExtensionComposer[]    findAll()
 * @method ExtensionComposer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ExtensionComposerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ExtensionComposer::class);
    }

//    /**
//     * @return ExtensionComposer[] Returns an array of ExtensionComposer objects
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

//    public function findOneBySomeField($value): ?ExtensionComposer
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
