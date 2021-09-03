<?php
namespace SG\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class DomicilioType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('direccion', null, array('label' => 'Dirección:', 'required' => true))
            ->add('telefono', null, array('label' => 'Teléfono:', 'required' => false))
            ->add('localidad', 'entity', array('class' => 'ConfigBundle:Localidad'))

        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'SG\AdminBundle\Entity\Domicilio'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'sg_adminbundle_domicilio';
    }
}
