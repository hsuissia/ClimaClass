<?php

namespace ClimaClass\ApplicationBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ReportType extends AbstractType {

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('title')
                ->add('content')
                ->add('measures', 'collection', array(
                    'type' => new MeasureType(),
                    'allow_add' => true,
                    'allow_delete' => true
                ))
                ->add('videos', 'collection', array(
                    'type' => new VideoType(),
                    'allow_add' => true,
                    'allow_delete' => true
                ))
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'ClimaClass\ApplicationBundle\Entity\Report'
        ));
    }

    /**
     * @return string
     */
    public function getName() {
        return 'climaclass_applicationbundle_report';
    }

}
