<?php

namespace ClimaClass\ApplicationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

class AccueilController extends Controller
{
    /**
     * @Route("/index")
     * @Template()
     */
    public function indexAction(Request $request)
    {
        $user = $this->getUser();
        $reports = $this->getDoctrine()->getRepository("ClimaClassApplicationBundle:Report")->findReportForAccueil(6, 0);
        if($request->isXmlHttpRequest()){
            $reports = $this->getDoctrine()->getRepository("ClimaClassApplicationBundle:Report")->findReportForAccueil(6, 0);
        }
        return array('reports' => $reports,'user'=>$user);
    }
}
