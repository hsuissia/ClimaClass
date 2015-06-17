<?php

namespace ClimaClass\ApplicationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AccueilController extends Controller {

    /**
     * @Route("/index", name="index")
     * @Template()
     */
    public function indexAction(Request $request) {
        $reports = $this->getDoctrine()->getRepository("ClimaClassApplicationBundle:Report")->findReportForHomepage();
         
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate($reports, $request->query->getInt('page', 1), 6);
        return array('pagination' => $pagination);
    }

}
