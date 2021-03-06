<?php
namespace SG\ConfigBundle\Entity;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * SG\ConfigBundle\Entity\Perfil
 * @ORM\Table(name="perfil")
 * @ORM\Entity()
 */
class Perfil
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
     * @ORM\Column(name="nombre", type="string")
     * @Assert\NotBlank()
     */
    protected $nombre;
    
    /**
     * @ORM\Column(name="admin", type="boolean")
     */
    protected $admin = false;
    
    /**
     * @ORM\Column(name="socio", type="boolean")
     */
    protected $socio;
    /**
     * @ORM\Column(name="caja", type="boolean")
     */
    protected $caja;
   
    /**
     * @ORM\Column(name="parametro", type="boolean")
     */
    protected $parametro;
    /**
     * @ORM\Column(name="seguridad", type="boolean")
     */
    protected $seguridad;

    /**
     * @ORM\ManyToMany(targetEntity="SG\ConfigBundle\Entity\Permiso")
     * @ORM\JoinTable(name="pemisos_x_perfil",
     *      joinColumns={@ORM\JoinColumn(name="perfil_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="permiso_id", referencedColumnName="id")}
     * )
     */
    private $permisos;

    /**
     * @var datetime $created
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     */
    private $created;
    

    public function __toString() {
        return $this->nombre;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->permisos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getItemMenu(){
        $array = array();
        foreach ($this->getPermisos() as $permiso) {
            if($permiso->getItem()){
                array_push($array, $permiso->getItem());                
            }
        }
        return $array; 
    }
    public function checkItemMenu($item){
        foreach ($this->getPermisos() as $permiso) {
            if($permiso->getItem()==$item){
               return TRUE;
            }
        }
        return FALSE; 
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
     * @return Perfil
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
     * @return Perfil
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
     * Set parametro
     *
     * @param boolean $parametro
     * @return Perfil
     */
    public function setParametro($parametro)
    {
        $this->parametro = $parametro;

        return $this;
    }

    /**
     * Get parametro
     *
     * @return boolean 
     */
    public function getParametro()
    {
        return $this->parametro;
    }

    /**
     * Set seguridad
     *
     * @param boolean $seguridad
     * @return Perfil
     */
    public function setSeguridad($seguridad)
    {
        $this->seguridad = $seguridad;

        return $this;
    }

    /**
     * Get seguridad
     *
     * @return boolean 
     */
    public function getSeguridad()
    {
        return $this->seguridad;
    }

    /**
     * Set socio
     *
     * @param boolean $socio
     * @return Perfil
     */
    public function setSocio($socio)
    {
        $this->socio = $socio;

        return $this;
    }

    /**
     * Get socio
     *
     * @return boolean 
     */
    public function getSocio()
    {
        return $this->socio;
    }

    /**
     * Set admin
     *
     * @param boolean $admin
     * @return Perfil
     */
    public function setAdmin ($admin)
    {
        $this->admin = $admin;

        return $this;
    }

    /**
     * Get admin
     *
     * @return boolean 
     */
    public function getAdmin()
    {
        return $this->admin;
    }

    /**
     * Add permisos
     *
     * @param \SG\ConfigBundle\Entity\Permiso $permisos
     * @return Perfil
     */
    public function addPermiso(\SG\ConfigBundle\Entity\Permiso $permisos)
    {
        $this->permisos[] = $permisos;

        return $this;
    }

    /**
     * Remove permisos
     *
     * @param \SG\ConfigBundle\Entity\Permiso $permisos
     */
    public function removePermiso(\SG\ConfigBundle\Entity\Permiso $permisos)
    {
        $this->permisos->removeElement($permisos);
    }

    /**
     * Get permisos
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPermisos()
    {
        return $this->permisos;
    }

    /**
     * Set caja
     *
     * @param boolean $caja
     * @return Perfil
     */
    public function setCaja($caja)
    {
        $this->caja = $caja;

        return $this;
    }

    /**
     * Get caja
     *
     * @return boolean 
     */
    public function getCaja()
    {
        return $this->caja;
    }
}
