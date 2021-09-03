<?php

namespace SG\AdminBundle\Form;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;

class CajaEgresoDetalleType extends AbstractType {

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('concepto', 'entity', array('class' => 'ConfigBundle:ConceptoCaja',
                    'property' => 'nombre', 'required' => true,
                    'query_builder' => function (EntityRepository $repository) {
                        return $qb = $repository->createQueryBuilder('c')
                                ->add('where', "c.tipo='E'")
                                ->add('orderBy', 'c.nombre ASC');
                    }
                ))
                ->add('orden', 'hidden')
                ->add('descripcion')
                ->add('importe')
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'SG\AdminBundle\Entity\CajaMovimientoDetalle'
        ));
    }

    /**
     * @return string
     */
    public function getName() {
        return 'sg_adminbundle_cajamovimientodetalle';
    }

}