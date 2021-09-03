<?php

namespace SG\ConfigBundle\Form;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;

class PerfilType extends AbstractType {

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('nombre', null, array('label' => 'Nombre:', 'required' => true))
                ->add('admin', null, array('label' => 'Vista de Administrador:', 'required' => false))
                ->add('socio', null, array('label' => 'Socios:', 'required' => false))
                ->add('caja', null, array('label' => 'Caja:', 'required' => false))
                ->add('parametro', null, array('label' => 'Parámetros:', 'required' => false))
                ->add('seguridad', null, array('label' => 'Seguridad:', 'required' => false))
                ->add('socioAbm', 'entity', array(
                    'class' => 'ConfigBundle:Permiso',
                    'label' => 'Permisos:',
                    'property' => 'texto',
                    'multiple' => true,
                    'required' => false,
                    'mapped' => false,
                    'query_builder' => function (EntityRepository $repository) {
                        return $qb = $repository->createQueryBuilder('p')
                                ->where('p.modulo = :mod and p.item = :itm ')
                                ->setParameter('mod', 'socio')
                                ->setParameter('itm', 'abm');
                    }
                ))
                ->add('empleadoAbm', 'entity', array(
                    'class' => 'ConfigBundle:Permiso',
                    'label' => 'Permisos:',
                    'property' => 'texto',
                    'multiple' => true,
                    'required' => false,
                    'mapped' => false,
                    'query_builder' => function (EntityRepository $repository) {
                        return $qb = $repository->createQueryBuilder('p')
                                ->where('p.modulo = :mod and p.item = :itm ')
                                ->setParameter('mod', 'empleado')
                                ->setParameter('itm', 'abm');
                    }
                ))
                ->add('vehiculoAbm', 'entity', array(
                    'class' => 'ConfigBundle:Permiso',
                    'label' => 'Permisos:',
                    'property' => 'texto',
                    'multiple' => true,
                    'required' => false,
                    'mapped' => false,
                    'query_builder' => function (EntityRepository $repository) {
                        return $qb = $repository->createQueryBuilder('p')
                                ->where('p.modulo = :mod and p.item = :itm ')
                                ->setParameter('mod', 'vehiculo')
                                ->setParameter('itm', 'abm');
                    }
                ))
                ->add('socioCtaCte', 'entity', array(
                    'class' => 'ConfigBundle:Permiso',
                    'label' => 'Permisos:',
                    'property' => 'texto',
                    'multiple' => true,
                    'required' => false,
                    'mapped' => false,
                    'query_builder' => function (EntityRepository $repository) {
                        return $qb = $repository->createQueryBuilder('p')
                                ->where('p.modulo = :mod and p.item = :itm ')
                                ->setParameter('mod', 'socio')
                                ->setParameter('itm', 'ctacte');
                    }
                ))
                ->add('cajaAdm', 'entity', array(
                    'class' => 'ConfigBundle:Permiso',
                    'label' => 'Permisos:',
                    'property' => 'texto',
                    'multiple' => true,
                    'required' => false,
                    'mapped' => false,
                    'query_builder' => function (EntityRepository $repository) {
                        return $qb = $repository->createQueryBuilder('p')
                                ->where('p.modulo = :mod and p.item = :itm ')
                                ->setParameter('mod', 'caja')
                                ->setParameter('itm', 'adm');
                    }
                ))
                ->add('usuarioAbm', 'entity', array(
                    'class' => 'ConfigBundle:Permiso',
                    'label' => 'Permisos:',
                    'property' => 'texto',
                    'multiple' => true,
                    'required' => false,
                    'mapped' => false,
                    'query_builder' => function (EntityRepository $repository) {
                        return $qb = $repository->createQueryBuilder('p')
                                ->where('p.modulo = :mod and p.item = :itm ')
                                ->setParameter('mod', 'seguridad')
                                ->setParameter('itm', 'usuario');
                    }
                ))
                ->add('perfilAbm', 'entity', array(
                    'class' => 'ConfigBundle:Permiso',
                    'label' => 'Permisos:',
                    'property' => 'texto',
                    'multiple' => true,
                    'required' => false,
                    'mapped' => false,
                    'query_builder' => function (EntityRepository $repository) {
                        return $qb = $repository->createQueryBuilder('p')
                                ->where('p.modulo = :mod and p.item = :itm ')
                                ->setParameter('mod', 'seguridad')
                                ->setParameter('itm', 'perfil');
                    }
                ))
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'SG\ConfigBundle\Entity\Perfil'
        ));
    }

    /**
     * @return string
     */
    public function getName() {
        return 'sg_configbundle_perfil';
    }

}