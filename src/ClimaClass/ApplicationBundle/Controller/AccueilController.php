<?php

namespace ClimaClass\ApplicationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AccueilController extends Controller
{
    /**
     * @Route("/index", name="index")
     * @Template()
     */
    public function indexAction(Request $request)
    {
        $reports = $this->getDoctrine()->getRepository("ClimaClassApplicationBundle:Report")->findReportForAccueil(6, 0);
        if($request->isXmlHttpRequest()){
            $html = "";
            $offset = $request->request->get('offset');
            $reports = $this->getDoctrine()->getRepository("ClimaClassApplicationBundle:Report")->findReportForAccueil(6, $offset);
            foreach($reports as $report){
                $html .= "<p>".$report->getTitle()."</p>";
            }
            return new Response($html);
        }
        return array('reports' => $reports);
    }
}
