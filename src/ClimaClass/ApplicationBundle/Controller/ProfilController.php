<?php

namespace ClimaClass\ApplicationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use ClimaClass\ApplicationBundle\Form\AccountType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class ProfilController extends Controller {

    /**
     * @Route("/profile/{id}", name="profile")
     * @Template()
     */
    public function viewProfileAction($id, Request $request) {
        $tabtemp = array();
        $tabrainlevel = array();
        $tmpraintab = array();
        $tabwind = array();
        
        $class = $this->getDoctrine()->getRepository("ClimaClassApplicationBundle:User")->find($id);
        $reports = $this->getDoctrine()->getRepository("ClimaClassApplicationBundle:Report")->findByUser($class, array('postDate' => 'desc'));
        
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate($reports, $request->query->getInt('page', 1), 3);
        
        $reportsInYear = $this->getDoctrine()->getRepository("ClimaClassApplicationBundle:Report")->findReportForCharts($class);
        
        $next_month = date("Y-m-d", strtotime(date('Y-m-d') . "- 1years + 1month "));
        $datetime_year_before = new \DateTime($next_month);
        $datetime_today = new \DateTime(date('Y-m-d'));
        while($datetime_year_before->getTimestamp() <= $datetime_today->getTimestamp()){
            $tmpraintab[$datetime_year_before->format('F')] = null;
            $datetime_year_before->modify("+ 1months");
        }
        $start_month = $datetime_year_before->format('Y-m');
        echo $start_month;
        foreach ($reportsInYear as $report) {
            foreach ($report->getMeasures() as $measures) {
                if ($measures->getTemperature() != "") {
                    $tmptab = array();
                    $tmptab['date'] = $measures->getMeasurementDate()->format('Y-m-d');
                    $tmptab['temp'] = $measures->getTemperature();
                    $tabtemp[] = $tmptab;
                }
                if ($measures->getWindSpeed() != "") {
                    $tmptab = array();
                    $tmptab['date'] = $measures->getMeasurementDate()->format('Y-m-d');
                    $tmptab['speed'] = $measures->getWindSpeed();
                    $tmptab['direction'] = $measures->getWindDirection();
                    $tabwind[] = $tmptab;
                }
                if ($measures->getRainLevel() != null) {
                    $tmpraintab[$measures->getMeasurementDate()->format('F')] += $measures->getRainLevel();
                }
               
            }
        }
        foreach ($tmpraintab as $key => $val) {
            $tmptab = array();
            $tmptab['month'] = $key;
            $tmptab['rainlevel'] = $val;
            $tabrainlevel[] = $tmptab;
        }
        return array('class' => $class, 'id' => $id, 'pagination' => $pagination, 'tabtemp' => $tabtemp, 'tabwind' => $tabwind, 'tabrain' => $tabrainlevel, 'start_month' => $start_month);
    }

    /**
     * @Route("/my_account/{id}", name="my_account")
     * @Template()
     */
    public function myAccountAction($id, Request $request) {
        $class = $this->getDoctrine()->getRepository("ClimaClassApplicationBundle:User")->find($id);
        if ($class != $this->getUser()) {
            throw new AccessDeniedHttpException('Vous n\'avez pas l\'accès a cette page.');
        }
        $form = $this->createForm(new AccountType(), $class);
        
        $form->add('Submit', 'submit');
        $form->handleRequest($request);
        if ($form->isValid()) {
            $userManager = $this->get('fos_user.user_manager');
            $class->upload();
            $userManager->updateUser($class);
        }
        return array('form'=>$form->createView(),'id'=>$id);
    }
        

}
