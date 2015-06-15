<?php

namespace ClimaClass\ApplicationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use ClimaClass\ApplicationBundle\Form\UserType;
class ProfilController extends Controller
{
    /**
     * @Route("/profil/{id}", name="profil")
     * @Template()
     */
    public function viewProfilAction($id)
    {
       $class = $this->getDoctrine()->getRepository("ClimaClassApplicationBundle:User")->find($id);
       return array('class' => $class,'id'=>$id);
       
    }
    
    /**
     * @Route("/modify_profil/{id}", name="modify_profil")
     * @Template()
     */
    public function modifyProfilAction($id)
    {
       $class = $this->getDoctrine()->getRepository("ClimaClassApplicationBundle:User")->find($id);
       $form = $this->createForm(new UserType(),$class);
       return array('form' => $form,'id'=>$id);
       
    }
}
