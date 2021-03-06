<?php

namespace SG\AdminBundle\Entity;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * SG\AdminBundle\Entity\Socio
 * @ORM\Table(name="socio")
 * @ORM\Entity(repositoryClass="SG\AdminBundle\Entity\SocioRepository")
 * @ORM\HasLifecycleCallbacks
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 */
class Socio {
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
     * @var date $fechaBaja
     * @ORM\Column(name="fecha_baja", type="date", nullable=true)
     */
    protected $fechaBaja;

    /**
     * @var integer $saldoInicial
     * @ORM\Column(name="saldo_inicial", type="decimal", scale=2, nullable=true )
     */
    protected $saldoInicial;

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
     * @var string $contacto
     * @ORM\Column(name="contacto", type="string", nullable=true)
     */
    protected $contacto;

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
     * @ORM\ManyToMany(targetEntity="SG\ConfigBundle\Entity\Empresa")
     * @ORM\JoinTable(name="empresas_x_socio",
     *      joinColumns={@ORM\JoinColumn(name="socio_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="empresa_id", referencedColumnName="id", onDelete="RESTRICT")}
     * )
     */
    private $empresas;

    /**
     * @ORM\OneToMany(targetEntity="SG\AdminBundle\Entity\Empleado", mappedBy="socio",cascade={"persist", "remove"})
     * @ORM\OrderBy({"apellido" = "ASC","nombre" = "ASC"})
     */
    protected $empleados;

    /**
     * @ORM\OneToMany(targetEntity="SG\AdminBundle\Entity\Vehiculo", mappedBy="socio",cascade={"persist", "remove"})
     * @ORM\OrderBy({"dominio" = "ASC"})
     */
    protected $vehiculos;

    /**
     * @ORM\OneToMany(targetEntity="SG\AdminBundle\Entity\Deuda", mappedBy="socio",cascade={"persist", "remove"})
     * @ORM\OrderBy({"fechaVto"="ASC"})
     */
    protected $deudas;

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

    public function getSaldo() {
        $saldo = 0;
        foreach ($this->getDeudas() as $deuda) {
            if ($deuda->getVencido())
                $saldo = $saldo + $deuda->getSaldo();
        }
        return $saldo;
    }

    public function getListaDeudas() {
        $deudas = new \Doctrine\Common\Collections\ArrayCollection();
        foreach ($this->getDeudas() as $deuda) {
            if ($deuda->getConcepto()->getTipo() != 'L') {
                $deudas->add($deuda);
            }
        }
        return $deudas;
    }

    /**
     * Constructor
     */
    public function __construct() {
        $this->deudas = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Socio
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
     * Set cuit
     *
     * @param string $cuit
     * @return Socio
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
     * Set nombre
     *
     * @param string $nombre
     * @return Socio
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
     * @return Socio
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
     * @return Socio
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
     * Set fechaBaja
     *
     * @param \DateTime $fechaBaja
     * @return Socio
     */
    public function setFechaBaja($fechaBaja) {
        $this->fechaBaja = $fechaBaja;

        return $this;
    }

    /**
     * Get fechaBaja
     *
     * @return \DateTime
     */
    public function getFechaBaja() {
        return $this->fechaBaja;
    }

    /**
     * Set saldoInicial
     *
     * @param string $saldoInicial
     * @return Socio
     */
    public function setSaldoInicial($saldoInicial) {
        $this->saldoInicial = $saldoInicial;

        return $this;
    }

    /**
     * Get saldoInicial
     *
     * @return string
     */
    public function getSaldoInicial() {
        return $this->saldoInicial;
    }

    /**
     * Set direccion
     *
     * @param string $direccion
     * @return Socio
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
     * @return Socio
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
     * @return Socio
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
     * @return Socio
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
     * @return Socio
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
     * @return Socio
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
     * @return Socio
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
     * @return Socio
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
     * @return Socio
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
     * Add deudas
     *
     * @param \SG\AdminBundle\Entity\Deuda $deudas
     * @return Socio
     */
    public function addDeuda(\SG\AdminBundle\Entity\Deuda $deudas) {
        $this->deudas[] = $deudas;

        return $this;
    }

    /**
     * Remove deudas
     *
     * @param \SG\AdminBundle\Entity\Deuda $deudas
     */
    public function removeDeuda(\SG\AdminBundle\Entity\Deuda $deudas) {
        $this->deudas->removeElement($deudas);
    }

    /**
     * Get deudas
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDeudas() {
        return $this->deudas;
    }

    /**
     * Set createdBy
     *
     * @param \SG\ConfigBundle\Entity\Usuario $createdBy
     * @return Socio
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
     * @return Socio
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
     * Add empleados
     *
     * @param \SG\AdminBundle\Entity\Empleado $empleados
     * @return Socio
     */
    public function addEmpleado(\SG\AdminBundle\Entity\Empleado $empleados) {
        $empleados->setSocio($this);
        $this->empleados[] = $empleados;

        return $this;
    }

    /**
     * Remove empleados
     *
     * @param \SG\AdminBundle\Entity\Empleado $empleados
     */
    public function removeEmpleado(\SG\AdminBundle\Entity\Empleado $empleados) {
        $this->empleados->removeElement($empleados);
    }

    /**
     * Get empleados
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEmpleados() {
        return $this->empleados;
    }

    /**
     * Add vehiculos
     *
     * @param \SG\AdminBundle\Entity\Vehiculo $vehiculos
     * @return Socio
     */
    public function addVehiculo(\SG\AdminBundle\Entity\Vehiculo $vehiculos) {
        $vehiculos->setSocio($this);
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

    /**
     * Add empresas
     *
     * @param \SG\ConfigBundle\Entity\Empresa $empresas
     * @return Socio
     */
    public function addEmpresa(\SG\ConfigBundle\Entity\Empresa $empresas) {
        $this->empresas[] = $empresas;
        return $this;
    }

    /**
     * Remove empresas
     *
     * @param \SG\ConfigBundle\Entity\Empresa $empresas
     */
    public function removeEmpresa(\SG\ConfigBundle\Entity\Empresa $empresas) {
        $this->empresas->removeElement($empresas);
    }

    /**
     * Get empresas
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEmpresas() {
        return $this->empresas;
    }

    /**
     * Set contacto
     *
     * @param string $contacto
     * @return Socio
     */
    public function setContacto($contacto) {
        $this->contacto = $contacto;

        return $this;
    }

    /**
     * Get contacto
     *
     * @return string
     */
    public function getContacto() {
        return $this->contacto;
    }

}