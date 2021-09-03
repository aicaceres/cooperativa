<?php
namespace SG\AdminBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use SG\AdminBundle\Form\DataTransformer\SocioToNumberTrasformer;
use Doctrine\Common\Persistence\ObjectManager;

class SocioSelectorType extends AbstractType
{
    /**
     * @var ObjectManager
     */
    private $om;

    /**
     * @param ObjectManager $om
     */
    public function __construct(ObjectManager $om)
    {
        $this->om = $om;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $transformer = new SocioToNumberTrasformer($this->om);
        $builder->addViewTransformer($transformer);
    }

    public function getDefaultOptions(array $options)
    {
        return array(
            'invalid_message' => 'The selected issue does not exist',
        );
    }

    public function getParent()
    {
        return 'hidden';
    }

    public function getName()
    {
        return 'socio_selector';
    }
}