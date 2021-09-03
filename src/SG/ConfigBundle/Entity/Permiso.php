<?php
namespace SG\ConfigBundle\Entity;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * SG\ConfigBundle\Entity\Permiso
 * @ORM\Table(name="permiso")
 * @ORM\Entity(repositoryClass="SG\ConfigBundle\Entity\PermisoRepository")
 */
class Permiso
{
    /**
     * @var integer $id
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @var string $modulo
     * @ORM\Column(name="modulo", type="string")
     * @Assert\NotBlank()
     */
    protected $modulo;

    /**
     * @var string $item
     * @ORM\Column(name="item", type="string", nullable=true)
     */
    protected $item;

    /**
     * @var string $tag
     * @ORM\Column(name="tag", type="string")
     * @Assert\NotBlank()
     */
    protected $tag;
    
    /**
     * @var string $texto
     * @ORM\Column(name="texto", type="string")
     * @Assert\NotBlank()
     */
    protected $texto;
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
    
    public function __toString() {
        $item = ($this->item) ? $this->item.'-' : '';
        return $this->modulo.'-'.$item.$this->tag;
    }
    public function getModuloTag() {
        return $this->__toString();
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
     * Set tag
     *
     * @param string $tag
     * @return Permiso
     */
    public function setTag($tag)
    {
        $this->tag = $tag;

        return $this;
    }

    /**
     * Get tag
     *
     * @return string
     */
    public function getTag()
    {
        return $this->tag;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return Permiso
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
     * @return Permiso
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
     * Set modulo
     *
     * @param string $modulo
     * @return Permiso
     */
    public function setModulo($modulo)
    {
        $this->modulo = $modulo;

        return $this;
    }

    /**
     * Get modulo
     *
     * @return string 
     */
    public function getModulo()
    {
        return $this->modulo;
    }

    /**
     * Set texto
     *
     * @param string $texto
     * @return Permiso
     */
    public function setTexto($texto)
    {
        $this->texto = $texto;

        return $this;
    }

    /**
     * Get texto
     *
     * @return string 
     */
    public function getTexto()
    {
        return $this->texto;
    }

    /**
     * Set item
     *
     * @param string $item
     * @return Permiso
     */
    public function setItem($item)
    {
        $this->item = $item;

        return $this;
    }

    /**
     * Get item
     *
     * @return string 
     */
    public function getItem()
    {
        return $this->item;
    }
}
