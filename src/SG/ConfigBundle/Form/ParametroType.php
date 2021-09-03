<?php

namespace SG\ConfigBundle\Form;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class ParametroType extends AbstractType {

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $data = $options['data'];
        if (property_exists($data, 'diaVtoCuota')) {
            $builder->add('diaVtoCuota', null, array('label' => 'Día de vencimiento de cuotas:', 'required' => false))
                    ->add('tipoRecargoCuota', 'choice', array('label' => 'Tipo de recargo fijo para cuotas vencidas:',
                        'choices' => array('P' => 'Porcentaje', 'M' => 'Monto fijo'), 'required' => true))
                    ->add('montoRecargoCuota', null, array('label' => 'Monto diario de recargo para cuotas vencidas:', 'required' => false))
                    ->add('textoMailMorosos', null, array('label' => 'Texto en email para morosos:', 'required' => false));
        }
        else {
            $builder->add('nombre', null, array('label' => 'Descripción:'));
        }
        if (property_exists($data, 'requiereSocio')) {
            $builder->add('tipo', 'choice', array('label' => 'Tipo de Concepto:',
                        'choices' => array('I' => 'Ingreso', 'E' => 'Egreso'),
                        'expanded' => true, 'required' => true))
                    ->add('monto', null, array('label' => 'Monto:'))
                    ->add('requiereSocio', null,
                            array('label' => 'Requiere indicar Socio:', 'required' => false));
        }
    }

    /**
     * @return string
     */
    public function getName() {
        return 'sg_configbundle_parametro';
    }

}