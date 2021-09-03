<?php

namespace SG\AdminBundle\Form;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CajaMovimientoType extends AbstractType {

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('cajaApertura')
                ->add('tipo', 'hidden')
                ->add('descripcion', null, array('label' => 'Descripción general del movimiento:', 'required' => false))
                ->add('total', null, array('required' => false));
        if ($options['data']->getTipo() == 'E') {
            $builder->add('detalles', 'collection', array(
                'type' => new CajaEgresoDetalleType(),
                'by_reference' => false,
                'allow_delete' => true,
                'allow_add' => true,
                'prototype_name' => 'items',
                'attr' => array(
                    'class' => 'row item'
            )));
        }
        elseif ($options['data']->getTipo() == 'I') {
            $builder->add('detalles', 'collection', array(
                        'type' => new CajaIngresoDetalleType(),
                        'by_reference' => false,
                        'allow_delete' => true,
                        'allow_add' => true,
                        'prototype_name' => 'items',
                        'attr' => array(
                            'class' => 'row item'
                )))
                    ->add('socio', 'socio_selector', array('required' => false))
                    ->add('responsablePago', null, array('label' => 'Nombre y Apellido:', 'required' => false))
                    ->add('descripcionPago')
                    ->add('pago');
        }
        else {
            $builder->add('detalles', 'collection', array(
                        'type' => new CajaLiquidacionDetalleType(),
                        'by_reference' => false,
                        'allow_delete' => true,
                        'allow_add' => true,
                        'prototype_name' => 'items',
                        'attr' => array(
                            'class' => 'row item'
                )))
                    ->add('socio', 'socio_selector', array('required' => false))
                    ->add('responsablePago', null, array('label' => 'Nombre y Apellido:', 'required' => false))
                    ->add('descripcionPago')
                    ->add('pago');
        }
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'SG\AdminBundle\Entity\CajaMovimiento'
        ));
    }

    /**
     * @return string
     */
    public function getName() {
        return 'sg_adminbundle_cajamovimiento';
    }

}