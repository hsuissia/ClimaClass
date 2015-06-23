<?php

namespace ClimaClass\ApplicationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use ClimaClass\ApplicationBundle\Form\AccountType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class ProfilController extends Controller
{
    /**
     * @Route("/profile/{id}", name="profile")
     * @Template()
     */
    public function viewProfileAction($id,Request $request)
    {
       $class = $this->getDoctrine()->getRepository("ClimaClassApplicationBundle:User")->find($id);
       $reports = $this->getDoctrine()->getRepository("ClimaClassApplicationBundle:Report")->findByUser($class, array('postDate' => 'desc'));
       $paginator = $this->get('knp_paginator');
       $pagination = $paginator->paginate($reports, $request->query->getInt('page', 1), 3);
       return array('class' => $class,'id'=>$id,'pagination'=>$pagination);
       
    }
    
    /**
     * @Route("/my_account/{id}", name="my_account")
     * @Template()
     */
    public function myAccountAction($id,Request $request)
    {
       $class = $this->getDoctrine()->getRepository("ClimaClassApplicationBundle:User")->find($id);
       if($class != $this->getUser()){
           throw new AccessDeniedHttpException('Vous n\'avez pas l\'accès a cette page.');
       }
       $form = $this->createForm(new AccountType(),$class);
       $form->add('Submit','submit');
       $form->handleRequest($request);
       if($form->isValid()){
           $em = $this->getDoctrine()->getManager();
           $class->upload();
           /*plainPassword*/
           $em->persist($class);
           $em->flush();
       }
       return array('form' => $form->createView(),'id'=>$id);
       
    }
}
