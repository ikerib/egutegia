<?php

/*
 *     Iker Ibarguren <@ikerib>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * TemplateEventRepository.
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class TemplateEventRepository extends EntityRepository
{
    public function getTemplateEvents($templateid)
    {
        $em = $this->getEntityManager();
        /** @var $query \Doctrine\DBAL\Query\QueryBuilder */
        $query = $em->createQuery('
            SELECT te,tt
                FROM AppBundle:TemplateEvent te
                  LEFT JOIN te.template t
                  LEFT JOIN te.type tt
                WHERE t.id = :templateid
        ');

        //$consulta = $em->createQuery($dql);
        $query->setParameter('templateid', $templateid);

        return $query->getResult();
    }

    public function getPintatuGorriz($templateid)
    {
        $em = $this->getEntityManager();
        /** @var $query QueryBuilder */
        $query = $em->createQuery('
            SELECT te
                FROM AppBundle:TemplateEvent te
                  LEFT JOIN te.type tt
                  INNER JOIN te.template t
                WHERE tt.instantziaegutegianerakutsi=1 and t.id=:templateid
        ')->setParameter('templateid',$templateid);


        return $query->getResult();
    }
}
