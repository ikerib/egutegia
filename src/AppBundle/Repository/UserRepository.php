<?php

/*
 *     Iker Ibarguren <@ikerib>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace AppBundle\Repository;

use AppBundle\Entity\User;
use Doctrine\DBAL\DBALException;
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

    public function getSailak()
    {
        $qb = $this->createQueryBuilder('u');
        $qb->select('DISTINCT(u.department) as Saila')
            ->orderBy('Saila','Asc');


        return $qb->getQuery()->getResult();
    }

    /**
     * @param string $role
     *
     * @return array
     */
    public function findByRole($role)
    {
        $qb = $this->_em->createQueryBuilder();
        $qb->select('u')
            ->from($this->_entityName, 'u')
            ->where('u.roles LIKE :roles')
            ->setParameter('roles', '%"'.$role.'"%');

        return $qb->getQuery()->getResult();
    }

    public function findSailGuztiak()
    {
        $sql = /** @lang text */
            "SELECT DISTINCT(department) FROM `user` WHERE department IS NOT NULL ORDER BY department ASC ";
        $params = array();

        try {
            return $this->getEntityManager()->getConnection()->executeQuery( $sql, $params )->fetchAll();
        } catch ( DBALException $e ) {
            throw new $e;
        }
    }

    public function findLanpostuGuztiak()
    {
        $sql = /** @lang text */
            "SELECT DISTINCT(lanpostua) FROM `user` WHERE lanpostua IS NOT NULL ORDER BY lanpostua";
        $params = array();

        try {
            return $this->getEntityManager()->getConnection()->executeQuery( $sql, $params )->fetchAll();
        } catch ( DBALException $e ) {
            throw new $e;
        }
    }
}
