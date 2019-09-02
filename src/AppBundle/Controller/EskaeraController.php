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
use AppBundle\Form\EskaeraJustifyType;
use AppBundle\Service\CalendarService;
use AppBundle\Service\NotificationService;
use Doctrine\ORM\EntityNotFoundException;
use Doctrine\ORM\ORMException;
use Exception;
use GuzzleHttp\Exception\GuzzleException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Knp\Bundle\SnappyBundle\Snappy\Response\PdfResponse;
use GuzzleHttp\Client;
use AppBundle\Form\EskaeraType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use function count;

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
     * @Route("/", name="eskaera_index", methods={"GET"})
     */
    public function indexAction(): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER', null, 'Egin login');

        /** @var User $user */
        $user = $this->getUser();

        $em = $this->getDoctrine()->getManager();

        $eskaeras = $em->getRepository('AppBundle:Eskaera')->findAllByUser($user->getId());

        $types = $em->getRepository('AppBundle:Type')->findEskaerak();

        $deleteForms = [];
        foreach ($eskaeras as $e) {
            /** @var Eskaera $e */
            $deleteForms[ $e->getId() ] = $this->createDeleteForm($e)->createView();
        }

        return $this->render(
            'eskaera/index.html.twig',
            array(
                'eskaeras' => $eskaeras,
                'types'    => $types,
                'deleteForms'   => $deleteForms,
            )
        );
    }

    /**
     *
     * @Route("/instantziak", name="eskaera_instantziak", methods={"GET"})
     */
    public function eskaerainstantziakAction(): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER', null, 'Egin login');

        /** @var User $user */
        $user = $this->getUser();

        $em = $this->getDoctrine()->getManager();

        $types = $em->getRepository('AppBundle:Type')->findEskaerak();

        return $this->render(
            'eskaera/instantziak.html.twig',
            array(
                'types' => $types,
            )
        );
    }


    /**
     * @Route("/lista", name="admin_eskaera_list", methods={"GET"})
     * @param Request $request
     *
     * @return Response
     */
    public function listAction(Request $request): Response
    {
        $this->denyAccessUnlessGranted(['ROLE_ADMIN', 'ROLE_SINATZAILEA'], null, 'Egin login');
        $em = $this->getDoctrine()->getManager();

        $q       = $request->query->get('q');
        $history = $request->query->get('history', '1');
        $lm = $request->query->get('lm');

        if ((($q === null) || ($q === 'all')) && $history === '1') {
            $eskaeras = $em->getRepository('AppBundle:Eskaera')->findAll();
        } else {
            $eskaeras = $this->get('app.eskaera.repository')->list($q, $history, $lm);
        }

        $deleteForms = [];
        foreach ($eskaeras as $e) {
            /** @var Eskaera $e */
            $deleteForms[ $e->getId() ] = $this->createDeleteForm($e)->createView();
        }

        $lizentziamotak = $em->getRepository('AppBundle:Lizentziamota')->findAll();

        return $this->render(
            'eskaera/list.html.twig',
            array(
                'eskaeras'      => $eskaeras,
                'deleteForms'   => $deleteForms,
                'lizentziamotak'=> $lizentziamotak,
                'q'             => $q,
                'history'       => $history,
                'lm'            => $lm
            )
        );
    }

    /**
     * Eskaera gehitu langilearen egutegira.
     *
     * @Route("/addToCalendar/{id}", name="eskaera_add_to_calendar", methods={"GET"})
     *
     * @param Eskaera $eskaera
     *
     * @return RedirectResponse|Response
     * @throws ORMException
     */
    public function addToCalendarAction(Eskaera $eskaera)
    {
        $this->denyAccessUnlessGranted('ROLE_USER', null, 'Egin login');

        $em = $this->getDoctrine()->getManager();

        $aData = array(
            'calendar_id' => $eskaera->getCalendar()->getId(),
            'type_id'     => $eskaera->getType(),
            'event_name'  => 'Eskaeratik: Id: '.$eskaera->getId(),
            'event_start' => $eskaera->getHasi(),
            'event_fin'   => $eskaera->getAmaitu(),
            'event_hours' => $eskaera->getTotal(),
            'eskaera_id'  => $eskaera->getId()
        );

        if ($eskaera->getType()->getId() === 5) {
            $aData[ 'event_nondik' ]                 = $eskaera->getNondik();
            $aData[ 'event_hours_self_before' ]      = $eskaera->getCalendar()->getHoursSelf();
            $aData[ 'event_hours_self_half_before' ] = $eskaera->getCalendar()->getHoursSelfHalf();
        }

        /** @var CalendarService $niresrv */
        $niresrv = $this->get('app.calendar.service');
        $resp    = $niresrv->addEvent($aData);

        if ($resp[ 'result' ] === - 1) {
            $this->addFlash('error', 'Ez ditu nahikoa ordu.');

            return $this->redirectToRoute('admin_eskaera_list');
        }

        $eskaera->setEgutegian(true);
        $em->persist($eskaera);
        $em->flush();

        $this->addFlash('success', 'Datuak ongi gordeak izan dira.');

        return $this->redirectToRoute('admin_eskaera_list');
    }

    /**
     * Creates a new eskaera entity.
     *
     * @Route("/new/{q}", name="eskaera_new", methods={"GET", "POST"})

     * @param Request $request
     *
     * @param         $q
     *
     * @return RedirectResponse|Response
     * @throws ORMException
     */
    public function newAction(Request $request, $q)
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

        if (!$calendar) {
            return $this->render(
                'default/no_calendar_error.html.twig',
                [
                    'h1Textua' => 'Ez daukazu Egutegirik sortuta aplikazioan',
                    'h3Testua' => 'Deitu Pertsonal sailera',
                    'user'     => $user,
                ]
            );
        }
        /** @var Calendar $calendar */
        $calendar = $calendar[ 0 ];

        $eskaera = new Eskaera();
        $eskaera->setUser($user);
        $eskaera->setName($user->getDisplayname());
        $eskaera->setCalendar($calendar);

        $type = $em->getRepository('AppBundle:Type')->find($q);
        $eskaera->setType($type);

        $form = $this->createForm(
            EskaeraType::class,
            $eskaera,
            array(
                'action' => $this->generateUrl('eskaera_new', array('q' => $q)),
                'method' => 'POST',
            )
        );
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em   = $this->getDoctrine()->getManager();
            /** @var Eskaera $data */
            $data = $form->getData();

            $user       = $data->getUser();
            $fini       = $data->getHasi();
            $ffin       = $data->getAmaitu();
            $collision1 = '';
            $collision2 = '';


            /**
             * 1-. Begiratu ea bateraezinik duen
             */
            $gutxienekoak = $em->getRepository('AppBundle:Eskaera')->checkErabiltzaileaBateraezinZerrendan($data->getUser()->getId());
            /**
             * 2-. Bateraezinik badu, begiratu ea koinzidentziarik dagoen
             */
            if ($gutxienekoak > 0) {

                /** @var Gutxienekoak $g */
                foreach ($gutxienekoak as $g) {
                    $gutxienekoakdet = $g->getGutxienekoakdet();
                    foreach ($gutxienekoakdet as $gd) {
                        /** @var Gutxienekoakdet $gd */
                        if ($gd->getUser() !== $user) {
                            $collision1 = $em->getRepository('AppBundle:Event')->checkCollision($gd->getUser()->getId(), $fini, $ffin);
                            $collision2 = $em->getRepository('AppBundle:Eskaera')->checkCollision($gd->getUser()->getId(), $fini, $ffin);
                        }
                    }
                }
            }

            /**
             * 3-. Bateraezin talderen batean badago, eta fetxa koinzidentziarenbat baldin badu
             *     koinziditzen duen erabiltzaile ororen eskaeretan oharra jarri.
             */
            if (($collision1 !== '') || ($collision2 !== '')) {
                if (count($collision1) > 0) {
                    $txt = '';
                    /** @var Event $e */
                    foreach ($collision1 as $e) {
                        $txt .= ' - '.$e->getCalendar()->getUser();
                    }
                    $txtOharra = $eskaera->getOharra().' ADI!!  '.$txt.' langileekin koinzidentziak ditu';
                    $eskaera->setOharra($txtOharra);
                    $eskaera->setKonfliktoa(true);
                }
                if (count($collision2) > 0) {
                    $txt = '';
                    /** @var Event $e */
                    foreach ($collision2 as $e) {
                        $txt .= ' - '.$e->getCalendar()->getUser();
                    }
                    $txtOharra = $eskaera->getOharra().' ADI!!  '.$txt.' langileekin koinzidentziak ditu';
                    $eskaera->setOharra($txtOharra);
                    $eskaera->setKonfliktoa(true);
                }
            }


            /**
             * PDF Fitxategia sortu
             */

            /** @var User $user */
            $user = $this->getUser();
            $noiz = date('Y-m-d');
            if ($eskaera->getNoiz()->format('Y-m-d') !== null) {
                $noiz = $eskaera->getNoiz()->format('Y-m-d');
            }

            $amaitu = '';
            if ($eskaera->getAmaitu() !== null) {
                $amaitu = $eskaera->getAmaitu()->format('Y-m-d');
            }

            if ($data->getJustifikanteFile() !== null) {
                $eskaera->setJustifikatua(1);
            }
            $em->persist($eskaera);
            $em->flush();

            // Sartu datuak egutegian
            $aData = array(
                'calendar_id' => $eskaera->getCalendar()->getId(),
                'type_id'     => $eskaera->getType(),
                'event_name'  => 'Eskaeratik: Id: '.$eskaera->getId(),
                'event_start' => $eskaera->getHasi(),
                'event_fin'   => $eskaera->getAmaitu(),
                'event_hours' => $eskaera->getTotal(),
                'eskaera_id'  => $eskaera->getId()
            );

            if ($eskaera->getType()->getId() === 5) {
                $aData[ 'event_nondik' ]                 = $eskaera->getNondik();
                $aData[ 'event_hours_self_before' ]      = $eskaera->getCalendar()->getHoursSelf();
                $aData[ 'event_hours_self_half_before' ] = $eskaera->getCalendar()->getHoursSelfHalf();
            }

            /** @var CalendarService $niresrv */
            $niresrv = $this->get('app.calendar.service');
            $resp    = $niresrv->addEvent($aData);

            return $this->redirectToRoute('eskaera_gauzatua', array('id' => $eskaera->getId()));
        }

        $jaiegunak = $em->getRepository('AppBundle:TemplateEvent')->findBy(
            array(
                'template' => $calendar->getTemplate()->getId(),
            )
        );


        return $this->render(
            'eskaera/new.html.twig',
            array(
                'eskaera'   => $eskaera,
                'calendar'  => $calendar,
                'jaiegunak' => $jaiegunak,
                'form'      => $form->createView(),
            )
        );
    }

    /**
     * Eskaera zuzen gauzatua izan da
     *
     * @Route("/{id}/ok", name="eskaera_gauzatua", methods={"GET"})
     * @param Eskaera $eskaera
     *
     * @return Response
     */
    public function gauzatuaAction(Eskaera $eskaera): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER', null, 'Egin login');
        $deleteForm = $this->createDeleteForm($eskaera);

        return $this->render(
            'eskaera/gauzatua.html.twig',
            array(
                'eskaera'     => $eskaera,
                'delete_form' => $deleteForm->createView(),
            )
        );
    }

    /**
     * Get PDF Document.
     *
     * @Route("/{id}/pdf", name="eskaera_pdf", methods={"GET"})
     * @param Eskaera $eskaera
     *
     * @return Response
     */
    public function pdfAction(Eskaera $eskaera): ?Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER', null, 'Egin login');
        /** @var User $user */
        $user = $this->getUser();
        $html = $this->renderView(
            'eskaera/print.html.twig',
            array(
                'eskaera' => $eskaera,
            )
        );

        $name = $user->getUsername().'-'.$eskaera->getType().'-'.$eskaera->getNoiz()->format('Y-m-d').'-'.$eskaera->getAmaitu()->format('Y-m-d').'.pdf';

        $filepath = '/'.$user->getUsername().'/'.$eskaera->getNoiz()->format('Y').'/';

        $filename = $filepath.$name;

        $tmpPath = $this->getParameter('app.dir_tmp_pdf');

        $nirepath = $tmpPath.$filename;

        if (!file_exists($nirepath)) {
            $this->get('knp_snappy.pdf')->generateFromHtml(
                $this->renderView(
                    'eskaera/print.html.twig',
                    array(
                        'eskaera' => $eskaera,
                    )
                ),
                $filename
            );

            return new PdfResponse(
                $this->get('knp_snappy.pdf')->getOutputFromHtml($html),
                $filename
            );
        }

        return new BinaryFileResponse($nirepath);
    }

    /**
     * Finds and prints a eskaera entity.
     *
     * @Route("/print/{id}", name="eskaera_print", methods={"GET"})
     * @param Eskaera $eskaera
     *
     * @return Response
     */
    public function printAction(Eskaera $eskaera): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER', null, 'Egin login');

        return $this->render(
            'eskaera/print.html.twig',
            array(
                'eskaera' => $eskaera,
            )
        );
    }

    /**
     * Displays a form to edit an existing eskaera entity.
     *
     * @Route("/{id}/edit", name="admin_eskaera_edit", methods={"GET", "POST"})
     * @param Request $request
     * @param Eskaera $eskaera
     *
     * @return RedirectResponse|Response
     * @throws GuzzleException
     */
    public function editAction(Request $request, Eskaera $eskaera)
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'Egin login');
        $q       = $request->query->get('q');
        $history = $request->query->get('history', '0');
        $lm = $request->query->get('lm');

        $deleteForm = $this->createDeleteForm($eskaera);
        $editForm   = $this->createForm(
            EskaeraType::class,
            $eskaera,
            array(
                'action' => $this->generateUrl(
                    'admin_eskaera_edit',
                    array(
                    'id' => $eskaera->getId(),
                    'q'=>$q,
                    'history'=>$history,
                    'lm'=>$lm
                    )
                ),
                'method' => 'POST',
            )
        );

        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            if ($eskaera->getSinatzaileak()) {

                /*
                 * 2-. Begiratu firma entitaterik ez duela (abiatua = false) eta firma entitatea bete
                 */
                if ($eskaera->getAbiatua() === false) {
                    $eskaera->setAbiatua(true);
                    $sinatubeharda = true;
                    /** @var NotificationService $notifysrv */
                    $notifysrv = $this->container->get('app.sinatzeke');

                    $firma = new Firma();
                    if ($eskaera->getLizentziamota()) {
                        if ($eskaera->getLizentziamota()->getSinatubehar() === false) {
                            $sinatubeharda = false;
                        }
                    }


                    $sinatzaileusers = $em->getRepository('AppBundle:Sinatzaileakdet')->findAllByIdSorted($eskaera->getSinatzaileak()->getId());
                    /** @var Sinatzaileakdet $lehenSinatzaile */
                    $lehenSinatzaile = $sinatzaileusers[ 0 ];

                    if ($sinatubeharda) {
                        $firma->setName($eskaera->getName());
                        $firma->setSinatzaileak($eskaera->getSinatzaileak());
                        $firma->setEskaera($eskaera);
                        $firma->setCompleted(0);
                        $em->persist($firma);
                        $em->flush(); // Ez badago flushik, ez dado ID-rik

                        $_ez_notifikatu = null; // Autofirmarekin bada, ez du jakinarazpena sortu beharrik

                        /** @var Sinatzaileakdet $s */
                        foreach ($sinatzaileusers as $s) {
                            /** @var Firmadet $fd */
                            $fd = new Firmadet();
                            $fd->setFirma($firma);
                            $fd->setSinatzaileakdet($s);

                            /* TODO: Eskatzailea sinatzaile zerrendan badago autofirmatu */

                            $eskatzaile_id = $eskaera->getUser()->getId();

                            if ($s->getUser()->getId() === $eskatzaile_id) {
                                // Autofirmatu. Eskatzailea eta sinatzaile zerrendako user berdinak direnez, firmatu

                                /** @var Client $client */
                                $client = $this->get('eight_points_guzzle.client.api_put_firma');
//                            $url = '/app_dev.php/api/postit/'.$firma->getId().'/'.$eskatzaile_id.'.json?autofirma=1?XDEBUG_SESSION_START=PHPSTORM';
                                $url = '/app_dev.php/api/postit/'.$firma->getId().'/'.$eskatzaile_id.'.json?autofirma=1';

                                $client->request('PUT', $url, ['json' => $eskaera, 'autofirma' => 1]);

                                $firmatzailea = $em->getRepository('AppBundle:User')->find($eskatzaile_id);

                                $fd->setAutofirma(true);
                                $fd->setFirmatua(true);
                                $fd->setFirmatzailea($firmatzailea);
                            }
                            $em->persist($fd);
                        }
                        $em->persist($fd);
                        $eskaera->setBideratua(true);
                        $em->persist($eskaera);
                        $em->flush();
                        // SOILIK LEHENA NOTIFIKATU
                        $notifysrv->sendNotificationToFirst($eskaera, $firma, $lehenSinatzaile);
                    } else {
                        $eskaera->setBideratua(true);
                        $eskaera->setAmaitua(true);
                        $em->persist($eskaera);
                        $em->flush();
                        // SOILIK LEHENA NOTIFIKATU
                        $notifysrv->sendNotificationToFirst($eskaera, null, $lehenSinatzaile);
                    }
                } elseif ($eskaera->getAmaitua() === false) {
                    echo 'kaka';
                }
            }


            return $this->redirectToRoute('admin_eskaera_list', [
                'q'=>$q,
                'history'=> $history,
                'lm'=>$lm
            ]);
        }

        return $this->render(
            'eskaera/edit.html.twig',
            array(
                'eskaera'     => $eskaera,
                'edit_form'   => $editForm->createView(),
                'delete_form' => $deleteForm->createView(),
            )
        );
    }

    /**
     * Displays a form to edit an existing eskaera entity.
     *
     * @Route("/{id}/justify", name="eskaera_justify", methods={"GET", "POST"})
     * @param Request $request
     * @param Eskaera $eskaera
     *
     * @return RedirectResponse|Response
     */
    public function justifyAction(Request $request, Eskaera $eskaera)
    {
        $editForm = $this->createForm(
            EskaeraJustifyType::class,
            $eskaera,
            array(
                'action' => $this->generateUrl('eskaera_justify', array('id' => $eskaera->getId())),
                'method' => 'POST',
            )
        );
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();

            if ($eskaera->getJustifikanteFile() !== null) {
                $eskaera->setJustifikatua(true);
                $em->persist($eskaera);
                $em->flush();


                $url = $request->get('nondik');

                return new RedirectResponse($url);
            }
        }

        return $this->render(
            'eskaera/justify.html.twig',
            array(
                'eskaera'   => $eskaera,
                'edit_form' => $editForm->createView(),
            )
        );
    }


    /**
     * Deletes a Justify file.
     *
     * @Route("/justity/file/{id}", name="eskaera_justify_file_delete", methods={"GET"})
     * @param Request $request
     * @param Eskaera $eskaera
     *
     * @return RedirectResponse
     * @throws Exception
     */
    public function deleteJustifyFileAction(Request $request, Eskaera $eskaera): RedirectResponse
    {
        $this->denyAccessUnlessGranted('ROLE_USER', null, 'Egin login');
        $em = $this->getDoctrine()->getManager();
        $this->get('vich_uploader.upload_handler')->remove($eskaera, 'justifikanteFile');
        $eskaera->setJustifikanteFile(null);
        $eskaera->setJustifikanteName(null);
        $eskaera->setJustifikanteSize(null);
        $eskaera->setJustifikatua(false);
        $em->persist($eskaera);
        $em->flush();

        return $this->redirectToRoute('eskaera_index');
    }

    /**
     * Deletes a eskaera entity.
     *
     * @Route("/{id}", name="eskaera_delete", methods={"DELETE"})

     * @param Request $request
     * @param Eskaera $eskaera
     *
     * @return RedirectResponse
     */
    public function deleteAction(Request $request, Eskaera $eskaera): RedirectResponse
    {
        $this->denyAccessUnlessGranted('ROLE_USER', null, 'Egin login');
        $form = $this->createDeleteForm($eskaera);
        $form->handleRequest($request);

        $urlToRedirect = 'admin_eskaera_list';

        if ($form->isSubmitted() && $form->isValid()) {
            // Ezabatu egutegitik
            /** @var CalendarService $niresrv */
            $niresrv = $this->get('app.calendar.service');
            $resp    = $niresrv->removeEventsByEskaera($eskaera);

            if ($request->request->has('eskaerauserdelete') && $request->request->get('eskaerauserdelete') === "1") {
                $urlToRedirect = 'eskaera_index';
            }

            $em = $this->getDoctrine()->getManager();
            $em->remove($eskaera);
            $em->flush();
        }

        return $this->redirectToRoute($urlToRedirect);
    }

    /**
     * Creates a form to delete a eskaera entity.
     *
     * @param Eskaera $eskaera The eskaera entity
     *
     * @return Form|FormInterface
     */
    private function createDeleteForm(Eskaera $eskaera)
    {
        return $this->createFormBuilder()
                    ->setAction($this->generateUrl('eskaera_delete', array('id' => $eskaera->getId())))
                    ->setMethod('DELETE')
                    ->getForm();
    }

    /**
     * Finds and displays a eskaera entity.
     *
     * @Route("/{id}/show", name="eskaera_show", methods={"GET"})
     * @param Eskaera $eskaera
     *
     * @return Response
     */
    public function showAction(Eskaera $eskaera): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER', null, 'Egin login');
        $deleteForm = $this->createDeleteForm($eskaera);

        return $this->render(
            'eskaera/show.html.twig',
            array(
                'eskaera'     => $eskaera,
                'delete_form' => $deleteForm->createView(),
            )
        );
    }
}
