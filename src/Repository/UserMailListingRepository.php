<?php

namespace App\Repository;

use App\Entity\UserMailListing;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method UserMailListing|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserMailListing|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserMailListing[]    findAll()
 * @method UserMailListing[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserMailListingRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, UserMailListing::class);
    }

//    /**
//     * @return UserMailListing[] Returns an array of UserMailListing objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?UserMailListing
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
