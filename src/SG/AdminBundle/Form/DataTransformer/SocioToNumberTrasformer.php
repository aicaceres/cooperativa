<?php
namespace SG\AdminBundle\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;
use Doctrine\Common\Persistence\ObjectManager;
use SG\AdminBundle\Entity\Socio;

class SocioToNumberTrasformer implements DataTransformerInterface
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

    /**
     * Transforms an object (socio) to a string (number).
     *
     * @param  Socio|null $socio
     * @return string
     */
    public function transform($socio)
    {
        if (null === $socio) {
            return "";
        }

        return $socio->getId();
    }

    /**
     * Transforms a string (number) to an object (socio).
     *
     * @param  string $number
     * @return $socio|null
     * @throws TransformationFailedException if object (socio) is not found.
     */
    public function reverseTransform($number)
    {
        if (!$number) {
            return null;
        }

        $socio = $this->om
            ->getRepository('AdminBundle:Socio')
            ->findOneBy(array('id' => $number))
        ;

        if (null === $socio) {
            throw new TransformationFailedException(sprintf(
                'An issue with number "%s" does not exist!',
                $number
            ));
        }

        return $socio;
    }
}