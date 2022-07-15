<?php

namespace App\Repository;

use App\Entity\Chantiers;
use App\Entity\Pointages;
use App\Entity\Utilisateurs;
use App\Utils\DateUtils;
use DateTimeInterface;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @extends ServiceEntityRepository<Pointages>
 *
 * @method Pointages|null find($id, $lockMode = null, $lockVersion = null)
 * @method Pointages|null findOneBy(array $criteria, array $orderBy = null)
 * @method Pointages[]    findAll()
 * @method Pointages[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PointagesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Pointages::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Pointages $entity, bool $flush = true): void
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
    public function remove(Pointages $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }
    public function findUtilisateurByWeek(Utilisateurs $utilisateur, DateTimeInterface $date):Array{
        $dateInterval = DateUtils::getDateOfWeek($date);
        $queryBuilder = $this->createQueryBuilder('p')
                    ->where('p.utilisateur = :utilisateur')
                    ->andWhere('p.date >= :startDate')
                    ->andWhere('p.date < :endDate')
                    ->setParameter('utilisateur',$utilisateur)
                    ->setParameter('startDate',$dateInterval["firstDayOfTheWeek"])
                    ->setParameter('endDate' ,$dateInterval["lastDayOfTheWeek"]);
        $query = $queryBuilder->getQuery();
        return $query->execute();
    }

    public function findUtilisateurByDate(Utilisateurs $utilisateur, Chantiers $chantier, DateTimeInterface $date):Array{
        $queryBuilder = $this->createQueryBuilder('p')
                    ->where('p.utilisateur = :utilisateur')
                    ->andWhere('p.chantier = :chantier')
                    ->andWhere('p.date >= :dateStart')
                    ->andWhere('p.date <= :dateEnd')
                    ->setParameter('utilisateur',$utilisateur)
                    ->setParameter('chantier',$chantier)
                    ->setParameter('dateStart',$date->format('Y-m-d 00:00:00'))
                    ->setParameter('dateEnd',$date->format('Y-m-d 23:59:59'));
        $query = $queryBuilder->getQuery();
        return $query->execute();
    }

    // /**
    //  * @return Pointages[] Returns an array of Pointages objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Pointages
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
