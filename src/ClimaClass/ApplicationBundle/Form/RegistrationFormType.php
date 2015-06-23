<?php

namespace ClimaClass\ApplicationBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class RegistrationFormType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        // add your custom field
        $builder
                ->add('lastname')
                ->add('firstname')
                ->add('establishment')
                ->add('class')
                ->add('address', 'text', array("read_only" => true))
                ->add('latitude','hidden')
                ->add('longitude','hidden')
                ->add('main_language', 'entity', array('property' => 'language', "class" => 'ClimaClass\ApplicationBundle\Entity\Language'))
                ->add('languages', 'entity', array('property' => 'language', "class" => 'ClimaClass\ApplicationBundle\Entity\Language', 'multiple' => true))
                ->add('roles', 'collection', array(
                    'type' => 'choice',
                    'empty_data' => 'Choose a role',
                    'options' => array(
                        'label' => false, /* Ajoutez cette ligne */
                        'choices' => array(
                            'ROLE_TEACHER' => 'Teacher',
                            'ROLE_ADMIN' => 'Admin'
                            
                        )
                    )
                        )
                )
        ;
    }

    public function getParent() {
        return 'fos_user_registration';
    }

    public function getName() {
        return 'climaclass_user_registration';
    }

}
