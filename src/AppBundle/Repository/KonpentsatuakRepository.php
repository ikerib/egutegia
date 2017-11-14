<?php

namespace AppBundle\Repository;

/**
 * KonpentsatuakRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class KonpentsatuakRepository extends \Doctrine\ORM\EntityRepository
{
    public function list($q) {
        $em = $this->getEntityManager();
        $dql = '';

        switch ($q) {
            case 'no-way':
                $dql = '
                      SELECT e
                      FROM AppBundle:Konpentsauak e
                      WHERE e.abiatua = 0
                ';
                break;
            case 'unsigned':
                $dql = '
                      SELECT e
                      FROM AppBundle:Konpentsauak e
                      WHERE e.amaitua = 0
                ';
                break;
            case 'unadded':
                $dql = '
                      SELECT e
                      FROM AppBundle:Konpentsauak e
                      WHERE e.egutegian = 0 and e.amaitua = 1
                ';
                break;
            default:
                $dql = '
                      SELECT e
                      FROM AppBundle:Konpentsauak e
                ';
                break;
        }

        $query = $em->createQuery($dql);
        return $query->getResult();
    }
}
