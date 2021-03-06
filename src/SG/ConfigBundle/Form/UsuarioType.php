<?php
namespace SG\ConfigBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UsuarioType extends AbstractType
{
     /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
     public function buildForm(FormBuilderInterface $builder, array $options) {
         $builder->add('nombre', 'text', array('label' => 'Nombre:','required'=>true))
                 ->add('dni', 'text', array('label' => 'DNI:','required'=>false))
                 ->add('email', 'email', array('label' => 'Email:','required'=>true))
                 ->add('activo',null,array('label' => 'Activo: ','required'=>false))
                 ->add('perfil','entity',array('label'=>'Perfil de Usuario:',
                        'class' => 'ConfigBundle:Perfil', 'required' =>true,
                        'empty_value'   => 'Seleccione Perfil'));
        if ($options['data']->getId() == 0) {
            $builder->add('username', 'text', array('label' => 'Usuario:','required'=>true))
                    ->add('password', 'repeated', array('type' => 'password','required' => true,
                    'invalid_message' => 'Las dos contraseñas deben coincidir'));
        } else {
            $builder->add('username', 'text', array('label' => 'Usuario:','read_only'=>true)) 
                    ->add('password', 'repeated', array('required' => false,
                        'invalid_message' => 'Las dos contraseñas deben coincidir',
                        'type' => 'password'));
        }
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'SG\ConfigBundle\Entity\Usuario'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'sg_configbundle_usuario';
    }
}