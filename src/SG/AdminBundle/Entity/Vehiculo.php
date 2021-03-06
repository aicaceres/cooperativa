<?php

namespace SG\AdminBundle\Entity;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * SG\AdminBundle\Entity\Vehiculo
 * @ORM\Table(name="vehiculo")
 * @ORM\Entity()
 * @ORM\HasLifecycleCallbacks
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 */
class Vehiculo {
    /**
     * @var integer $id
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @var string $dominio
     * @ORM\Column(name="dominio", type="string", nullable=false)
     */
    protected $dominio;

    /**
     * @var string $modelo
     * @ORM\Column(name="modelo", type="string",nullable=true)
     */
    protected $modelo;

    /**
     * @var string $marca
     * @ORM\Column(name="marca", type="string", nullable=true)
     */
    protected $marca;

    /**
     * @var integer $anio
     * @ORM\Column(name="anio", type="integer", nullable=true)
     */
    protected $anio;

    /**
     * @var string $kilometros
     * @ORM\Column(name="kilometros", type="string", nullable=true)
     */
    protected $kilometros;

    /**
     * @var string $carga
     * @ORM\Column(name="carga", type="string", nullable=true)
     */
    protected $carga;

    /**
     * @ORM\OneToMany(targetEntity="SG\AdminBundle\Entity\Linea", mappedBy="vehiculo",cascade={"persist", "remove"}, orphanRemoval=true)
     */
    protected $lineas;

    /**
     * @ORM\ManyToOne(targetEntity="SG\AdminBundle\Entity\Socio", inversedBy="vehiculos")
     * @ORM\JoinColumn(name="socio_id", referencedColumnName="id", onDelete="SET NULL")
     */
    protected $socio;

    /**
     * @ORM\ManyToOne(targetEntity="SG\AdminBundle\Entity\Empleado", inversedBy="vehiculos")
     * @ORM\JoinColumn(name="empleado_id", referencedColumnName="id",onDelete="SET NULL")
     */
    protected $empleado;

    /**
     * @ORM\Column(name="asignado_al_socio", type="boolean", nullable=true)
     */
    protected $asignadoAlSocio = false;

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

    /**
     * @ORM\Column(name="deletedAt", type="datetime", nullable=true)
     */
    private $deletedAt;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId() {
        return $this->id;
    }

    public function __toString() {
        return $this->getMarca() . ' ' . $this->getModelo() . ' ' . $this->getDominio();
    }

    public function getMarcaModeloDominio() {
        return $this->getMarca() . ' ' . $this->getModelo() . ' ' . $this->getDominio();
    }

    /**
     * Set dominio
     *
     * @param string $dominio
     * @return Vehiculo
     */
    public function setDominio($dominio) {
        $this->dominio = strtoupper($dominio);

        return $this;
    }

    /**
     * Get dominio
     *
     * @return string
     */
    public function getDominio() {
        return $this->dominio;
    }

    /**
     * Set modelo
     *
     * @param string $modelo
     * @return Vehiculo
     */
    public function setModelo($modelo) {
        $this->modelo = $modelo;

        return $this;
    }

    /**
     * Get modelo
     *
     * @return string
     */
    public function getModelo() {
        return $this->modelo;
    }

    /**
     * Set marca
     *
     * @param string $marca
     * @return Vehiculo
     */
    public function setMarca($marca) {
        $this->marca = $marca;

        return $this;
    }

    /**
     * Get marca
     *
     * @return string
     */
    public function getMarca() {
        return $this->marca;
    }

    /**
     * Set anio
     *
     * @param integer $anio
     * @return Vehiculo
     */
    public function setAnio($anio) {
        $this->anio = $anio;

        return $this;
    }

    /**
     * Get anio
     *
     * @return integer
     */
    public function getAnio() {
        return $this->anio;
    }

    /**
     * Set kilometros
     *
     * @param string $kilometros
     * @return Vehiculo
     */
    public function setKilometros($kilometros) {
        $this->kilometros = $kilometros;

        return $this;
    }

    /**
     * Get kilometros
     *
     * @return string
     */
    public function getKilometros() {
        return $this->kilometros;
    }

    /**
     * Set carga
     *
     * @param string $carga
     * @return Vehiculo
     */
    public function setCarga($carga) {
        $this->carga = $carga;

        return $this;
    }

    /**
     * Get carga
     *
     * @return string
     */
    public function getCarga() {
        return $this->carga;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return Vehiculo
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
     * @return Vehiculo
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
     * @return Vehiculo
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
     * @return Vehiculo
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
     * Set deletedAt
     *
     * @param \DateTime $deletedAt
     * @return Vehiculo
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
     * Set socio
     *
     * @param \SG\AdminBundle\Entity\Socio $socio
     * @return Vehiculo
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
     * Set empleado
     *
     * @param \SG\AdminBundle\Entity\Empleado $empleado
     * @return Vehiculo
     */
    public function setEmpleado(\SG\AdminBundle\Entity\Empleado $empleado = null) {
        $this->empleado = $empleado;

        return $this;
    }

    /**
     * Get empleado
     *
     * @return \SG\AdminBundle\Entity\Empleado
     */
    public function getEmpleado() {
        return $this->empleado;
    }

    /**
     * Constructor
     */
    public function __construct() {
        $this->lineas = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add lineas
     *
     * @param \SG\AdminBundle\Entity\Linea $lineas
     * @return Vehiculo
     */
    public function addLinea(\SG\AdminBundle\Entity\Linea $lineas) {
        $lineas->setVehiculo($this);
        $this->lineas[] = $lineas;

        return $this;
    }

    /**
     * Remove lineas
     *
     * @param \SG\AdminBundle\Entity\Linea $lineas
     */
    public function removeLinea(\SG\AdminBundle\Entity\Linea $lineas) {
        $this->lineas->removeElement($lineas);
    }

    /**
     * Get lineas
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getLineas() {
        return $this->lineas;
    }

    public function getLineasHtml() {
        $html = '<ul class="ul-lineas">';
        foreach ($this->getLineas() as $linea) {
            $html = $html . '<li>' . $linea->getNombre() . ' [' . $linea->getKilometros() . ' km] </li>';
        }
        $html = $html . '</ul>';
        return $html;
    }

    public function getLineasTxt() {
        $txt = '';
        foreach ($this->getLineas() as $linea) {
            $txt = $txt . '<div><strong> ??? </strong>' . $linea->getNombre() . ' [' . $linea->getKilometros() . ' km] </div>';
        }
        return $txt;
    }

    /**
     * Set asignadoAlSocio
     *
     * @param boolean $asignadoAlSocio
     * @return Vehiculo
     */
    public function setAsignadoAlSocio($asignadoAlSocio) {
        $this->asignadoAlSocio = $asignadoAlSocio;

        return $this;
    }

    /**
     * Get asignadoAlSocio
     *
     * @return boolean
     */
    public function getAsignadoAlSocio() {
        return $this->asignadoAlSocio;
    }

}