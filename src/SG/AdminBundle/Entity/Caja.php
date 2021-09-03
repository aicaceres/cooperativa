<?php
namespace SG\AdminBundle\Entity;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * SG\AdminBundle\Entity\Caja
 * @ORM\Table(name="caja")
 * @ORM\Entity(repositoryClass="SG\AdminBundle\Entity\CajaRepository")
 */
class Caja
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
     */
    protected $nombre;

    /**
     * @ORM\Column(name="abierta", type="boolean")
     */
    protected $abierta = false;
    
    /**
     * @ORM\OneToMany(targetEntity="SG\AdminBundle\Entity\CajaApertura", mappedBy="caja",cascade={"remove"})
     */
    protected $aperturas;

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

public function __toString(){
    return $this->getNombre();
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
     * Set nombre
     *
     * @param string $nombre
     * @return Caja
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
     * Set created
     *
     * @param \DateTime $created
     * @return Caja
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
     * Set createdBy
     *
     * @param \SG\ConfigBundle\Entity\Usuario $createdBy
     * @return Caja
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

    /**
     * Set abierta
     *
     * @param boolean $abierta
     * @return Caja
     */
    public function setAbierta($abierta)
    {
        $this->abierta = $abierta;

        return $this;
    }

    /**
     * Get abierta
     *
     * @return boolean 
     */
    public function getAbierta()
    {
        return $this->abierta;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->aperturas = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add aperturas
     *
     * @param \SG\AdminBundle\Entity\CajaApertura $aperturas
     * @return Caja
     */
    public function addApertura(\SG\AdminBundle\Entity\CajaApertura $aperturas)
    {
        $this->aperturas[] = $aperturas;
        return $this;
    }

    /**
     * Remove aperturas
     *
     * @param \SG\AdminBundle\Entity\CajaApertura $aperturas
     */
    public function removeApertura(\SG\AdminBundle\Entity\CajaApertura $aperturas)
    {
        $this->aperturas->removeElement($aperturas);
    }

    /**
     * Get aperturas
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getAperturas()
    {
        return $this->aperturas;
    }
}
