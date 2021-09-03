<?php

namespace SG\AdminBundle\Form;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;

class CuotaType extends AbstractType {

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('socio')
                ->add('concepto', 'entity', array(
                    'class' => 'ConfigBundle:ConceptoCaja',
                    'label' => 'Concepto:',
                    'property' => 'nombre',
                    'empty_value' => 'Seleccionar',
                    'required' => true,
                    'query_builder' => function (EntityRepository $repository) {
                        return $qb = $repository->createQueryBuilder('c')
                                ->where("c.tipo='I'");
                    }
                ))
                ->add('descripcion', null, array('label' => 'Detalle:'))
                ->add('fechaVto', 'date', array('widget' => 'single_text', 'label' => 'Fecha Vencimiento:',
                    'format' => 'dd-MM-yyyy', 'required' => true))
                ->add('monto', null, array('label' => 'Monto:', 'required' => true))
                ->add('cantidadCuotas', 'integer',
                        array('label' => 'Cantidad Cuotas:',
                            'attr' => array('min' => '1'),
                            'required' => false, 'mapped' => false))
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'SG\AdminBundle\Entity\Deuda'
        ));
    }

    /**
     * @return string
     */
    public function getName() {
        return 'sg_adminbundle_deuda';
    }

}