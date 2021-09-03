<?php

namespace SG\AdminBundle\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * SG\AdminBundle\Entity\Auxiliar
 * @ORM\Table(name="auxiliar")
 * @ORM\Entity()
 */
class Auxiliar {
    /**
     * @var integer $id
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @ORM\Column(name="nombre", type="string", nullable=true)
     */
    protected $nombre;

    /**
     * @ORM\Column(name="apellido", type="string", nullable=true)
     */
    protected $apellido;

    /**
     * @ORM\Column(name="dni", type="string", nullable=true)
     */
    protected $dni;

    /**
     * @ORM\Column(name="cuit", type="string", nullable=true)
     */
    protected $cuit;

    /**
     * @ORM\Column(name="fechanac", type="string", nullable=true)
     */
    protected $fechanac;

    /**
     * @ORM\Column(name="direccion", type="string", nullable=true)
     */
    protected $direccion;

    /**
     * @ORM\Column(name="localidad", type="string", nullable=true)
     */
    protected $localidad;

    /**
     * @ORM\Column(name="telefono", type="string", nullable=true)
     */
    protected $telefono;

    /**
     * @ORM\Column(name="celular", type="string", nullable=true)
     */
    protected $celular;

    /**
     * @ORM\Column(name="email", type="string", nullable=true)
     */
    protected $email;

    /**
     * @ORM\Column(name="contacto", type="string", nullable=true)
     */
    protected $contacto;

    /**
     * @ORM\Column(name="empresas", type="string", nullable=true)
     */
    protected $empresas;


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
     * @return Auxiliar
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
     * Set apellido
     *
     * @param string $apellido
     * @return Auxiliar
     */
    public function setApellido($apellido)
    {
        $this->apellido = $apellido;
    
        return $this;
    }

    /**
     * Get apellido
     *
     * @return string 
     */
    public function getApellido()
    {
        return $this->apellido;
    }

    /**
     * Set dni
     *
     * @param string $dni
     * @return Auxiliar
     */
    public function setDni($dni)
    {
        $this->dni = $dni;
    
        return $this;
    }

    /**
     * Get dni
     *
     * @return string 
     */
    public function getDni()
    {
        return $this->dni;
    }

    /**
     * Set cuit
     *
     * @param string $cuit
     * @return Auxiliar
     */
    public function setCuit($cuit)
    {
        $this->cuit = $cuit;
    
        return $this;
    }

    /**
     * Get cuit
     *
     * @return string 
     */
    public function getCuit()
    {
        return $this->cuit;
    }

    /**
     * Set fechanac
     *
     * @param string $fechanac
     * @return Auxiliar
     */
    public function setFechanac($fechanac)
    {
        $this->fechanac = $fechanac;
    
        return $this;
    }

    /**
     * Get fechanac
     *
     * @return string 
     */
    public function getFechanac()
    {
        return $this->fechanac;
    }

    /**
     * Set direccion
     *
     * @param string $direccion
     * @return Auxiliar
     */
    public function setDireccion($direccion)
    {
        $this->direccion = $direccion;
    
        return $this;
    }

    /**
     * Get direccion
     *
     * @return string 
     */
    public function getDireccion()
    {
        return $this->direccion;
    }

    /**
     * Set localidad
     *
     * @param string $localidad
     * @return Auxiliar
     */
    public function setLocalidad($localidad)
    {
        $this->localidad = $localidad;
    
        return $this;
    }

    /**
     * Get localidad
     *
     * @return string 
     */
    public function getLocalidad()
    {
        return $this->localidad;
    }

    /**
     * Set telefono
     *
     * @param string $telefono
     * @return Auxiliar
     */
    public function setTelefono($telefono)
    {
        $this->telefono = $telefono;
    
        return $this;
    }

    /**
     * Get telefono
     *
     * @return string 
     */
    public function getTelefono()
    {
        return $this->telefono;
    }

    /**
     * Set celular
     *
     * @param string $celular
     * @return Auxiliar
     */
    public function setCelular($celular)
    {
        $this->celular = $celular;
    
        return $this;
    }

    /**
     * Get celular
     *
     * @return string 
     */
    public function getCelular()
    {
        return $this->celular;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return Auxiliar
     */
    public function setEmail($email)
    {
        $this->email = $email;
    
        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set contacto
     *
     * @param string $contacto
     * @return Auxiliar
     */
    public function setContacto($contacto)
    {
        $this->contacto = $contacto;
    
        return $this;
    }

    /**
     * Get contacto
     *
     * @return string 
     */
    public function getContacto()
    {
        return $this->contacto;
    }

    /**
     * Set empresas
     *
     * @param string $empresas
     * @return Auxiliar
     */
    public function setEmpresas($empresas)
    {
        $this->empresas = $empresas;
    
        return $this;
    }

    /**
     * Get empresas
     *
     * @return string 
     */
    public function getEmpresas()
    {
        return $this->empresas;
    }
}
