<?php

namespace AppBundle\Command;

use AppBundle\Entity\Notification;
use AppBundle\Entity\User;
use DateTime;
use Swift_Message;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class NotifyCommand extends ContainerAwareCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName( 'app:notify' )
            ->setDescription( 'Jakinarazpenak bidali' );
    }

    /**
     * {@inheritdoc}
     */
    protected function execute( InputInterface $input, OutputInterface $output )
    {
        $output->writeln( [
                              'Notifikazioak bilatzen',
                              '======================',
                              '',
                          ] );

        $em = $this->getContainer()->get( 'doctrine' )->getManager();
        $notifications = $em->getRepository( 'AppBundle:Notification' )->getSinatzaileNotification();

        $temp = "";
        $berria =0;
        $sendTo="";

        if ( $notifications ) {

            $textua = "";

            foreach ($notifications as $notify) {

                if ($temp == "") {
                    $temp = $notify[ 'email' ];
                    $berria=1;
                    $sendTo = $temp;
                } else {
                    if ( $temp != $notify[ 'email' ] ) {
                        $this->bidaliEmail( $sendTo, $textua );
                        $textua ="";
                        $temp = $notify[ 'email' ];
                        $berria=1;
                        $sendTo = $temp;

                    }
                }

                $fHasi = DateTime::createFromFormat('Y-m-d h:m:s', $notify['hasi']);
                $hasi = $fHasi->format( 'Y-m-d' );
                $fFin = DateTime::createFromFormat('Y-m-d h:m:s', $notify['amaitu']);
                $amaitu = $fFin->format( 'Y-m-d' );

                if ($berria == 1) {
                    $berria = 0;
                    $textua = $sendTo. "=>". $notify[ 'name' ] . " langilearen eskaera berria. Hasi: " . $hasi . " Amaitu: " . $amaitu;

                } else {

                    $textua .= "<br />".$sendTo. "=>".$notify[ 'name' ] . " langilearen eskaera berria. Hasi: " . $hasi . " Amaitu: " . $amaitu;
                }


                /*
                * Markatu jakinarazpena bidalia bezela
                */
                /** @var Notification $not */
                $not = $em->getRepository( 'AppBundle:Notification' )->find( $notify[ 'id' ] );
                if ($not) {
                    $not->setNotified( 1 );
                    $em->persist( $not );
                    $em->flush();
                }


            }
            $this->bidaliEmail( $sendTo, $textua );



        }
        $output->writeln("FIN!");

    }
    private  function bidaliEmail($sendTo, $testua) {
        $bidaltzailea = $this->getContainer()->getParameter( 'mailer_bidaltzailea' );
        $message = ( new \Swift_Message( '[Egutegia][Eskaera berriak]' ) )
                    ->setFrom( $bidaltzailea )
                    ->setTo($sendTo)
                    ->setBody( $testua, 'text/html');


        $this->getContainer()->get( 'mailer' )->send( $message );
    }
}