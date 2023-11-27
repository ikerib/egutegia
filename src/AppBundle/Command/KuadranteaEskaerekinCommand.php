<?php /** @noinspection ALL */

namespace AppBundle\Command;

use AppBundle\Entity\Eskaera;
use AppBundle\Entity\Event;
use AppBundle\Entity\Kuadrantea;
use AppBundle\Entity\KuadranteaEskaerekin;
use AppBundle\Entity\User;
use DateInterval;
use DatePeriod;
use DateTime;
use Doctrine\DBAL\ConnectionException;
use Doctrine\DBAL\DBALException;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Helper\ProgressBar;
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

    /**
     * @return void
     * @throws \Doctrine\DBAL\ConnectionException
     * @throws \Doctrine\DBAL\DBALException
     */
    public function truncateTable(): void
    {
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
        } catch (Exception $e) {
            $connection->rollback();
        }
    }

    /**
     * @param User $user
     * @param $year
     * @return void
     */
    public function sortuKuadranteEskaeraRow(User $user, $year): void
    {
        $lastExecution = new DateTime();
        $months = ['January', "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
        $i = 0;
        $len = count($months);
        foreach ($months as $month) {
            $k = new KuadranteaEskaerekin();
            $k->setUser($user);
            $k->setLastExecution($lastExecution);
            $k->setUrtea($year);
            $k->setHilabetea($month);
            $this->em->persist($k);
            if ($i === $len - 1) {
                $k = new KuadranteaEskaerekin();
                $k->setUser($user);
                $k->setUrtea($year + 1);
                $k->setHilabetea('January');
                $this->em->persist($k);
            }
            $i++;
            $this->em->persist($k);
        }

        $this->em->flush();
    }

    /**
     * @param User $user
     * @param $year
     * @return void
     * @throws Exception
     */
    public function fillFromEvents(User $user, $year): void
    {
        // get current user all events
        /** @var Event $events */
        $events = $this->em->getRepository('AppBundle:Event')->getUserYearEvents($user->getId(), $year);
        $hilabetea = "";
        $kua = null;
        /** @var Event $event */
        foreach ($events as $event) {

            $kuadranteak = $this->em->getRepository('AppBundle:KuadranteaEskaerekin')->findByUserYearMonth(
                $user->getId(),
                $event->getStartDate()->format('Y'),
                $event->getStartDate()->format('F')
            );

            if (count($kuadranteak) === 0) {
                continue;
            }

            $kua = $kuadranteak[0];

            if ($event->getStartDate() == $event->getEndDate()) {
                $field = "setDay" . $event->getStartDate()->format('d');
                $kua->{$field}($event->getType()->getLabur() . ' => ' . $event->getType()->getName().'#');

            } else {
                $begin = new \DateTime($event->getStartDate()->format('Y-m-d'));

                if ($event->getEndDate() === null) {
                    $end = new \DateTime($event->getStartDate()->format('Y-m-d'));
                } else {
                    $end = new \DateTime($event->getEndDate()->format('Y-m-d'));
                }

                $interval = new DateInterval('P1D'); // Intervalo de 1 día
                $end = $end->modify('+1 day'); // Azken eguna inprimatu dezan ere
                $period = new DatePeriod($begin, $interval, $end);

                foreach ($period as $dt) {

                    $field = "setDay" . $dt->format('d');
                    $kua->{$field}($event->getType()->getLabur() . ' => ' . $event->getType()->getName().'#');
                }
            }
            $this->em->persist($kua);
        }
    }

    /**
     * @param User $user
     * @param $year
     * @return void
     * @throws Exception
     */
    public function fillFromEskaerak(User $user, $year): void
    {
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

            // BEGIRATU IADANIK KUADRANTEAN DATURIK BADAGOEN.
            // BALDIN BADAGO, EGUTEGIKO DAUAK LEHENETSI, BERAZ, SALTO EGIN

            $rowDataField = "getDay" . $esk->getHasi()->format('d');
            $rowDataValue = $kua->{$rowDataField}();

            if ( !$rowDataValue) {
                if ($esk->getHasi() == $esk->getAmaitu()) {
                    $field = "setDay" . $esk->getHasi()->format('d');
                    $kua->{$field}($esk->getType()->getLabur() . ' => ' . $esk->getType()->getName());
                } else {
                    $begin = new \DateTime($esk->getHasi()->format('Y-m-d'));

                    if ($esk->getAmaitu() === null) {
                        $end = new \DateTime($esk->getHasi()->format('Y-m-d'));
                    } else {
                        $end = new \DateTime($esk->getAmaitu()->format('Y-m-d'));
                    }

                    $interval = new DateInterval('P1D'); // Intervalo de 1 día
                    $end = $end->modify('+1 day'); // Azken eguna inprimatu dezan ere
                    $period = new DatePeriod($begin, $interval, $end);

                    foreach ($period as $dt) {
                        $field = "setDay" . $dt->format('d');
                        $kua->{$field}($esk->getType()->getLabur() . ' => ' . $esk->getType()->getName());
                    }
                }
                $this->em->persist($kua);
            }
        }
    }

    protected function configure()
    {
        $this
            ->setName('app:kuadrantea-eskaerekin')
            ->setDescription('...')
        ;
    }

    /**
     * @throws ConnectionException
     * @throws DBALException
     * @throws Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->truncateTable();
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

        $progressBar = new ProgressBar($output, count($users));
        $progressBar->start();

        /** @var User $user */
        foreach ($users as $user) {
            $progressBar->advance();
            $this->sortuKuadranteEskaeraRow($user, $year);
            $this->fillFromEvents($user, $year);
            $this->fillFromEskaerak($user, $year);
        }
        $progressBar->finish();
        $this->em->flush();
        $output->writeln('');
        $output->writeln('OK.');
    }

}
