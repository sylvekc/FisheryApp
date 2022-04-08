<?php

namespace App\Repository;

use App\Entity\FisheryReservations;
use ContainerTUyzN92\getConsole_ErrorListenerService;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method FisheryReservations|null find($id, $lockMode = null, $lockVersion = null)
 * @method FisheryReservations|null findOneBy(array $criteria, array $orderBy = null)
 * @method FisheryReservations[]    findAll()
 * @method FisheryReservations[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FisheryReservationsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FisheryReservations::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(FisheryReservations $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(FisheryReservations $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }


    public function dateValidator($nr,$startDate,$endDate): bool
    {
        $qb1 = $this->createQueryBuilder('f');
        $qb1->where('f.position_nr=:nr')
            ->andWhere('f.since_when>=:startDate')
            ->andWhere('f.since_when<=:endDate')
            ->setParameters(['nr' => $nr,'startDate'=>$startDate,'endDate'=>$endDate]);

        $qb2 = $this->createQueryBuilder('f');
        $qb2->where('f.position_nr=:nr')
            ->andWhere('f.until_when>=:startDate')
            ->andWhere('f.until_when<=:endDate')
            ->setParameters(['nr' => $nr,'startDate'=>$startDate,'endDate'=>$endDate]);

        $qb3 = $this->createQueryBuilder('f');
        $qb3->where('f.position_nr=:nr')
            ->andWhere('f.since_when<=:startDate')
            ->andWhere('f.until_when>=:endDate')
            ->setParameters(['nr' => $nr,'startDate'=>$startDate,'endDate'=>$endDate]);

        $result1=$qb1->getQuery()->getResult();
        $result2=$qb2->getQuery()->getResult();
        $result3=$qb3->getQuery()->getResult();

       if(!$result1==null || !$result2==null || !$result3==null)
            return false;
        else
            return true;
    }




    // /**
    //  * @return FisheryReservations[] Returns an array of FisheryReservations objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?FisheryReservations
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
