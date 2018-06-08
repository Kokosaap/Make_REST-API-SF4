<?php

namespace App\Repository;

use App\Entity\ApiRestful;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ApiRestful|null find($id, $lockMode = null, $lockVersion = null)
 * @method ApiRestful|null findOneBy(array $criteria, array $orderBy = null)
 * @method ApiRestful[]    findAll()
 * @method ApiRestful[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ApiRestfulRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ApiRestful::class);
    }

//    /**
//     * @return ApiRestful[] Returns an array of ApiRestful objects
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

    /*
    public function findOneBySomeField($value): ?ApiRestful
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
