<?php
namespace SG\ConfigBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * SG\ConfigBundle\Entity\TipoOperacion
 * @ORM\Table(name="tipo_operacion")
 * @ORM\Entity()
 */
class TipoOperacion
{
    /**
     * @var integer $id
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;
    /**
     * @var string $nombre
     * @ORM\Column(name="nombre", type="string", nullable=false)
     * @Assert\NotBlank()
     */
    protected $nombre;
    /**
     * @var string $monto
     * @ORM\Column(name="monto", type="decimal", scale=2, nullable=true)
     */
    protected $monto;

    /**
     * Get id
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set nombre
     * @param string $nombre
     * @return TipoOperacion
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre
     *
     * @return string 
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set monto
     *
     * @param string $monto
     * @return TipoOperacion
     */
    public function setMonto($monto)
    {
        $this->monto = $monto;

        return $this;
    }

    /**
     * Get monto
     *
     * @return string 
     */
    public function getMonto()
    {
        return $this->monto;
    }
}
