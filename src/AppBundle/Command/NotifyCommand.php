<?php

namespace AppBundle\Command;

use AppBundle\Entity\Notification;
use AppBundle\Entity\User;
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
            ->setName('app:notify')
            ->setDescription('Jakinarazpenak bidali');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln([
            'Notifikazioak bilatzen',
            '============',
            '',
        ]);

        $em = $this->getContainer()->get( 'doctrine' )->getManager();
        $notifications = $em->getRepository( 'AppBundle:Notification' )->getAllUnreadSortedByUser();

        /** @var User $temp */
        $temp ="";
        $index = -1;
        $arrNotify=[];

        /** @var Notification $notify */
        foreach ($notifications as $notify) {
            $index+=1;
            if ( $temp !== $notify->getUser() ) {
                $temp = $notify->getUser();
                $arrNotify[ $index ][ "email" ] = $temp->getEmail();
                
            }
        }

    }
}