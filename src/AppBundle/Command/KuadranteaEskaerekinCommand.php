<?php

namespace AppBundle\Command;

use AppBundle\Entity\Eskaera;
use AppBundle\Entity\Event;
use AppBundle\Entity\Kuadrantea;
use AppBundle\Entity\KuadranteaEskaerekin;
use AppBundle\Entity\User;
use DateInterval;
use DatePeriod;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class KuadranteaEskaerekinCommand extends ContainerAwareCommand
{
    private $em;
    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct();
        $this->em = $em;
    }

    protected function configure()
    {
        $this
            ->setName('app:kuadrantea-eskaerekin')
            ->setDescription('...')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // TRUNCATE
        $classMetaData = $this->em->getClassMetadata('AppBundle:KuadranteaEskaerekin');
        $connection = $this->em->getConnection();
        $dbPlatform = $connection->getDatabasePlatform();
        $connection->beginTransaction();
        try {
            $connection->query('SET FOREIGN_KEY_CHECKS=0');
            $q = $dbPlatform->getTruncateTableSql($classMetaData->getTableName());
            $connection->executeUpdate($q);
            $connection->query('SET FOREIGN_KEY_CHECKS=1');
            $connection->commit();
        }
        catch (\Exception $e) {
            $connection->rollback();
        }



        $year = date('Y');
        // urteko lehen astea bada, aurreko urtea aukeratu
        $date_now = new DateTime();
        // $date2    = new DateTime("06/01/".$year);
        $date2    = new DateTime($year.'-01-06');

        if ($date_now <= $date2) {
            --$year;
        }

        /** @var $users  User **/
        $users = $this->em->getRepository('AppBundle:User')->getAllAktibo();
        /** @var User $user */
        foreach ($users as $user) {
            $months = ['January', "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
            $i = 0;
            $len = count($months);
            foreach ($months as $month) {
                $k = new KuadranteaEskaerekin();
                $k->setUser($user);
                $k->setUrtea($year);
                $k->setHilabetea($month);
                $this->em->persist($k);
                if ($i === $len - 1) {
                    $k = new KuadranteaEskaerekin();
                    $k->setUser($user);
                    $k->setUrtea($year+1);
                    $k->setHilabetea('january');
                    $this->em->persist($k);
                }
                $i++;
                $this->em->persist($k);
            }

            $this->em->flush();


            // get current user all events
            /** @var Eskaera $eskaerak */
            $eskaerak = $this->em->getRepository('AppBundle:Eskaera')->getUserYearEvents($user->getId(), $year);
            $hilabetea = "";
            $kua = null;

            /** @var Eskaera $esk */
            foreach ($eskaerak as $esk) {

                $kuadranteak = $this->em->getRepository('AppBundle:KuadranteaEskaerekin')->findByUserYearMonth(
                    $user->getId(),
                    $esk->getHasi()->format('Y'),
                    $esk->getHasi()->format('F')
                );

                if (count($kuadranteak) === 0) {
                    continue;
                }

                $kua = $kuadranteak[0];

                if ($esk->getHasi() == $esk->getAmaitu()) {
                    $field = "setDay".$esk->getHasi()->format('d');
                    $kua->{$field}($esk->getType()->getLabur() . ' => ' . $esk->getType()->getName());
                } else {
                    $begin = new \DateTime($esk->getHasi()->format('Y-m-d'));

                    if ($esk->getAmaitu() === null) {
                        $end = new \DateTime($esk->getHasi()->format('Y-m-d'));
                    } else {
                        $end = new \DateTime($esk->getAmaitu()->format('Y-m-d'));
                    }

                    $interval = DateInterval::createFromDateString('1 day');
                    $period = new DatePeriod($begin, $interval, $end);

                    foreach ($period as $dt) {

                        $field = "setDay".$dt->format('d');
                        $kua->{$field}($esk->getType()->getLabur() . ' => ' . $esk->getType()->getName());
                    }
                }
                $this->em->persist($kua);
            }
        }
        $this->em->flush();
        $output->writeln('OK.');
    }

}
