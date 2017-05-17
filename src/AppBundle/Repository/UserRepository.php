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
 * UserRepository.
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class UserRepository extends EntityRepository
{
    public function getByUsername($username)
    {
        $em = $this->getEntityManager();
        /** @var $query \Doctrine\DBAL\Query\QueryBuilder */
        $query = $em->createQuery('
            SELECT u
                FROM AppBundle:User u
                WHERE u.username like :username
        ');

        //$consulta = $em->createQuery($dql);
        $query->setParameter('username', $username);

        return $query->getOneOrNullResult();
    }
}
