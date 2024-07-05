<?php

namespace App\Repository;

use App\Entity\HabitatImage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<HabitatImage>
 *
 * @method HabitatImage|null find($id, $lockMode = null, $lockVersion = null)
 * @method HabitatImage|null findOneBy(array $criteria, array $orderBy = null)
 * @method HabitatImage[]    findAll()
 * @method HabitatImage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HabitatImageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, HabitatImage::class);
    }

//    /**
//     * @return HabitatImage[] Returns an array of HabitatImage objects
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

//    public function findOneBySomeField($value): ?HabitatImage
//    {
//        return $this->createQueryBuilder('h')
//            ->andWhere('h.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
