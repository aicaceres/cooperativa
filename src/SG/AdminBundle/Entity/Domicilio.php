<?php
namespace SG\AdminBundle\Entity;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * SG\AdminBundle\Entity\Domicilio
 * @ORM\Table(name="domicilio")
 * @ORM\Entity()
 */
class Domicilio
{
    /**
     * @var integer $id
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;
    
    /**
     * @var string $direccion
     * @ORM\Column(name="direccion", type="string", nullable=false)
     * @Assert\NotBlank()
     */
    protected $direccion;
     
    /**
     * @var string $telefono
     * @ORM\Column(name="telefono", type="string", nullable=true)
     */
    protected $telefono;
   
    /**
    * @ORM\ManyToOne(targetEntity="SG\ConfigBundle\Entity\Localidad")
    * @ORM\JoinColumn(name="localidad_id", referencedColumnName="id")
    */
    protected $localidad;
    
    /**
    * @ORM\ManyToOne(targetEntity="SG\AdminBundle\Entity\Socio", inversedBy="domicilios")
    * @ORM\JoinColumn(name="socio_id", referencedColumnName="id")
    */
    protected $socio;    

    /**
     * @var datetime $created
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     */
    private $created;
    /**
     * @var User $createdBy
     * @Gedmo\Blameable(on="create")
     * @ORM\ManyToOne(targetEntity="SG\ConfigBundle\Entity\Usuario")
     * @ORM\JoinColumn(name="created_by", referencedColumnName="id")
     */
    private $createdBy;

    
    public function getDireccionTxt(){
        return $this->direccion.' - '.$this->localidad;
    }

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
     * Set direccion
     *
     * @param string $direccion
     * @return Domicilio
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
     * Set telefono
     *
     * @param string $telefono
     * @return Domicilio
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
     * Set created
     *
     * @param \DateTime $created
     * @return Domicilio
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime 
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set localidad
     *
     * @param \SG\ConfigBundle\Entity\Localidad $localidad
     * @return Domicilio
     */
    public function setLocalidad(\SG\ConfigBundle\Entity\Localidad $localidad = null)
    {
        $this->localidad = $localidad;

        return $this;
    }

    /**
     * Get localidad
     *
     * @return \SG\ConfigBundle\Entity\Localidad 
     */
    public function getLocalidad()
    {
        return $this->localidad;
    }

    /**
     * Set socio
     *
     * @param \SG\AdminBundle\Entity\Socio $socio
     * @return Domicilio
     */
    public function setSocio(\SG\AdminBundle\Entity\Socio $socio = null)
    {
        $this->socio = $socio;

        return $this;
    }

    /**
     * Get socio
     *
     * @return \SG\AdminBundle\Entity\Socio 
     */
    public function getSocio()
    {
        return $this->socio;
    }

    /**
     * Set createdBy
     *
     * @param \SG\ConfigBundle\Entity\Usuario $createdBy
     * @return Domicilio
     */
    public function setCreatedBy(\SG\ConfigBundle\Entity\Usuario $createdBy = null)
    {
        $this->createdBy = $createdBy;

        return $this;
    }

    /**
     * Get createdBy
     *
     * @return \SG\ConfigBundle\Entity\Usuario 
     */
    public function getCreatedBy()
    {
        return $this->createdBy;
    }
}
