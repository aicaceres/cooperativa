<?php

namespace SG\AdminBundle\Form;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class VehiculoType extends AbstractType {

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('dominio', null, array('label' => 'Dominio:', 'required' => true,
                    'attr' => array('style' => 'text-transform:uppercase')))
                ->add('marca', null, array('label' => 'Marca:', 'required' => false))
                ->add('modelo', null, array('label' => 'Modelo:', 'required' => false))
                //->add('kilometros', null, array('label' => 'Km:', 'required' => false))
                ->add('carga', null, array('label' => 'Carga:', 'required' => false))
                ->add('anio', null, array('label' => 'Año:', 'required' => false,
                    'attr' => array('min' => '1900', 'max' => '2030')))
                ->add('asignadoAlSocio', null, array('label' => 'Asignado al socio: ', 'required' => false))
                ->add('lineas', 'collection', array(
                    'type' => new LineaType(),
                    'by_reference' => false,
                    'allow_delete' => true,
                    'allow_add' => true,
                    'prototype_name' => 'items',
                    'attr' => array('class' => 'row item')
                        )
                )
                ->add('empleado', 'entity', array(
                    'class' => 'AdminBundle:Empleado',
                    'label' => 'Empleado a cargo del vehículo:',
                    'required' => false,
                    'attr' => array('class' => 'chosen')
                ))
                ->add('socio')
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'SG\AdminBundle\Entity\Vehiculo'
        ));
    }

    /**
     * @return string
     */
    public function getName() {
        return 'sg_adminbundle_vehiculo';
    }

}