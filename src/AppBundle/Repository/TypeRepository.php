<?php

/*
 *     Iker Ibarguren <@ikerib>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace AppBundle\Repository;

/**
 * TypeRepository.
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class TypeRepository extends \Doctrine\ORM\EntityRepository
{
    public function findAllByOrder($calendarid)
    {
        $em = $this->getEntityManager();
        /** @var $query \Doctrine\DBAL\Query\QueryBuilder */
        $query = $em->createQuery('
            SELECT DISTINCT  t.id, t.name, t.color, t.hours, t.orden
                FROM AppBundle:Type t
                INNER JOIN t.events e
                LEFT JOIN t.template_events te
                INNER JOIN e.calendar c
                WHERE c.id = :calendarid AND t.erakutsi = 1
                ORDER BY t.orden
        ');

        $query->setParameter('calendarid', $calendarid);

        return $query->getResult();
    }

    public function findAllTemplateEventsType($calendarid)
    {
        $em = $this->getEntityManager();

        /** @var \Doctrine\DBAL\Query\QueryBuilder $query */
        $query = $em->createQuery(
            'SELECT DISTINCT t.id, t.name, t.color, t.hours, t.orden
            FROM AppBundle:Calendar c
            INNER JOIN c.template tt
            INNER JOIN tt.template_events te
            INNER JOIN te.type t
            WHERE c.id = :calendarid  AND t.erakutsi = 1
            ORDER BY t.orden
        '
        );

        $query->setParameter('calendarid', $calendarid);

        return $query->getResult();
    }

    public function findAllTypesOfTemplateEvents($templateid)
    {
        $em = $this->getEntityManager();

        /** @var \Doctrine\DBAL\Query\QueryBuilder $query */
        $query = $em->createQuery(
            'SELECT DISTINCT t.id, t.name, t.color, t.hours, t.orden
            FROM AppBundle:Template tt
            INNER JOIN tt.template_events te
            INNER JOIN te.type t
            WHERE tt.id = :templateid  AND t.erakutsi = 1
            ORDER BY t.orden
        '
        );

        $query->setParameter('templateid', $templateid);

        return $query->getResult();
    }
}
