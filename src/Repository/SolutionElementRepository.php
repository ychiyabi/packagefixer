<?php

namespace App\Repository;

use App\Entity\SolutionElement;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<SolutionElement>
 *
 * @method SolutionElement|null find($id, $lockMode = null, $lockVersion = null)
 * @method SolutionElement|null findOneBy(array $criteria, array $orderBy = null)
 * @method SolutionElement[]    findAll()
 * @method SolutionElement[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SolutionElementRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SolutionElement::class);
    }

//    /**
//     * @return SolutionElement[] Returns an array of SolutionElement objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('s.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?SolutionElement
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
