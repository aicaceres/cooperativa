<?php

namespace SG\AdminBundle\Entity;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * SG\AdminBundle\Entity\Linea
 * @ORM\Table(name="linea")
 * @ORM\Entity()
 */
class Linea {
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
     */
    protected $nombre;

    /**
     * @var string $kilometros
     * @ORM\Column(name="kilometros", type="string",nullable=true)
     */
    protected $kilometros;

    /**
     * @ORM\ManyToOne(targetEntity="SG\AdminBundle\Entity\Vehiculo", inversedBy="lineas")
     * @ORM\JoinColumn(name="vehiculo_id", referencedColumnName="id")
     */
    protected $vehiculo;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     * @return Linea
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
     * Set kilometros
     *
     * @param string $kilometros
     * @return Linea
     */
    public function setKilometros($kilometros)
    {
        $this->kilometros = $kilometros;
    
        return $this;
    }

    /**
     * Get kilometros
     *
     * @return string 
     */
    public function getKilometros()
    {
        return $this->kilometros;
    }

    /**
     * Set vehiculo
     *
     * @param \SG\AdminBundle\Entity\Vehiculo $vehiculo
     * @return Linea
     */
    public function setVehiculo(\SG\AdminBundle\Entity\Vehiculo $vehiculo = null)
    {
        $this->vehiculo = $vehiculo;
    
        return $this;
    }

    /**
     * Get vehiculo
     *
     * @return \SG\AdminBundle\Entity\Vehiculo 
     */
    public function getVehiculo()
    {
        return $this->vehiculo;
    }
}
