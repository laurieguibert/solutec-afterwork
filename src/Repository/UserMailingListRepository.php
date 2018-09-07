<?php

namespace App\Repository;

use App\Entity\UserMailingList;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method UserMailingList|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserMailingList|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserMailingList[]    findAll()
 * @method UserMailingList[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserMailingListRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, UserMailingList::class);
    }

//    /**
//     * @return UserMailingList[] Returns an array of UserMailingList objects
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
    public function findOneBySomeField($value): ?UserMailingList
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
