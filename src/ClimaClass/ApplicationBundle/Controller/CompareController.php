<?php

namespace ClimaClass\ApplicationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CompareController extends Controller {

    /**
     * @Route("/compare", name="compare")
     * @Template()
     */
    public function compareAction(Request $request) {
        $class1 = "";
        $class2 = "";

        $tabtempclass1 = array();
        $tabrainlevelclass1 = array();
        $tabwindspeedclass1 = array();

        $tabtempclass2 = array();
        $tabrainlevelclass2 = array();
        $tabwindspeedclass2 = array();

        array();
        $repo = $this->getDoctrine()->getRepository("ClimaClassApplicationBundle:User");
        $form = $this->createFormBuilder()
                ->add('class1', 'entity', array('required' => true, "class" => 'ClimaClass\ApplicationBundle\Entity\User', 'property' => 'class'))
                ->add('class2', 'entity', array('required' => true, "class" => 'ClimaClass\ApplicationBundle\Entity\User', 'property' => 'class'))
                ->add('Compare', 'submit');
        $form = $form->getForm();

        $form->handleRequest($request);
        if ($form->isValid()) {
            $data = $form->getData();
            $class1 = $repo->find($data['class1']->getId());
            $class2 = $repo->find($data['class2']->getId());
            foreach ($class1->getReports() as $reports) {
                foreach ($reports->getMeasures() as $measures) {
                    $tabtempclass1[] = $measures->getTemperature();
                    $tabrainlevelclass1[] = $measures->getRainLevel();
                    $tabwindspeedclass1[] = $measures->getWindSpeed();
                }
            }
            foreach ($class2->getReports() as $reports) {
                foreach ($reports->getMeasures() as $measures) {
                    $tabtempclass2[] = $measures->getTemperature();
                    $tabrainlevelclass2[] = $measures->getRainLevel();
                    $tabwindspeedclass2[] = $measures->getWindSpeed();
                }
            }
        }

        return array('form' => $form->createView(),
            'tabtempclass1' => $tabtempclass1,
            'tabrainlevelclass1' => $tabrainlevelclass1,
            'tabwindspeedclass1' => $tabwindspeedclass1,
            'tabtempclass2' => $tabtempclass2,
            'tabrainlevelclass2' => $tabrainlevelclass2,
            'tabwindspeedclass2' => $tabwindspeedclass2);
    }

}
