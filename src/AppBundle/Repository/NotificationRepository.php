<?php

namespace AppBundle\Repository;

use Doctrine\DBAL\DBALException;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;

/**
 * NotificationRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class NotificationRepository extends EntityRepository
{

    public function getSinatzaileNotification()
    {
        $sql = 'SELECT  notification.id, notification.name, eskaera.hasi, eskaera.amaitu, user.email '.
            'FROM notification '.
            '  INNER JOIN eskaera ON eskaera.id = notification.eskaera_id '.
            '  INNER JOIN firma ON firma.eskaera_id = eskaera.id '.
            '  INNER JOIN firmadet on firmadet.firma_id = firma.id '.
            '  INNER JOIN sinatzaileakdet ON sinatzaileakdet.id = firmadet.sinatzaileakdet_id '.
            '  INNER JOIN user ON user.id = sinatzaileakdet.user_id '.
            'WHERE notification.notified = 0 '.
            'ORDER BY user.id;'
        ;


        /** @var EntityManager $em */
        $em = $this->getEntityManager();


        try {
            $query = $em->getConnection()->prepare($sql);
            $query->execute();
            $clients = $query->fetchAll();

        } catch (DBALException $e) {
            $clients = null;
        }

        return $clients;
    }

    public function getAllUnreadSortedByUser()
    {
        /** @var QueryBuilder $qb */
        $qb = $this->createQueryBuilder('n')
                   ->select('n,e,u')
                   ->innerJoin('n.eskaera', 'e')
                   ->innerJoin('e.user', 'u')
                   ->andWhere('n.readed=false')
                   ->andWhere('n.notified=false')
                   ->orderBy('u.id');

        return $qb->getQuery()->getResult();
    }

    public function getAllUnread($userid)
    {
        /** @var QueryBuilder $qb */
        $qb = $this->createQueryBuilder('n')
                   ->innerJoin('n.user', 'u')
                   ->where('u.id=:userid')
                   ->andWhere('n.readed=false')
                   ->setParameter('userid', $userid);

        return $qb->getQuery()->getResult();
    }

    public function getCurrentUserNotifications($userid, $q)
    {

        $qb = $this->createQueryBuilder('n')
                   ->innerJoin('n.user', 'u')
                    ->innerJoin('n.eskaera','e')
                   ->where('u.id=:userid')

                   ->setParameter('userid', $userid);

        if ($q) {

            if ($q === 'unread') {
                $qb->andWhere('n.readed=false');
            } elseif ($q === 'readed') {
                $qb->andWhere('n.readed=true');
            } elseif ($q === 'unanswered') {
                $qb->andWhere('n.result=false');
            } elseif ($q === 'lastsignature') {
                $qb->andWhere('n.result=false');
            }
        }

//        dump($userid);
//        dump($q);
//        dump($qb->getQuery()->getSQL());

        return $qb->getQuery()->getResult();
    }

    public function getAllUserNotifications($q)
    {

        $qb = $this->createQueryBuilder('n')
                   ->innerJoin('n.user', 'u');

        if ($q) {

            if ($q === 'unread') {
                $qb->andWhere('n.readed=false');
            } elseif ($q === 'readed') {
                $qb->andWhere('n.readed=true');
            } elseif ($q === 'unanswered') {
                $qb->andWhere('n.result=false');
            }

        }


        return $qb->getQuery()->getResult();
    }

    public function getNotificationForFirma($firmaid)
    {
        $qb = $this->createQueryBuilder('n')
                   ->select('n,u')
                   ->innerJoin('n.user', 'u')
                   ->innerJoin('n.firma', 'f')
                   ->where('f.id=:firmaid')
                   ->setParameter('firmaid', $firmaid);

        return $qb->getQuery()->getResult(Query::HYDRATE_ARRAY);
    }
}
