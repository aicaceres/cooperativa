<?php

namespace SG\AdminBundle\Form;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use SG\ConfigBundle\Form;

class SocioType extends AbstractType {

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('savenew', 'hidden', array('mapped' => false, 'required' => false))
                ->add('nombre', null, array('label' => 'Nombre:', 'required' => true))
                ->add('apellido', null, array('label' => 'Apellido:', 'required' => true))
                ->add('nroDocumento', null, array('label' => 'Nº Documento:', 'required' => false))
                ->add('cuit', null, array('label' => 'CUIT:', 'required' => false))
                ->add('fechaNacimiento', 'date', array('widget' => 'single_text', 'label' => 'Fecha Nacimiento:',
                    'format' => 'dd-MM-yyyy', 'required' => false))
                ->add('direccion', null, array('label' => 'Dirección:', 'required' => false))
                ->add('telefono', null, array('label' => 'Teléfono:', 'required' => false))
                ->add('contacto', null, array('label' => 'Contacto:', 'required' => false))
                ->add('localidad', 'entity', array('class' => 'ConfigBundle:Localidad'))
                ->add('celular', null, array('label' => 'Celular:', 'required' => false))
                ->add('email', null, array('label' => 'Email:', 'required' => false))
                ->add('activo', null, array('label' => 'Activo:', 'required' => false))
                //domicilios laborales
                ->add('empresas', 'entity', array(
                    'class' => 'ConfigBundle:Empresa',
                    'label' => 'Empresas:',
                    'multiple' => true,
                    'required' => false,
                ))
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'SG\AdminBundle\Entity\Socio'
        ));
    }

    /**
     * @return string
     */
    public function getName() {
        return 'sg_adminbundle_socio';
    }

}