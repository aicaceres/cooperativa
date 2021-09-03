<?php
namespace SG\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CajaCierreType extends AbstractType
{
     /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
     public function buildForm(FormBuilderInterface $builder, array $options) {
         $builder->add('caja')
                 ->add('fechaCierre','date',array('widget' => 'single_text','label' => 'Fecha y Hora de Cierre:',
                  'format' => 'dd-MM-yyyy hh:mm', 'required' => true))
                 ->add('montoCierre',null,array('label' => 'Dinero en caja:', 'required' => true));
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'SG\AdminBundle\Entity\CajaApertura'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    { 
        return 'sg_adminbundle_cajacierre';
    }

}
