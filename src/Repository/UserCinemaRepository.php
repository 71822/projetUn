<?php

namespace App\Repository;

use App\Entity\UserCinema;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method UserCinema|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserCinema|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserCinema[]    findAll()
 * @method UserCinema[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserCinemaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserCinema::class);
    }

    // /**
    //  * @return UserCinema[] Returns an array of UserCinema objects
    //  */
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
    public function findOneBySomeField($value): ?UserCinema
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
