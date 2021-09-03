<?php
namespace SG\ConfigBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * SG\ConfigBundle\Entity\Localidad
 * @ORM\Table(name="localidad")
 * @ORM\Entity(repositoryClass="SG\ConfigBundle\Entity\LocalidadRepository")
 */
class Localidad
{
    /**
     * @var integer $id
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string $name
     * @ORM\Column(name="name", type="string", length=255)
     */
    protected $name;

    /**
     * @var string $codpostal
     * @ORM\Column(name="codpostal", type="string", nullable=true)
     */
    protected $codpostal;
    
    /**
     * @ORM\Column(name="by_default", type="boolean", nullable=true)
     */
    protected $pordefecto = false;

    /**
     * @ORM\ManyToOne(targetEntity="SG\ConfigBundle\Entity\Provincia", inversedBy="localidades")
     * @ORM\JoinColumn(name="provincia_id", referencedColumnName="id")
     */
    protected $provincia;

    public function __toString() {
        return $this->name;
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
     * Set name
     *
     * @param string $name
     * @return Localidad
     */
    public function setName($name)
    {
        $this->name = $name;
    
        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set provincia
     *
     * @param \SG\ConfigBundle\Entity\Provincia $provincia
     * @return Localidad
     */
    public function setProvincia(\SG\ConfigBundle\Entity\Provincia $provincia = null)
    {
        $this->provincia = $provincia;
    
        return $this;
    }

    /**
     * Get provincia
     *
     * @return \SG\ConfigBundle\Entity\Provincia 
     */
    public function getProvincia()
    {
        return $this->provincia;
    }

    /**
     * Set codpostal
     *
     * @param string $codpostal
     * @return Localidad
     */
    public function setCodpostal($codpostal)
    {
        $this->codpostal = $codpostal;
    
        return $this;
    }

    /**
     * Get codpostal
     *
     * @return string 
     */
    public function getCodpostal()
    {
        return $this->codpostal;
    }

    /**
     * Set pordefecto
     *
     * @param boolean $pordefecto
     * @return Localidad
     */
    public function setPordefecto($pordefecto)
    {
        $this->pordefecto = $pordefecto;

        return $this;
    }

    /**
     * Get pordefecto
     *
     * @return boolean 
     */
    public function getPordefecto()
    {
        return $this->pordefecto;
    }


}
