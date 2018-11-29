<?php

namespace AppBundle\Repository;

/**
 * SinatzaileakdetRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class SinatzaileakdetRepository extends \Doctrine\ORM\EntityRepository
{
    public function getSinatuBeharDutenErabiltzaileak($sinatzaileakid)
    {
        $qm = $this->createQueryBuilder('sd')
            ->where('sd.sinatzaileak=:sinatzaileakid')
            ->setParameter('sinatzaileakid', $sinatzaileakid);

        return $qm->getQuery()->getResult();
    }


    public function findAllByIdSorted($sinatzaileakid)
    {
        $qm = $this->createQueryBuilder('sd')
                   ->where('sd.sinatzaileak=:sinatzaileakid')
                   ->setParameter('sinatzaileakid', $sinatzaileakid)
                   ->orderBy('sd.orden', 'ASC');

        return $qm->getQuery()->getResult();
    }
}
