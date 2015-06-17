<?php

namespace ClimaClass\ApplicationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use ClimaClass\ApplicationBundle\Form\UserType;
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
     * @Route("/modify_profile/{id}", name="modify_profile")
     * @Template()
     */
    public function modifyProfileAction($id)
    {
       $class = $this->getDoctrine()->getRepository("ClimaClassApplicationBundle:User")->find($id);
       $form = $this->createForm(new UserType(),$class);
       return array('form' => $form,'id'=>$id);
       
    }
}
