<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Eskaera controller.
 *
 * @Route("zerrendak")
 */
class ZerrendaController extends Controller
{

    /**
     * @Route("/absentismo")
     * @param Request $request
     *
     * @return Response
     */
    public function absentismoAction(Request $request): Response
    {
        $em = $this->getDoctrine()->getManager();
        $urteak = $em->getRepository('AppBundle:Calendar')->getEgutegiUrteak();
        $testua = '';

        $hasi      = $request->request->get('data_hasi');
        $fin       = $request->request->get('data_amaitu');

        $eskaerak = $em->getRepository('AppBundle:Eskaera')->findAbsentismo($hasi, $fin);



        if (!$eskaerak) {
            $testua = 'Ez dago daturik, aldatu filtroak...';
        } else {
            $testua = 'Erakusten '.$hasi.'-tik '.$fin.'-era bitartean eskaerak dituzten langileak.';
        }
        return $this->render('zerrenda/absentismo.html.twig', array(
            'urteak'    => $urteak,
            'eskaerak'  => $eskaerak,
            'testua'    => $testua
        ));
    }

    /**
     * @Route("/konpentsatuak")
     * @param Request $request
     *
     * @return Response
     */
    public function konpentsatuakAction(Request $request): Response
    {
        //        FORM POST PARAMETERS
        $hasi      = $request->request->get('data_hasi');
        $fin       = $request->request->get('data_amaitu');
        $urtea     = $request->request->get('urtea');
        $saila     = $request->request->get('saila');
        $lanpostua = $request->request->get('lanpostua');
        $mota      = $request->request->get('mota');

        if ((!$urtea) && (!$mota)) {
            $urtea = date('Y');
            $mota  = 6;
        }

        $em = $this->getDoctrine()->getManager();


        $konpentsatuak = $em->getRepository('AppBundle:Event')->findKonpentsatuak($hasi, $fin, $urtea, $saila, $lanpostua, $mota);
        $sailak        = $em->getRepository('AppBundle:User')->findSailGuztiak();
        $urteak        = $em->getRepository('AppBundle:Calendar')->getEgutegiUrteak();
        $lanpostuak    = $em->getRepository('AppBundle:User')->findLanpostuGuztiak();
        $motak         = $em->getRepository('AppBundle:Type')->findAll();


        $testua = $urtea.'-ko datuak erakusten ';
        if ($hasi) {
            $testua .= $hasi.'-tik hasita ';
        }
        if ($fin) {
            $testua .= $fin.'-erarte. ';
        }
        if ($saila) {
            $testua .= ' Saila:'.$saila;
        }
        if ($lanpostua) {
            $testua .= ' Lanpostua:'.$lanpostua;
        }
        if ($mota) {
            $motatest = $em->getRepository('AppBundle:Type')->find($mota);
            if ($motatest) {
                $testua .= ' Mota:'.$motatest->getName();
            }

        }

        return $this->render('zerrenda/zerrenda_konpentsatuak.html.twig', array(
            'konpentsatuak' => $konpentsatuak,
            'sailak'        => $sailak,
            'lanpostuak'    => $lanpostuak,
            'urteak'        => $urteak,
            'motak'         => $motak,
            'testua'        => $testua,
        ));
    }

}
