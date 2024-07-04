<?php

namespace AppBundle\Command;

use AppBundle\Entity\Calendar;
use AppBundle\Entity\Eskaera;
use AppBundle\Entity\TempEskaerakEgutegian;
use DateTime;
use Exception;
use Swift_Mime_SimpleMessage;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class AppCheckEskaerakEgutegianCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('app:check-eskaerak-egutegian')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $em = $this->getContainer()->get('doctrine')->getManager();
        $egutegiak = $em->getRepository('AppBundle:Calendar')->findBy([
            'year' => $this->getCurrentYear()
        ]);

        $mezua = [];

        /** @var Calendar $egutegia */
        foreach ($egutegiak as $egutegia) {
            $output->writeln('');
            $output->writeln('<info>' . $egutegia->getName(). '-ren eskaerak analizatzen...'. '</info>');
            $output->writeln('Abiatuta, amaituta eta egutegian egon beharko luketen eskaerak eta bertan behera eman ez direnak:');
            /** @var Eskaera $eskaera */
            foreach ($egutegia->getEskaeras() as $eskaera) {
                $dago = $em->getRepository('AppBundle:TempEskaerakEgutegian')->findOneBy(['eskaera' => $eskaera->getId()]);
                if ( $dago) {
                    continue;
                }
                if (( $eskaera->getAbiatua()) && ($eskaera->getAmaitua()) && ($eskaera->getEgutegian()) && ($eskaera->getBertanbehera() !== true) ) {
                    $output->write('  - #' . $eskaera->getId() .' - '.$eskaera->getType());
                    $events = $em->getRepository('AppBundle:Event')->findByDates($eskaera->getHasi(), $eskaera->getAmaitu(), $eskaera->getCalendar()->getId());
                    if (count($events) === 0) {
                        $temp = new TempEskaerakEgutegian();
                        $temp->setEskaera($eskaera->getId());
                        $em->persist($temp);
                        $em->flush();

                        $output->write('.');
                        $output->writeln('');
                        $output->writeln('<error>ADI!!!!</error>');
                        $output->writeln('<error>'. $eskaera->getId() .' zenbakia duen eskaera ez dago egutegian.</error>');
                        $output->writeln('');
                        $mezu = [
                            'id' => $eskaera->getId(),
                            'calendar' => $egutegia->getId(),
                            'type' => $eskaera->getType(),
                            'hasi' => $eskaera->getHasi(),
                            'amaitu' => $eskaera->getAmaitu(),
                        ];
                        $mezua[] = $mezu;
                    } else {
                        $output->writeln('...OK.');
                    }
                }
            }
        }

        if (count($mezua) > 0) {
            $mailer = $this->getContainer()->get('mailer');

            $twig = $this->getContainer()->get('twig');
            $body = $twig->render('emails/check-eskaerak-egutegian.html.twig', [
                'mezuak' => $mezua
            ]);

            $message = (new \Swift_Message('CHECK ESKAERAK EGUTEGIAN'))
                ->setFrom('send@example.com')
                ->setTo('rgonzalez@pasaia.net')
                ->setBody($body, 'text/html')
                ->setPriority(Swift_Mime_SimpleMessage::PRIORITY_HIGHEST);
            ;

            $result = $mailer->send($message);
        }
    }

    /**
     * @throws Exception
     */
    public function getCurrentYear($date = null): int
    {
        // Si no se proporciona una fecha, usa la fecha actual
        if ($date === null) {
            $date = date('Y-m-d');
        }

        // Convierte la fecha de entrada a un objeto DateTime
        $inputDate = new DateTime($date);

        // Obtiene el año de la fecha de entrada
        $year = (int)$inputDate->format('Y');

        // Define la fecha de finalización del año dado (primer domingo del próximo año)
        $firstDayOfNextYear = new DateTime(($year + 1) . '-01-01');
        $endOfYear = clone $firstDayOfNextYear;
        $endOfYear->modify('first Sunday');

        // Comprueba si la fecha de entrada es antes del final del año
        if ($inputDate <= $endOfYear) {
            return $year;
        }

        return $year + 1;
    }

}
