<?php

namespace ClimaClass\ApplicationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use ClimaClass\ApplicationBundle\Form\ReportType;
use Symfony\Component\HttpFoundation\Request;
use ClimaClass\ApplicationBundle\Entity\Report;

class ReportController extends Controller
{
    /**
     * @Route("/report/{id}", name="report")
     * @Template()
     */
    public function viewReportAction($id)
    {
       $report = $this->getDoctrine()->getRepository("ClimaClassApplicationBundle:Report")->find($id);
       return array('report' => $report);
       
    }
    
    /**
     * @Route("/create_report", name="create_report")
     * @Template()
     */
    public function createReportAction(Request $request)
    {  
       $report = new Report();
       $form = $this->createForm(new ReportType(),$report);
       $form->add('Save','submit');
       $form->handleRequest($request);
       if($form->isValid()){
           $em = $this->getDoctrine()->getManager();
           $report->setPostDate(new \DateTime(date('Y-m-d H:i:s')));
           $report->setLastModificationDate(new \DateTime(date('Y-m-d H:i:s')));
           $report->setUser($this->getUser());
           $em->persist($report);
           $em->flush();
       }
       return array('form' => $form->createView());      
    }
}
