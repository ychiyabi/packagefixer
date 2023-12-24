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

    public function getRequiredPackages($package_id, $package_version, $php_version)
    {
        $query = $this->getEntityManager()->createQuery("select * from App\Entity\RequiredPackage
        where dependencer_id=:package_id
        and parent_package_version like '%:package_version%' 
        and php_version like '%:php_version%'")->setParameters(['package_id' => $package_id, 'package_version' => $package_version, 'php_version' => $php_version]);
        return $query->getResult();
        /* $conn = $this->getEntityManager()->getConnection();
        $sql = "select * from required_package
        where dependencer_id=:package_id
        and parent_package_version like '%:package_version%' 
        and php_version like '%:php_version%'";
        $resultSet = $conn->executeQuery($sql, [
            'package_id' => $package_id, 'package_version' => $package_version, 'php_version' => $php_version
        ]);
        return $resultSet->fetchAllAssociative(); */
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
