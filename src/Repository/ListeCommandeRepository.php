<?php

namespace App\Repository;

use App\Entity\ListeCommande;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ListeCommande>
 *
 * @method ListeCommande|null find($id, $lockMode = null, $lockVersion = null)
 * @method ListeCommande|null findOneBy(array $criteria, array $orderBy = null)
 * @method ListeCommande[]    findAll()
 * @method ListeCommande[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ListeCommandeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ListeCommande::class);
    }

//    /**
//     * @return ListeCommande[] Returns an array of ListeCommande objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('l')
//            ->andWhere('l.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('l.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?ListeCommande
//    {
//        return $this->createQueryBuilder('l')
//            ->andWhere('l.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
