<?php

namespace AppBundle\Command;

use AppBundle\Entity\Eskaera;
use AppBundle\Entity\Firma;
use AppBundle\Entity\Firmadet;
use AppBundle\Entity\Notification;
use AppBundle\Entity\Sinatzaileak;
use AppBundle\Entity\Sinatzaileakdet;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class JakinarazpenAldaketaCommand extends ContainerAwareCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('app:jakinarazpen_aldaketa')
            ->addArgument('origenUserId', InputArgument::REQUIRED, 'Aurreko erabiltzaile id')
            ->addArgument('destinoUserId', InputArgument::REQUIRED, 'Aurreko erabiltzaile id')
            ->setDescription('Jakinarazpenak aldatu erabiltzaile batetik bestera');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $em = $this->getContainer()->get('doctrine')->getManager();

        $notifications = $em->createQueryBuilder('n')
            ->select('n')
            ->from('AppBundle:Notification', 'n')
            ->innerJoin('n.user', 'u')
            ->where('u.id=:userid')
            ->andWhere('n.completed=false')
            ->setParameter('userid', $input->getArgument('origenUserId'))
            ->getQuery()->getResult()
        ;

        $userDestino = $em->getRepository('AppBundle:User')->find($input->getArgument('destinoUserId'));

        /** @var Notification $n */
        foreach ($notifications as $n) {

            $resp = $this->checkNotifyExist($n->getEskaera()->getId(),$userDestino->getId());
            if ( $resp === "0" ) {

                $no = new Notification();
                $no->setUser($userDestino);
                $no->setFirma($n->getFirma());
                $no->setName($n->getName());
                $no->setCompleted($n->getCompleted());
                $no->setDescription($n->getDescription());
                $no->setEskaera($n->getEskaera());
                $no->setNotified($n->getNotified());
                $no->setOrden($n->getOrden());
                $no->setReaded($n->getReaded());
                $no->setResult($n->getResult());
                $no->setSinatzeprozesua($n->getSinatzeprozesua());
                $em->persist($no);
                $em->flush();
            }
        }

        $output->writeln('Prozesua amaitu da');
    }
    private function checkNotifyExist( $eskaeraid, $destinyUserId) {
        $em = $this->getContainer()->get('doctrine')->getManager();

        return $em->createQueryBuilder('n')
            ->select('COUNT(n)')
            ->from('AppBundle:Notification', 'n')
            ->innerJoin('n.user', 'u')
            ->where('u.id=:userid')
            ->setParameter('userid', $destinyUserId)
            ->innerJoin('n.eskaera', 'e')
            ->andWhere('e.id=:eskaeraid')
            ->setParameter('eskaeraid', $eskaeraid)
            ->getQuery()->getSingleScalarResult()
            ;

    }
}
