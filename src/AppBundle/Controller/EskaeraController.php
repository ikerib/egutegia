<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Calendar;
use AppBundle\Entity\Document;
use AppBundle\Entity\Eskaera;
use AppBundle\Entity\Event;
use AppBundle\Entity\Firma;
use AppBundle\Entity\Firmadet;
use AppBundle\Entity\Gutxienekoak;
use AppBundle\Entity\Gutxienekoakdet;
use AppBundle\Entity\Notification;
use AppBundle\Entity\Sinatzaileakdet;
use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Request;
use Knp\Bundle\SnappyBundle\Snappy\Response\PdfResponse;

/**
 * Eskaera controller.
 *
 * @Route("eskaera")
 */
class EskaeraController extends Controller
{
    /**
     * Lists all eskaera entities.
     *
     * @Route("/", name="eskaera_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $this->denyAccessUnlessGranted('ROLE_USER', null, 'Egin login');

        /** @var User $user */
        $user = $this->getUser();

        $em = $this->getDoctrine()->getManager();

        $eskaeras = $em->getRepository('AppBundle:Eskaera')->findAllByUser($user->getId());

        return $this->render('eskaera/index.html.twig', array(
            'eskaeras' => $eskaeras,
        ));
    }

    /**
     * @Route("/lista", name="admin_eskaera_list")
     * @Method("GET")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listAction(Request $request)
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'Egin login');
        $em = $this->getDoctrine()->getManager();

        $q = $request->query->get('q');


        if ( ($q == null) || ($q == 'all' )) {
            $eskaeras = $em->getRepository('AppBundle:Eskaera')->findAll();
        } else  {
            $eskaeras = $em->getRepository('AppBundle:Eskaera')->list($q);
        }

        $deleteForms = [];
        foreach ($eskaeras as $e) {
            /** @var Eskaera $e */
            $deleteForms[$e->getId()] = $this->createDeleteForm($e)->createView();
        }

        return $this->render('eskaera/list.html.twig', array(
            'eskaeras' => $eskaeras,
            'deleteForms' => $deleteForms,
        ));
    }

    /**
     * Eskaera gehitu langilearen egutegira.
     *
     * @Route("/addToCalendar/{id}", name="eskaera_add_to_calendar")
     * @Method({"GET"})
     * @param Request $request
     *
     * @param Eskaera $eskaera
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function addToCalendarAction(Request $request, Eskaera $eskaera)
    {
        $this->denyAccessUnlessGranted('ROLE_USER', null, 'Egin login');

        $em = $this->getDoctrine()->getManager();

        // Eskuratu langilearen egutegia

        /** @var Calendar $calendar */
        $calendar = $em->getRepository('AppBundle:Calendar')->find($eskaera->getCalendar()->getId());

        $ev = new Event();
        $ev->setCalendar($calendar);
        $ev->setName("Eskaeratik: ".$eskaera->getName());
        $ev->setStartDate($eskaera->getHasi());
        $ev->setEndDate($eskaera->getAmaitu());
        $ev->setHours($eskaera->getOrduak());
        $ev->setType($eskaera->getType());
        $em->persist($ev);

        $eskaera->setEgutegian(true);
        $em->persist($eskaera);

        $em->flush();

        $this->addFlash('success', 'Datuak ongi gordeak izan dira.');
        return $this->redirectToRoute('admin_eskaera_list');

    }


    /**
     * Creates a new eskaera entity.
     *
     * @Route("/new", name="eskaera_new")
     * @Method({"GET", "POST"})
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function newAction(Request $request)
    {
        $this->denyAccessUnlessGranted('ROLE_USER', null, 'Egin login');

        $em = $this->getDoctrine()->getManager();

        /** @var User $user */
        $user = $this->getUser();

        /** @var Calendar $calendar */
        $calendar = $em->getRepository('AppBundle:Calendar')->findByUsernameYear(
            $user->getUsername(),
            date('Y')
        );

        $calendar = $calendar[ 0 ];

        $eskaera = new Eskaera();
        $eskaera->setUser( $user );
        $eskaera->setName( $user->getDisplayname() );
        $eskaera->setCalendar( $calendar );
        $form = $this->createForm('AppBundle\Form\EskaeraType', $eskaera, array(
            'action' => $this->generateUrl('eskaera_new'),
            'method' => 'POST',
        ));
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $data = $form->getData();

            $user = $data->getUser();
            $fini = $data->getHasi();
            $ffin = $data->getAmaitu();
            $collision="";


            /**
             * 1-. Begiratu ea bateraezinik duen
             */
            $gutxienekoak = $em->getRepository( 'AppBundle:Eskaera' )->checkErabiltzaileaBateraezinZerrendan($data->getUser()->getId());
            /**
             * 2-. Bateraezinik badu, begiratu ea koinzidentziarik dagoen
             */
            if ($gutxienekoak > 0 ) {

                /** @var Gutxienekoak $g */
                foreach ($gutxienekoak as $g) {
                    $gutxienekoakdet = $g->getGutxienekoakdet();
                    foreach ($gutxienekoakdet as $gd) {
                        /** @var Gutxienekoakdet $gd */
                        if ( $gd->getUser() !== $user){
                            $collision = $em->getRepository( 'AppBundle:Event' )->checkCollision($gd->getUser()->getId(), $fini, $ffin);
                        }
                    }
                }

            }

            /**
             * 3-. Bateraezin talderen batean badago, eta fetxa koinzidentziarenbat baldin badu
             *     koinziditzen duen erabiltzaile ororen eskaeretan oharra jarri.
             */
            if ( count($collision) > 0 ) {
                $txt="";
                /** @var Event $e */
                foreach ($collision as $e) {
                    $txt = $txt . " - " .  $e->getCalendar()->getUser();
                }
                $txtOharra = $eskaera->getOharra() . " ADI!!  " . $txt . " langileekin koinzidentziak ditu";
                $eskaera->setOharra($txtOharra);
            }

            /** PDF Fitxategia sortu */

            $user = $this->getUser();

            $name = $user->getUsername() . '-' . $eskaera->getType() . '-' . $eskaera->getNoiz()->format('Y-m-d') .'-' . $eskaera->getAmaitu()->format('Y-m-d') . '.pdf';

            $nirepath = $user->getUsername() . '/' . $eskaera->getNoiz()->format('Y').'/';

            $filename = $this->container->getParameter('kernel.root_dir') . '/../web/uploads/' . $nirepath . $name;
            $filename = preg_replace("/app..../i", "", $filename);

            if (!file_exists($filename)) {
                $this->get('knp_snappy.pdf')->generateFromHtml(
                    $this->renderView(
                        'eskaera/print.html.twig',
                        array(
                            'eskaera' => $eskaera,
                        )
                    ),$filename
                );
            }

            $em->persist($eskaera);

            $doc = new Document();
            $doc->setFilename($name);
            $doc->setFilenamepath($filename);
            $doc->setCalendar($eskaera->getCalendar());
            $em->persist($doc);

            $em->flush();


            $bideratzaileakfind = $em->getRepository('AppBundle:User')->findByRole('ROLE_BIDERATZAILEA');
            $bideratzaileak = [];
            foreach ($bideratzaileakfind as $b){
                array_push($bideratzaileak, $b->getEmail());
            }
            $bailtzailea = $this->container->getParameter('mailer_bidaltzailea');

            /**
             * Behin grabatuta bidali jakinarazpen emaila Ruth-i
             */
            $message = (new \Swift_Message('[Egutegia][Eskaera berria] :'.$eskaera->getUser()->getDisplayname()))
                ->setFrom($bailtzailea)
                ->setTo($bideratzaileak)
                ->setBody(
                    $this->renderView(
                    // app/Resources/views/Emails/registration.html.twig
                        'Emails/eskaera_berria.html.twig',
                        array('eskaera' => $eskaera)
                    ),
                    'text/html'
                );

            $this->get('mailer')->send($message);



            return $this->redirectToRoute('eskaera_show', array('id' => $eskaera->getId()));

        }

        return $this->render('eskaera/new.html.twig', array(
            'eskaera' => $eskaera,
            'calendar'=> $calendar,
            'form' => $form->createView(),
        ));
    }


    /**
     * Finds and displays a eskaera entity.
     *
     * @Route("/{id}", name="eskaera_show")
     * @Method("GET")
     * @param Eskaera $eskaera
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showAction(Eskaera $eskaera)
    {
        $this->denyAccessUnlessGranted('ROLE_USER', null, 'Egin login');
        $deleteForm = $this->createDeleteForm($eskaera);

        return $this->render('eskaera/show.html.twig', array(
            'eskaera' => $eskaera,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Get PDF Document.
     *
     * @Route("/{id}/pdf", name="eskaera_pdf")
     * @Method("GET")
     * @param Eskaera $eskaera
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function pdfAction(Eskaera $eskaera)
    {
        $this->denyAccessUnlessGranted('ROLE_USER', null, 'Egin login');
        $user = $this->getUser();
        $html = $this->renderView('eskaera/print.html.twig', array(
            'eskaera' => $eskaera,
        ));

        $name = $user->getUsername() . '-' . $eskaera->getType() . '-' . $eskaera->getNoiz()->format('Y-m-d') . '.pdf';

        $filename = $this->container->getParameter('kernel.root_dir') . '/../web/uploads/' . $name;
        $filename = preg_replace("/app..../i", "", $filename);

        if (!file_exists($filename)) {
            $this->get('knp_snappy.pdf')->generateFromHtml(
                $this->renderView(
                    'eskaera/print.html.twig',
                    array(
                        'eskaera' => $eskaera,
                    )
                ),$filename
            );
            return new PdfResponse(
                $this->get('knp_snappy.pdf')->getOutputFromHtml($html),
                $filename
            );
        } else {
            return new BinaryFileResponse($filename);

        }


    }

    /**
     * Finds and prints a eskaera entity.
     *
     * @Route("/print/{id}", name="eskaera_print")
     * @Method("GET")
     * @param Eskaera $eskaera
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function printAction(Eskaera $eskaera)
    {
        $this->denyAccessUnlessGranted('ROLE_USER', null, 'Egin login');

        return $this->render('eskaera/print.html.twig', array(
            'eskaera' => $eskaera,
        ));
    }

    /**
     * Displays a form to edit an existing eskaera entity.
     *
     * @Route("/{id}/edit", name="admin_eskaera_edit")
     * @Method({"GET", "POST"})
     * @param Request $request
     * @param Eskaera $eskaera
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Request $request, Eskaera $eskaera)
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'Egin login');
        $deleteForm = $this->createDeleteForm($eskaera);
        $editForm = $this->createForm('AppBundle\Form\EskaeraType', $eskaera, array(
            'action' => $this->generateUrl('admin_eskaera_edit', array('id'=>$eskaera->getId())),
            'method' => 'POST'
        ));
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            if ( $eskaera->getSinatzaileak() ) {

                /*
                 * 2-. Begiratu firma entitaterik ez duela (abiatua = false) eta firma entitatea bete
                 */
                if ( $eskaera->getAbiatua() == false) {

                    $firma = New Firma();
                    $firma->setName( $eskaera->getName() );
                    $firma->setSinatzaileak( $eskaera->getSinatzaileak() );
                    $firma->setEskaera( $eskaera );
                    $firma->setCompleted( 0 );
                    $em->persist( $firma );

                    $eskaera->setAbiatua( true );
                    $em->persist( $eskaera );

                    $sinatzaileusers = $firma->getSinatzaileak()->getSinatzaileakdet();
                    /** @var Sinatzaileakdet $s */
                    foreach ($sinatzaileusers as $s) {
                        $notify = New Notification();
                        $notify->setName( 'Eskaera berria sinatzeke: ' . $eskaera->getUser()->getDisplayname() );
                        $notify->setDescription(
                            $eskaera->getUser()->getDisplayname() . " langilearen eskaera berria daukazu sinatzeke.\n" .
                            "Egutegia: " . $eskaera->getCalendar()->getName()."\n".
                            "Hasi: " . $eskaera->getHasi()->format('Y-m-d')."\n".
                            "Amaitu: ". $eskaera->getAmaitu()->format('Y-m-d')

                        );
                        $notify->setEskaera( $eskaera );
                        $notify->setFirma( $firma );
                        $notify->setReaded( false );
                        $notify->setUser( $s->getUser() );
                        $em->persist( $notify );

                        /**
                         * bidali emaila notifikatzen firmatu beharreko eskaerak dituela
                         */
                        if (strlen($s->getUser()->getEmail())>0){

                            $message = (new \Swift_Message('[Egutegia][Janirazpen berria] :'.$eskaera->getUser()->getDisplayname()))
                                ->setFrom('informatika@pasaia.net')
                                ->setTo($s->getUser()->getEmail())
                                ->setBody(
                                    $this->renderView(
                                    // app/Resources/views/Emails/registration.html.twig
                                        'Emails/jakinarazpen_berria.html.twig',
                                        array('eskaera' => $eskaera)
                                    ),
                                    'text/html'
                                );

                            $this->get('mailer')->send($message);

                        }



                        $fd = new Firmadet();
                        $fd->setFirma( $firma );
                        $fd->setSinatzaileakdet( $s );
                        $em->persist( $fd );

                    }

                } else if ($eskaera->getAmaitua() === false) {

                }


            }
            $em->flush();

            return $this->redirectToRoute('admin_eskaera_list');
        }

        return $this->render('eskaera/edit.html.twig', array(
            'eskaera' => $eskaera,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a eskaera entity.
     *
     * @Route("/{id}", name="eskaera_delete")
     * @Method("DELETE")
     * @param Request $request
     * @param Eskaera $eskaera
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction(Request $request, Eskaera $eskaera)
    {
        $this->denyAccessUnlessGranted('ROLE_USER', null, 'Egin login');
        $form = $this->createDeleteForm($eskaera);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($eskaera);
            $em->flush();
        }

        return $this->redirectToRoute('admin_eskaera_list');
    }

    /**
     * Creates a form to delete a eskaera entity.
     *
     * @param Eskaera $eskaera The eskaera entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Eskaera $eskaera)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('eskaera_delete', array('id' => $eskaera->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
