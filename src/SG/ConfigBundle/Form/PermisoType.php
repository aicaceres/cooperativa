<?php
namespace SG\ConfigBundle\Form;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class PermisoType extends AbstractType
{
     /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('modulo');
        $builder->add('item', null, array('label' => 'Item Menú:', 'required' => false));                
        $builder->add('tag');                
        $builder->add('texto');                
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'sg_configbundle_permiso';
    }
}