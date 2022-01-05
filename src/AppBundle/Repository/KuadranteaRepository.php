<?php

namespace AppBundle\Repository;

/**
 * KuadranteaRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class KuadranteaRepository extends \Doctrine\ORM\EntityRepository
{
    public function getAllOrderByYearAndUserDisplayName()
    {
        $qb = $this->createQueryBuilder('k')
            ->select('k,u')
            ->join('k.user','u')
            ->orderBy('k.urtea', 'ASC')
            ->orderBy('u.lanpostua', 'ASC')
            ->orderBy('u.displayname', 'ASC')
        ;

        return $qb->getQuery()->getResult();
    }

    public function findByUserYearMonth($userid, $year, $hilabetea)
    {
        $qb = $this->createQueryBuilder('k')
            ->andWhere('k.user = :userid')->setParameter('userid', $userid)
            ->andWhere('k.urtea = :year')->setParameter('year', $year)
            ->andWhere('k.hilabetea = :hilabetea')->setParameter('hilabetea', $hilabetea);

        return $qb->getQuery()->getResult();
    }
}
