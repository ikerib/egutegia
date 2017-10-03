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
    public function list($q) {
        $em = $this->getEntityManager();
        $dql = '';

        switch ($q) {
            case 'no-way':
                $dql = '
                      SELECT e
                      FROM AppBundle:Eskaera e
                      WHERE e.abiatua = 0
                ';
                break;
            case 'unsigned':
                $dql = '
                      SELECT e
                      FROM AppBundle:Eskaera e
                      WHERE e.amaitua = 0
                ';
                break;
            case 'unadded':
                $dql = '
                      SELECT e
                      FROM AppBundle:Eskaera e
                      WHERE e.egutegian = 0
                ';
                break;
            default:
                $dql = '
                      SELECT e
                      FROM AppBundle:Eskaera e
                ';
        }

        $query = $em->createQuery($dql);
        return $query->getResult();
    }

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
