<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;

/**
 * NotificationRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class NotificationRepository extends EntityRepository
{
    public function getAllUnread($userid) {
        /** @var QueryBuilder $qb */
        $qb = $this->createQueryBuilder('n')
            ->innerJoin('n.user', 'u')
            ->where('u.id=:userid')
            ->andWhere('n.readed=false')
            ->setParameter('userid',$userid)
        ;

        return $qb->getQuery()->getResult();
    }

    public function getCurrentUserNotifications($userid, $readed) {

        $qb = $this->createQueryBuilder( 'n' )
            ->innerJoin( 'n.user', 'u' )
            ->where( 'u.id=:userid' )
            ->setParameter( 'userid', $userid );

        if ($readed) {

            if ($readed == -1 ) {
                $qb->andWhere( 'n.readed=false' );
            } elseif ($readed == 1) {
                $qb->andWhere( 'n.readed=true' );
            }

        }



        return $qb->getQuery()->getResult();
    }

}
