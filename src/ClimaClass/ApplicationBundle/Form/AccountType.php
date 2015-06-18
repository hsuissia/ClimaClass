<?php

namespace ClimaClass\ApplicationBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Security\Core\Validator\Constraints\UserPassword;

class AccountType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        // add your custom field
        $builder
                ->remove('current_password')
                ->add('current_password', 'password', array(
                    'label' => 'password',
                    'translation_domain' => 'FOSUserBundle',
                    'mapped' => false,
                    'constraints' => new UserPassword(),
                ))
                ->add('establishment')
                ->add('class')
                ->add('lastname')
                ->add('firstname')
                ->add('description')
                ->add('file', 'file', array('required' => false))
                ->add('main_language', 'entity', array('property' => 'language', "class" => 'ClimaClass\ApplicationBundle\Entity\Language'))
                ->add('languages', 'entity', array('property' => 'language', "class" => 'ClimaClass\ApplicationBundle\Entity\Language', 'multiple' => true))
        ;
    }

    public function getParent() {
        return 'fos_user_profile';
    }

    public function getName() {
        return 'climaclass_user_profile';
    }

}
