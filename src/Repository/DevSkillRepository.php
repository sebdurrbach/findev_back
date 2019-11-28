<?php

namespace App\Repository;

use App\Entity\DevSkill;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method DevSkill|null find($id, $lockMode = null, $lockVersion = null)
 * @method DevSkill|null findOneBy(array $criteria, array $orderBy = null)
 * @method DevSkill[]    findAll()
 * @method DevSkill[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DevSkillRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DevSkill::class);
    }

    // /**
    //  * @return DevSkill[] Returns an array of DevSkill objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?DevSkill
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
