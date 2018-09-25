<?php

namespace App\Repository;

use App\Entity\Afterwork;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Afterwork|null find($id, $lockMode = null, $lockVersion = null)
 * @method Afterwork|null findOneBy(array $criteria, array $orderBy = null)
 * @method Afterwork[]    findAll()
 * @method Afterwork[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AfterworkRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Afterwork::class);
    }

//    /**
//     * @return Afterwork[] Returns an array of Afterwork objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */


    public function findOneByDateField()
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.date > :val')
            ->setParameter('val', new \DateTime("now"))
            ->orderBy('a.date', 'ASC')
            ->setMaxResults(1)
            ->getQuery()
            ->getResult()
        ;
    }

}
