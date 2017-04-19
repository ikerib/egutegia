<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class LogRepository extends EntityRepository
{
    public function findCalendarLogs($calendarid)
    {
        $em = $this->getEntityManager();
        /** @var  $query \Doctrine\DBAL\Query\QueryBuilder */
        $query = $em->createQuery("
            SELECT l
                FROM AppBundle:Log l
                WHERE l.calendar = :calendarid
        ");

        //$consulta = $em->createQuery($dql);
        $query->setParameter('calendarid', $calendarid);

        return $query->getResult();

    }
}
