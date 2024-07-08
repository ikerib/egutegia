<?php

namespace AppBundle\Repository;

use Doctrine\ORM\NonUniqueResultException;

/**
 * KuadranteaEskaerekinRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class KuadranteaEskaerekinRepository extends \Doctrine\ORM\EntityRepository
{
    /**
     * @throws NonUniqueResultException
     */
    public function findByUserYearMonth($userid, $year, $hilabetea)
    {
        $qb = $this->createQueryBuilder('k')
            ->andWhere('k.user = :userid')->setParameter('userid', $userid)
            ->andWhere('k.urtea = :year')->setParameter('year', $year)
            ->andWhere('k.hilabetea = :hilabetea')->setParameter('hilabetea', $hilabetea);

        return $qb->getQuery()->getOneOrNullResult();
    }

    /**
     * @throws NonUniqueResultException
     */
    public function findByUserYear($userid, $year)
    {
        $qb = $this->createQueryBuilder('k')
            ->andWhere('k.user = :userid')->setParameter('userid', $userid)
            ->andWhere('k.urtea = :year')->setParameter('year', $year)
            ;
        return $qb->getQuery()->getResult();
    }

    public function findallSaila($sailaid) {
        $qb = $this->createQueryBuilder('k')
            ->select('k')
            ->join('k.user', 'u')
            ->andWhere('u.saila=:sailaid')->setParameter('sailaid', $sailaid)
            ->orderBy('u.lanpostua', 'ASC')
        ;

        // 2024-07-08 Erikak eskatu du berak kuadrantean ikusi ahal izatea cuevas-en eskaerak
        if ($sailaid  == "3") {
            $qb->orWhere(
                'u.username= :username'
            )->setParameter('username', 'acuevas'
            );
        }

        return $qb->getQuery()->getResult();
    }

    public function findallSorted()
    {
        $qb = $this->createQueryBuilder('k')
            ->select('k')
            ->join('k.user', 'u')
            ->orderBy('u.lanpostua', 'ASC')
        ;
        return $qb->getQuery()->getResult();
    }
}
