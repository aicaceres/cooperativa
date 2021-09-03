<?php

namespace SG\AdminBundle\Form;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;

class EmpleadoType extends AbstractType {

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('nombre', null, array('label' => 'Nombre:', 'required' => true))
                ->add('apellido', null, array('label' => 'Apellido:', 'required' => true))
                ->add('nroDocumento', null, array('label' => 'Nº Documento:', 'required' => false))
                ->add('cuit', null, array('label' => 'CUIT:', 'required' => false))
                ->add('fechaNacimiento', 'date', array('widget' => 'single_text', 'label' => 'Fecha Nacimiento:',
                    'format' => 'dd-MM-yyyy', 'required' => false))
                ->add('direccion', null, array('label' => 'Dirección:', 'required' => false))
                ->add('telefono', null, array('label' => 'Teléfono:', 'required' => false))
                ->add('localidad', 'entity', array('class' => 'ConfigBundle:Localidad'))
                ->add('celular', null, array('label' => 'Celular:', 'required' => false))
                ->add('email', null, array('label' => 'Email:', 'required' => false))
                ->add('socio');
        /*
          $emp = 0;
          if ($options['data']->getId()) {
          $emp = $options['data']->getId();
          $builder->add('vehiculos', 'entity', array(
          'multiple' => true,
          'required' => false, 'label' => 'Vehículos:',
          'property' => 'marcaModeloDominio',
          'class' => 'AdminBundle:Vehiculo',
          'query_builder' => function(EntityRepository $repository) use ($emp) {
          $qb = $repository->createQueryBuilder('v')
          ->select('v')
          ->leftJoin('v.empleado', 'e')
          ->where('e.id = :emp')
          ->orWhere('e is null')
          ->setParameter('emp', $emp);
          return $qb;
          },));
          }
          else {
          $builder->add('vehiculos', 'entity', array(
          'multiple' => true,
          'required' => false, 'label' => 'Vehículos:',
          'property' => 'marcaModeloDominio',
          'class' => 'AdminBundle:Vehiculo',
          'query_builder' => function(EntityRepository $repository) {
          $qb = $repository->createQueryBuilder('v')
          ->leftJoin('v.empleado', 'e')
          ->where('e is null');
          return $qb;
          },));
          } */
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'SG\AdminBundle\Entity\Empleado'
        ));
    }

    /**
     * @return string
     */
    public function getName() {
        return 'sg_adminbundle_empleado';
    }

}