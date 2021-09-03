<?php
namespace SG\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface; 

class CajaIngresoType extends AbstractType
{
     /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
     public function buildForm(FormBuilderInterface $builder, array $options) {
         $builder->add('responsablePago',null,array('label' => 'Nombre y Apellido:')) 
                 ->add('cajaApertura')
                 ->add('socio','socio_selector',array('required'=>false))
                 ->add('detalles', 'collection', array(
                        'type'           => new CajaMovimientoDetalleType(), 
                        'by_reference'   => false,
                        'allow_delete'   => true,
                        'allow_add'      => true,
                        'prototype_name' => 'items',
                        'attr'           => array(
                            'class' => 'row item'
                        )))
                 ->add('descripcionPago') 
                 ->add('pago') 
                 ->add('total');
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'SG\AdminBundle\Entity\CajaMovimiento'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'sg_adminbundle_cajamovimiento';
    }

}
