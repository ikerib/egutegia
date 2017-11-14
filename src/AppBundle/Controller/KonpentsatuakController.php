<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Calendar;
use AppBundle\Entity\Document;
use AppBundle\Entity\Konpentsatuak;
use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Knp\Bundle\SnappyBundle\Snappy\Response\PdfResponse;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

/**
 * Konpentsatuak controller.
 *
 * @Route("konpentsatuak")
 */
class KonpentsatuakController extends Controller
{
    /**
     * Lists all konpentsatuak entities.
     *
     * @Route("/", name="konpentsatuak_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $konpentsatuaks = $em->getRepository('AppBundle:Konpentsatuak')->findAll();

        return $this->render('konpentsatuak/index.html.twig', array(
            'konpentsatuaks' => $konpentsatuaks,
        ));
    }

    /**
     * @Route("/lista", name="admin_konpentsatuak_list")
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
            $konpentsatuak = $em->getRepository('AppBundle:Konpentsatuak')->findAll();
        } else  {
            $konpentsatuak = $em->getRepository('AppBundle:Konpentsatuak')->list($q);
        }

        $deleteForms = [];
        foreach ($konpentsatuak as $e) {
            /** @var Konpentsatuak $e */
            $deleteForms[$e->getId()] = $this->createDeleteForm($e)->createView();
        }

        return $this->render('eskaera/edit.html.twig', array(
            'konpentsatuak' => $konpentsatuak,
            'deleteForms' => $deleteForms,
        ));
    }
    
    /**
     * Creates a new konpentsatuak entity.
     *
     * @Route("/new", name="konpentsatuak_new")
     * @Method({"GET", "POST"})
     * @param Request $request
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

        $konpentsatuak = new Konpentsatuak();
        $konpentsatuak->setUser($user);
        $konpentsatuak->setName( $user->getDisplayname() );
        $konpentsatuak->setCalendar($calendar);

        $mota = $em->getRepository('AppBundle:Type')->findOneBy(array('name' => 'Konpentsatuak',
        ));

        $konpentsatuak->setType($mota);

        $form = $this->createForm('AppBundle\Form\KonpentsatuakType', $konpentsatuak);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($konpentsatuak);
            $em->flush();


            /** PDF Fitxategia sortu */

            $user = $this->getUser();

            $name = $user->getUsername() . '-' . $konpentsatuak->getType() . '-' . $konpentsatuak->getFetxa()->format('Y-m-d') . '.pdf';

            $nirepath = 'tmp/' . $user->getUsername() . '/' . $konpentsatuak->getNoiz()->format('Y').'/';

            $filename = $this->container->getParameter('kernel.root_dir') . '/../web/uploads/' . $nirepath . $name;
            $filename = preg_replace("/app..../i", "", $filename);

            if (!file_exists($filename)) {
                $this->get('knp_snappy.pdf')->generateFromHtml(
                    $this->renderView(
                        'konpentsatuak/print.html.twig',
                        array(
                            'konpentsatuak' => $konpentsatuak,
                        )
                    ),$filename
                );
            }

            $em->persist($konpentsatuak);

            $doc = new Document();
            $doc->setFilename($name);
            $doc->setFilenamepath($filename);
            $doc->setCalendar($konpentsatuak->getCalendar());
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
            $message = (new \Swift_Message('[Egutegia][Ordu Konpentsatu eskaera berria] :'.$konpentsatuak->getUser()->getDisplayname()))
                ->setFrom($bailtzailea)
                ->setTo($bideratzaileak)
                ->setBody(
                    $this->renderView(
                    // app/Resources/views/Emails/registration.html.twig
                        'Emails/konpentsatuak_berria.html.twig',
                        array('konpentsatuak' => $konpentsatuak)
                    ),
                    'text/html'
                );

            $this->get('mailer')->send($message);


            return $this->redirectToRoute('konpentsatuak_show', array('id' => $konpentsatuak->getId()));
        }

        return $this->render('konpentsatuak/new.html.twig', array(
            'konpentsatuak' => $konpentsatuak,
            'calendar'=> $calendar,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a konpentsatuak entity.
     *
     * @Route("/{id}", name="konpentsatuak_show")
     * @Method("GET")
     */
    public function showAction(Konpentsatuak $konpentsatuak)
    {
        $deleteForm = $this->createDeleteForm($konpentsatuak);

        return $this->render('konpentsatuak/show.html.twig', array(
            'konpentsatuak' => $konpentsatuak,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Get PDF Document.
     *
     * @Route("/{id}/pdf", name="konpentsatuak_pdf")
     * @Method("GET")
     * @param Konpentsatuak $konpentsatuak
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function pdfAction(Konpentsatuak $konpentsatuak)
    {
        $this->denyAccessUnlessGranted('ROLE_USER', null, 'Egin login');
        $user = $this->getUser();
        $html = $this->renderView('konpentsatuak/print.html.twig', array(
            'konpentsatuak' => $konpentsatuak,
        ));

        $name = $user->getUsername() . '-' . $konpentsatuak->getType() . '-' . $konpentsatuak->getNoiz()->format('Y-m-d') . '.pdf';

        $nirepath = 'tmp/' . $user->getUsername() . '/' . $konpentsatuak->getNoiz()->format('Y').'/';

        $filename = $this->container->getParameter('kernel.root_dir') . '/../web/uploads/' . $nirepath . $name;
        $filename = preg_replace("/app..../i", "", $filename);

        if (!file_exists($filename)) {
            $this->get('knp_snappy.pdf')->generateFromHtml(
                $this->renderView(
                    'konpentsatuak/print.html.twig',
                    array(
                        'konpentsatuak' => $konpentsatuak,
                    )
                ),$filename
            );

            $response = new BinaryFileResponse($filename);

            $response->headers->set('Content-Type', 'application/pdf');
            $response->setContentDisposition(
                ResponseHeaderBag::DISPOSITION_INLINE, //use ResponseHeaderBag::DISPOSITION_ATTACHMENT to save as an attachement
                $name
            );

            return $response;

        } else {
            return new BinaryFileResponse($filename);

        }


    }

    /**
     * Displays a form to edit an existing konpentsatuak entity.
     *
     * @Route("/{id}/edit", name="konpentsatuak_edit")
     * @Method({"GET", "POST"})
     * @param Request $request
     * @param Konpentsatuak $konpentsatuak
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Request $request, Konpentsatuak $konpentsatuak)
    {
        $deleteForm = $this->createDeleteForm($konpentsatuak);
        $editForm = $this->createForm('AppBundle\Form\KonpentsatuakType', $konpentsatuak);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('konpentsatuak_edit', array('id' => $konpentsatuak->getId()));
        }

        return $this->render('konpentsatuak/edit.html.twig', array(
            'konpentsatuak' => $konpentsatuak,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a konpentsatuak entity.
     *
     * @Route("/{id}", name="konpentsatuak_delete")
     * @Method("DELETE")
     * @param Request $request
     * @param Konpentsatuak $konpentsatuak
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction(Request $request, Konpentsatuak $konpentsatuak)
    {
        $form = $this->createDeleteForm($konpentsatuak);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($konpentsatuak);
            $em->flush();
        }

        return $this->redirectToRoute('konpentsatuak_index');
    }

    /**
     * Creates a form to delete a konpentsatuak entity.
     *
     * @param Konpentsatuak $konpentsatuak The konpentsatuak entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Konpentsatuak $konpentsatuak)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('konpentsatuak_delete', array('id' => $konpentsatuak->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
