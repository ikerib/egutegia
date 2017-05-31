<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;

/**
 * EskaeraRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class EskaeraRepository extends EntityRepository
{
    public function findAllByUser($id) {
        $em = $this->getEntityManager();

        $dql = '
            SELECT e
            FROM AppBundle:Eskaera e
              INNER JOIN e.user u
            WHERE u.id = :id
        ';

        $query = $em->createQuery($dql);
        $query->setParameter('id', $id);

        return $query->getResult();
    }

    public function findBideratugabeak() {
        $em = $this->getEntityManager();
        $dql = "
            SELECT e
            FROM AppBundle:Eskaera e
            WHERE e.abiatua = false AND e.amaitua = false
        ";
        $query = $em->createQuery($dql);

        return $query->getResult();
    }

    public function checkErabiltzaileaBateraezinZerrendan($userid) {
        $qb = $this->_em->createQueryBuilder()
            ->select( 'g' )

            ->from( 'AppBundle:Gutxienekoak', 'g' )
            ->innerJoin('g.gutxienekoakdet', 'gd')
            ->innerJoin( 'gd.user', 'u' )

            ->where('u.id = :userid')

            ->setParameter('userid',$userid)
            ;

        return $qb->getQuery()->getResult();
    }


}
