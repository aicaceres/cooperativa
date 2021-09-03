<?php
namespace SG\ConfigBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
/**
 * SG\ConfigBundle\Entity\Pais
 * @ORM\Table(name="pais")
 * @ORM\Entity()
 */
class Pais
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
     * @ORM\Column(name="by_default", type="boolean", nullable=true)
     */
    protected $byDefault = false;

    /**
     * @ORM\OneToMany(targetEntity="SG\ConfigBundle\Entity\Provincia", mappedBy="pais")
     */
    protected $provincias;
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->provincias = new \Doctrine\Common\Collections\ArrayCollection();
    }
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
     * @return Pais
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
     * Add provincias
     *
     * @param \SG\ConfigBundle\Entity\Provincia $provincias
     * @return Pais
     */
    public function addProvincia(\SG\ConfigBundle\Entity\Provincia $provincias)
    {
        $this->provincias[] = $provincias;
    
        return $this;
    }

    /**
     * Remove provincias
     *
     * @param \SG\ConfigBundle\Entity\Provincia $provincias
     */
    public function removeProvincia(\SG\ConfigBundle\Entity\Provincia $provincias)
    {
        $this->provincias->removeElement($provincias);
    }

    /**
     * Get provincias
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getProvincias()
    {
        return $this->provincias;
    }

    /**
     * Set byDefault
     *
     * @param boolean $byDefault
     * @return Pais
     */
    public function setByDefault($byDefault)
    {
        $this->byDefault = $byDefault;

        return $this;
    }

    /**
     * Get byDefault
     *
     * @return boolean 
     */
    public function getByDefault()
    {
        return $this->byDefault;
    }
}
