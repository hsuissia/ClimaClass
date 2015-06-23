<?php

namespace ClimaClass\ApplicationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use ClimaClass\ApplicationBundle\Form\ReportType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use ClimaClass\ApplicationBundle\Entity\Report;
use ClimaClass\ApplicationBundle\Form\CommentType;
use ClimaClass\ApplicationBundle\Entity\Comment;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class ReportController extends Controller
{
    /**
     * @Route("/report/{id}", name="report")
     * @Template()
     */
    public function viewReportAction($id, Request $request)
    {
       $report = $this->getDoctrine()->getRepository("ClimaClassApplicationBundle:Report")->find($id);
       $comments = $this->getDoctrine()->getRepository("ClimaClassApplicationBundle:Comment")->findByReport($report);
       $paginator = $this->get('knp_paginator');
       $pagination = $paginator->paginate($comments, $request->query->getInt('page', 1), 10);
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
       return array('report' => $report,'form'=>$form->createView(),'pagination'=>$pagination);
       
    }
    
    /**
     * @Route("/manage_report/create_report", name="create_report")
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
     * @Route("/manage_report/edit_report/{id}", name="edit_report")
     * @Template("ClimaClassApplicationBundle:Report:createReport.html.twig")
     */
    public function editReportAction(Request $request,$id)
    {  
       $report = $this->getDoctrine()->getRepository("ClimaClassApplicationBundle:Report")->find($id);
       if($report->getUser() != $this->getUser()){
           throw new AccessDeniedHttpException('Vous n\'avez pas l\'accès a cette page.');
       }
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
    // A GERER A LA FIN
    /**
     * @Route("/delete_video", name="delete_video")
     * @Template("")
     */
    public function deleteVideoAction(Request $request)
    {  
       if($request->isXmlHttpRequest()){
            
            $id_vid = $request->request->get('id');
            $video = $this->getDoctrine()->getRepository("ClimaClassApplicationBundle:Video")->find($id_vid);
            $em = $this->getDoctrine()->getManager();
            $em->remove($video);
            $em->flush();
            return new Response("ok");
        }  
    }
    
    /**
     * @Route("/delete_measure", name="delete_measure")
     * @Template("")
     */
    public function deleteMeasureAction(Request $request)
    {  
       if($request->isXmlHttpRequest()){
            
            $id_measure = $request->request->get('id');
            $measure = $this->getDoctrine()->getRepository("ClimaClassApplicationBundle:Measure")->find($id_measure);
            $em = $this->getDoctrine()->getManager();
            $em->remove($measure);
            $em->flush();
            return new Response("ok");
        }  
    }
}
