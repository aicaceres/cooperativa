<?php

namespace SG\AdminBundle\Entity;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * SG\AdminBundle\Entity\Empleado
 * @ORM\Table(name="empleado")
 * @ORM\Entity(repositoryClass="SG\AdminBundle\Entity\SocioRepository")
 * @ORM\HasLifecycleCallbacks
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 */
class Empleado {
    /**
     * @var integer $id
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @var string $nroDocumento
     * @ORM\Column(name="nro_documento", type="string",length=15, nullable=true)
     */
    protected $nroDocumento;

    /**
     * @var string $cuit
     * @ORM\Column(name="cuit", type="string",length=15, nullable=true)
     */
    protected $cuit;

    /**
     * @var string $nombre
     * @ORM\Column(name="nombre", type="string", nullable=false)
     * @Assert\NotBlank()
     */
    protected $nombre;

    /**
     * @var string $apellido
     * @ORM\Column(name="apellido", type="string", nullable=false)
     * @Assert\NotBlank()
     */
    protected $apellido;

    /**
     * @var date $fechaNacimiento
     * @ORM\Column(name="fecha_nacimiento", type="date", nullable=true)
     */
    protected $fechaNacimiento;

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
     * @ORM\ManyToOne(targetEntity="SG\ConfigBundle\Entity\Localidad")
     * @ORM\JoinColumn(name="localidad_id", referencedColumnName="id")
     */
    protected $localidad;

    /**
     * @var string $celular
     * @ORM\Column(name="celular", type="string", nullable=true)
     */
    protected $celular;

    /**
     * @var string $email
     * @ORM\Column(name="email", type="string", nullable=true)
     */
    protected $email;

    /**
     * @ORM\Column(name="activo", type="boolean", nullable=true)
     */
    protected $activo = true;

    /**
     * @ORM\ManyToOne(targetEntity="SG\AdminBundle\Entity\Socio", inversedBy="empleados")
     * @ORM\JoinColumn(name="socio_id", referencedColumnName="id", onDelete="SET NULL")
     */
    protected $socio;

    /**
     * @ORM\OneToMany(targetEntity="SG\AdminBundle\Entity\Vehiculo", mappedBy="empleado")
     */
    protected $vehiculos;

    /**
     * @ORM\Column(name="deletedAt", type="datetime", nullable=true)
     */
    private $deletedAt;

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
        return $this->getNombreCompleto();
    }

    public function getNombreCompleto() {
        return $this->apellido . ', ' . $this->nombre;
    }

    public function getTelefonos() {
        $tel = $this->telefono;
        if ($tel != '')
            $tel = $tel . ' / ' . $this->celular;
        else
            $tel = $this->celular;
        return $tel;
    }

    public function getDireccionTxt() {
        return $this->direccion . ' - ' . $this->localidad;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set nroDocumento
     *
     * @param string $nroDocumento
     * @return Empleado
     */
    public function setNroDocumento($nroDocumento) {
        $this->nroDocumento = $nroDocumento;

        return $this;
    }

    /**
     * Get nroDocumento
     *
     * @return string
     */
    public function getNroDocumento() {
        return $this->nroDocumento;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     * @return Empleado
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
     * Set apellido
     *
     * @param string $apellido
     * @return Empleado
     */
    public function setApellido($apellido) {
        $this->apellido = $apellido;

        return $this;
    }

    /**
     * Get apellido
     *
     * @return string
     */
    public function getApellido() {
        return $this->apellido;
    }

    /**
     * Set fechaNacimiento
     *
     * @param \DateTime $fechaNacimiento
     * @return Empleado
     */
    public function setFechaNacimiento($fechaNacimiento) {
        $this->fechaNacimiento = $fechaNacimiento;

        return $this;
    }

    /**
     * Get fechaNacimiento
     *
     * @return \DateTime
     */
    public function getFechaNacimiento() {
        return $this->fechaNacimiento;
    }

    /**
     * Set direccion
     *
     * @param string $direccion
     * @return Empleado
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
     * @return Empleado
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
     * Set celular
     *
     * @param string $celular
     * @return Empleado
     */
    public function setCelular($celular) {
        $this->celular = $celular;

        return $this;
    }

    /**
     * Get celular
     *
     * @return string
     */
    public function getCelular() {
        return $this->celular;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return Empleado
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
     * Set activo
     *
     * @param boolean $activo
     * @return Empleado
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
     * Set deletedAt
     *
     * @param \DateTime $deletedAt
     * @return Empleado
     */
    public function setDeletedAt($deletedAt) {
        $this->deletedAt = $deletedAt;

        return $this;
    }

    /**
     * Get deletedAt
     *
     * @return \DateTime
     */
    public function getDeletedAt() {
        return $this->deletedAt;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return Empleado
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
     * @return Empleado
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
     * Set localidad
     *
     * @param \SG\ConfigBundle\Entity\Localidad $localidad
     * @return Empleado
     */
    public function setLocalidad(\SG\ConfigBundle\Entity\Localidad $localidad = null) {
        $this->localidad = $localidad;

        return $this;
    }

    /**
     * Get localidad
     *
     * @return \SG\ConfigBundle\Entity\Localidad
     */
    public function getLocalidad() {
        return $this->localidad;
    }

    /**
     * Set createdBy
     *
     * @param \SG\ConfigBundle\Entity\Usuario $createdBy
     * @return Empleado
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
     * @return Empleado
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
     * Set socio
     *
     * @param \SG\AdminBundle\Entity\Socio $socio
     * @return Empleado
     */
    public function setSocio(\SG\AdminBundle\Entity\Socio $socio = null) {
        $this->socio = $socio;

        return $this;
    }

    /**
     * Get socio
     *
     * @return \SG\AdminBundle\Entity\Socio
     */
    public function getSocio() {
        return $this->socio;
    }

    /**
     * Set cuit
     *
     * @param string $cuit
     * @return Empleado
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
     * Constructor
     */
    public function __construct() {
        $this->vehiculos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add vehiculos
     *
     * @param \SG\AdminBundle\Entity\Vehiculo $vehiculos
     * @return Empleado
     */
    public function addVehiculo(\SG\AdminBundle\Entity\Vehiculo $vehiculos) {
        $vehiculos->setEmpleado($this);
        $this->vehiculos[] = $vehiculos;

        return $this;
    }

    /**
     * Remove vehiculos
     *
     * @param \SG\AdminBundle\Entity\Vehiculo $vehiculos
     */
    public function removeVehiculo(\SG\AdminBundle\Entity\Vehiculo $vehiculos) {
        $this->vehiculos->removeElement($vehiculos);
    }

    /**
     * Get vehiculos
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getVehiculos() {
        return $this->vehiculos;
    }

}