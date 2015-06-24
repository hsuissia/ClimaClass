<?php

namespace ClimaClass\ApplicationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use ClimaClass\ApplicationBundle\Entity\User;
use ClimaClass\ApplicationBundle\Form\RegistrationFormType;

class AdminController extends Controller {

    /**
     * @Route("/admin/", name="admin")
     * @Template()
     */
    public function adminAction(Request $request) {
        $user = new User();
        $form = $this->createForm(new RegistrationFormType(), $user);
        
        $form->add('Add', 'submit');
        $form->handleRequest($request);
        if ($form->isValid()) {
            $userManager = $this->get('fos_user.user_manager');
            $exists = $userManager->findUserBy(array('email' => $user->getEmail()));
            if ($exists instanceof User) {
                throw new HttpException(409, 'Email already taken');
            }
            $userManager->updateUser($user);
        }
        return array('form'=>$form->createView());
    }

}
