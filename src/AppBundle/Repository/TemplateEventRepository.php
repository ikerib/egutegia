<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;


/**
 * TemplateEventRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class TemplateEventRepository extends EntityRepository
{
    public function getTemplateEvents($templateid)
    {
        $em = $this->getEntityManager();
        /** @var  $query \Doctrine\DBAL\Query\QueryBuilder */
        $query = $em->createQuery("
            SELECT te
                FROM AppBundle:TemplateEvent te 
                  INNER JOIN te.template t
                  LEFT JOIN te.type tt
                WHERE t.id = :templateid
        ");

        //$consulta = $em->createQuery($dql);
        $query->setParameter('templateid', $templateid);

        return $query->getResult();

    }

}
