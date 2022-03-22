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

class SinatzaileAldaketaCommand extends ContainerAwareCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('app:sinatzaile_aldaketa')
            ->setDescription('');

    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $em = $this->getContainer()->get('doctrine')->getManager();

        $eskaerak = $em->createQueryBuilder()
            ->select('e,t,s')
            ->from('AppBundle:Eskaera', 'e')
            ->innerJoin('e.type', 't')
            ->leftJoin('e.sinatzaileak', 's')
            ->where('e.amaitua=0')
            ->orderBy('e.id','DESC')->getQuery()->getResult();

        /** @var Eskaera $eskaera */
        foreach ($eskaerak as $eskaera) {

            /** @var Firma $firma */
            $firma = $eskaera->getFirma();
            /** @var Firmadet $firmadet */
            $firmadet = $firma->getFirmadet();
            /** @var Sinatzaileak $sinatzaile */
            $sinatzailea = $eskaera->getSinatzaileak();
            /** @var Sinatzaileakdet $sinatzaileak */
            $sinatzaileak = $sinatzailea->getSinatzaileakdet();

            foreach ($sinatzaileak as $sina) {
                $aurkitua = false;
                foreach ( $firmadet as $f) {

                    if ($f->getSinatzaileakdet() === $sina) {
                        $aurkitua = true;
                    }
                }
                if (!$aurkitua) {
                    $f = new Firmadet();
                    $f->setFirma($firma);
                    $f->setSinatzaileakdet($sina);
                    $em->persist($f);
                    $em->flush();
                }
            }
        }

        $output->writeln('Orain exekutatu app:jakinarazpen_aldaketa');
    }
}
