<?php

namespace SG\ConfigBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * SG\ConfigBundle\Entity\Empresa
 * @ORM\Table(name="empresa")
 * @ORM\Entity()
 */
class Empresa {
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
     * @var string $cuit
     * @ORM\Column(name="cuit", type="string", nullable=true)
     */
    protected $cuit;

    /**
     * @var string $direccion
     * @ORM\Column(name="direccion", type="string", nullable=true)
     */
    protected $direccion;

    /**
     * @var string $telefono
     * @ORM\Column(name="telefono", type="string", nullable=true)
     */
    protected $telefono;

    /**
     * @var string $email
     * @ORM\Column(name="email", type="string", nullable=true)
     */
    protected $email;

    /**
     * @var string $responsable
     * @ORM\Column(name="responsable", type="string", nullable=true)
     */
    protected $responsable;

    /**
     * @ORM\ManyToMany(targetEntity="SG\AdminBundle\Entity\Socio", mappedBy="empresas")
     */
    protected $socios;

    /**
     * @ORM\Column(name="activo", type="boolean")
     */
    protected $activo = true;

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

    /**
     * @var datetime $updated
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime")
     */
    private $updated;

    /**
     * @var User $updatedBy
     * @Gedmo\Blameable(on="update")
     * @ORM\ManyToOne(targetEntity="SG\ConfigBundle\Entity\Usuario")
     * @ORM\JoinColumn(name="updated_by", referencedColumnName="id")
     */
    private $updatedBy;

    public function __toString() {
        return $this->getNombre();
    }

    /**
     * Get id
     * @return integer
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set nombre
     * @param string $nombre
     * @return Empresa
     */
    public function setNombre($nombre) {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre
     *
     * @return string
     */
    public function getNombre() {
        return $this->nombre;
    }

    /**
     * Set cuit
     *
     * @param string $cuit
     * @return Empresa
     */
    public function setCuit($cuit) {
        $this->cuit = $cuit;

        return $this;
    }

    /**
     * Get cuit
     *
     * @return string
     */
    public function getCuit() {
        return $this->cuit;
    }

    /**
     * Set direccion
     *
     * @param string $direccion
     * @return Empresa
     */
    public function setDireccion($direccion) {
        $this->direccion = $direccion;

        return $this;
    }

    /**
     * Get direccion
     *
     * @return string
     */
    public function getDireccion() {
        return $this->direccion;
    }

    /**
     * Set telefono
     *
     * @param string $telefono
     * @return Empresa
     */
    public function setTelefono($telefono) {
        $this->telefono = $telefono;

        return $this;
    }

    /**
     * Get telefono
     *
     * @return string
     */
    public function getTelefono() {
        return $this->telefono;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return Empresa
     */
    public function setEmail($email) {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail() {
        return $this->email;
    }

    /**
     * Set responsable
     *
     * @param string $responsable
     * @return Empresa
     */
    public function setResponsable($responsable) {
        $this->responsable = $responsable;

        return $this;
    }

    /**
     * Get responsable
     *
     * @return string
     */
    public function getResponsable() {
        return $this->responsable;
    }

    /**
     * Set activo
     *
     * @param boolean $activo
     * @return Empresa
     */
    public function setActivo($activo) {
        $this->activo = $activo;

        return $this;
    }

    /**
     * Get activo
     *
     * @return boolean
     */
    public function getActivo() {
        return $this->activo;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return Empresa
     */
    public function setCreated($created) {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime
     */
    public function getCreated() {
        return $this->created;
    }

    /**
     * Set updated
     *
     * @param \DateTime $updated
     * @return Empresa
     */
    public function setUpdated($updated) {
        $this->updated = $updated;

        return $this;
    }

    /**
     * Get updated
     *
     * @return \DateTime
     */
    public function getUpdated() {
        return $this->updated;
    }

    /**
     * Set createdBy
     *
     * @param \SG\ConfigBundle\Entity\Usuario $createdBy
     * @return Empresa
     */
    public function setCreatedBy(\SG\ConfigBundle\Entity\Usuario $createdBy = null) {
        $this->createdBy = $createdBy;

        return $this;
    }

    /**
     * Get createdBy
     *
     * @return \SG\ConfigBundle\Entity\Usuario
     */
    public function getCreatedBy() {
        return $this->createdBy;
    }

    /**
     * Set updatedBy
     *
     * @param \SG\ConfigBundle\Entity\Usuario $updatedBy
     * @return Empresa
     */
    public function setUpdatedBy(\SG\ConfigBundle\Entity\Usuario $updatedBy = null) {
        $this->updatedBy = $updatedBy;

        return $this;
    }

    /**
     * Get updatedBy
     *
     * @return \SG\ConfigBundle\Entity\Usuario
     */
    public function getUpdatedBy() {
        return $this->updatedBy;
    }

    /**
     * Constructor
     */
    public function __construct() {
        $this->socios = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add socios
     *
     * @param \SG\AdminBundle\Entity\Socio $socios
     * @return Empresa
     */
    public function addSocio(\SG\AdminBundle\Entity\Socio $socios) {
        $this->socios[] = $socios;

        return $this;
    }

    /**
     * Remove socios
     *
     * @param \SG\AdminBundle\Entity\Socio $socios
     */
    public function removeSocio(\SG\AdminBundle\Entity\Socio $socios) {
        $this->socios->removeElement($socios);
    }

    /**
     * Get socios
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSocios() {
        return $this->socios;
    }

}