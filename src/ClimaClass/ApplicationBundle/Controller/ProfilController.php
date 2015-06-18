<?php

namespace ClimaClass\ApplicationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use ClimaClass\ApplicationBundle\Form\AccountType;
class ProfilController extends Controller
{
    /**
     * @Route("/profile/{id}", name="profile")
     * @Template()
     */
    public function viewProfileAction($id)
    {
       $class = $this->getDoctrine()->getRepository("ClimaClassApplicationBundle:User")->find($id);
       return array('class' => $class,'id'=>$id);
       
    }
    
    /**
     * @Route("/my_account/{id}", name="my_account")
     * @Template()
     */
    public function myAccountAction($id)
    {
       $class = $this->getDoctrine()->getRepository("ClimaClassApplicationBundle:User")->find($id);
       $form = $this->createForm(new AccountType(),$class);
       $form->add('Submit','submit');
       return array('form' => $form->createView(),'id'=>$id);
       
    }
}
