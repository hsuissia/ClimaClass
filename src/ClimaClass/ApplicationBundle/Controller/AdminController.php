<?php

namespace ClimaClass\ApplicationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminController extends Controller {

    /**
     * @Route("/admin", name="admin")
     * @Template()
     */
    public function adminAction(Request $request) {
        
        return array();
    }

}
