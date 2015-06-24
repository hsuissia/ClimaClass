<?php

namespace ClimaClass\ApplicationBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class MeasureType extends AbstractType {

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('temperature', 'text', array('attr' => array('class' => 'form-control')))
                ->add('windSpeed', 'text', array('attr' => array('class' => 'form-control')))
                ->add('windDirection', 'text', array('attr' => array('class' => 'form-control')))
                ->add('rainLevel', 'text', array('attr' => array('class' => 'form-control')))
                ->add('rainMeasureDuration', 'text', array('attr' => array('class' => 'form-control')))
                ->add('measurementDate', 'date', array('widget' => 'single_text', 'input' => 'datetime', 'format' => 'y-MM-dd','attr'=>array('class'=>'form-control datepicker')))
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'ClimaClass\ApplicationBundle\Entity\Measure'
        ));
    }

    /**
     * @return string
     */
    public function getName() {
        return 'climaclass_applicationbundle_measure';
    }

}
