<?php
namespace SG\ConfigBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * SG\ConfigBundle\Entity\Provincia
 * @ORM\Table(name="provincia")
 * @ORM\Entity(repositoryClass="SG\ConfigBundle\Entity\ProvinciaRepository")
 */
class Provincia
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
     * @ORM\ManyToOne(targetEntity="SG\ConfigBundle\Entity\Pais", inversedBy="provincias")
     * @ORM\JoinColumn(name="pais_id", referencedColumnName="id")
     */
    protected $pais;

    /**
     * @ORM\OneToMany(targetEntity="SG\ConfigBundle\Entity\Localidad", mappedBy="provincia")
     */
    protected $localidades;
    
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->localidades = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Provincia
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
     * Set pais
     *
     * @param \SG\ConfigBundle\Entity\Pais $pais
     * @return Provincia
     */
    public function setPais(\SG\ConfigBundle\Entity\Pais $pais = null)
    {
        $this->pais = $pais;
    
        return $this;
    }

    /**
     * Get pais
     *
     * @return \SG\ConfigBundle\Entity\Pais 
     */
    public function getPais()
    {
        return $this->pais;
    }

    /**
     * Add localidades
     *
     * @param \SG\ConfigBundle\Entity\Localidad $localidades
     * @return Provincia
     */
    public function addLocalidade(\SG\ConfigBundle\Entity\Localidad $localidades)
    {
        $this->localidades[] = $localidades;
    
        return $this;
    }

    /**
     * Remove localidades
     *
     * @param \SG\ConfigBundle\Entity\Localidad $localidades
     */
    public function removeLocalidade(\SG\ConfigBundle\Entity\Localidad $localidades)
    {
        $this->localidades->removeElement($localidades);
    }

    /**
     * Get localidades
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getLocalidades()
    {
        return $this->localidades;
    }

    /**
     * Set byDefault
     *
     * @param boolean $byDefault
     * @return Provincia
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
