<?php

namespace AppBundle\Command;

use AppBundle\Entity\Eskaera;
use AppBundle\Entity\Firma;
use AppBundle\Entity\Notification;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class EskaeraCompletedCommand extends ContainerAwareCommand
{

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('app:eskaera_completed')
            ->setDescription('begiratu firma denak dituen, baldin baditu, markatu eskaera amaitua bezala');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $em = $this->getContainer()->get('doctrine')->getManager();
        $jakinarazpenak = $em->getRepository('AppBundle:Notification')->findBy(
            array(
                'completed'=>0,
            )
        );

        /** @var Notification $jakinarazpena */
        foreach ($jakinarazpenak as $jakinarazpena) {
            /** @var Firma $firma */
            $firma = $jakinarazpena->getFirma();
            if ($firma->getCompleted()) {
                $jakinarazpena->setCompleted(1);
                $jakinarazpena->setResult(1);
                $em->persist($jakinarazpena);
            }
        }
        $em->flush();

        $output->writeln('Fin');
    }
}
