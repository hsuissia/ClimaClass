<?php

namespace ClimaClass\ApplicationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use ClimaClass\ApplicationBundle\Form\ReportType;
use Symfony\Component\HttpFoundation\Request;
use ClimaClass\ApplicationBundle\Entity\Report;
use ClimaClass\ApplicationBundle\Form\CommentType;
use ClimaClass\ApplicationBundle\Entity\Comment;
class ReportController extends Controller
{
    /**
     * @Route("/report/{id}", name="report")
     * @Template()
     */
    public function viewReportAction($id, Request $request)
    {
       $report = $this->getDoctrine()->getRepository("ClimaClassApplicationBundle:Report")->find($id);
       $comment = new Comment();
       $form = $this->createForm(new CommentType(),$comment);
       $form->add('Send','submit');
       $form->handleRequest($request);
       
       if($form->isValid()){
           $em = $this->getDoctrine()->getManager();
           $comment->setReport($report);
           $comment->setUser($this->getUser());
           $comment->setPostDate(new \DateTime(date('Y-m-d H:i:s')));
           $em->persist($comment);
           $em->flush();
           return $this->redirect($this->generateUrl('report',array('id'=>$id)));
       }
       return array('report' => $report,'form'=>$form->createView());
       
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
           foreach($report->getMeasures() as $measure){
               $measure->setReport($report);
           }
           
           foreach($report->getVideos() as $video){

               $video->upload();
               $video->setReport($report);
           }
           $em->persist($report);
           $em->flush();
       }
       return array('form' => $form->createView());      
    }
    
    /**
     * @Route("/edit_report/{id}", name="edit_report")
     * @Template("ClimaClassApplicationBundle:Report:createReport.html.twig")
     */
    public function editReportAction(Request $request,$id)
    {  
       $report = $this->getDoctrine()->getRepository("ClimaClassApplicationBundle:Report")->find($id);
       $form = $this->createForm(new ReportType(),$report);
       $form->add('Save','submit');
       $form->handleRequest($request);
       
       if($form->isValid()){
           $em = $this->getDoctrine()->getManager();
           $report->setPostDate(new \DateTime(date('Y-m-d H:i:s')));
           $report->setLastModificationDate(new \DateTime(date('Y-m-d H:i:s')));
           $report->setUser($this->getUser());
           foreach($report->getMeasures() as $measure){
               $measure->setReport($report);
           }
           
           foreach($report->getVideos() as $video){

               $video->upload();
               $video->setReport($report);
           }
           $em->persist($report);
           $em->flush();
       }
       return array('form' => $form->createView());      
    }
}
