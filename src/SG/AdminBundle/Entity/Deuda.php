<?php

namespace SG\AdminBundle\Entity;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * SG\AdminBundle\Entity\Deuda
 * @ORM\Table(name="deuda")
 * @ORM\Entity(repositoryClass="SG\AdminBundle\Entity\DeudaRepository")
 */
class Deuda {
    /**
     * @var integer $id
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="SG\AdminBundle\Entity\Socio", inversedBy="deudas")
     * @ORM\JoinColumn(name="socio_id", referencedColumnName="id", onDelete="SET NULL")
     */
    protected $socio;

    /**
     * @ORM\ManyToOne(targetEntity="SG\ConfigBundle\Entity\ConceptoCaja")
     * @ORM\JoinColumn(name="concepto_caja_id", referencedColumnName="id")
     */
    protected $concepto;

    /**
     * @var string $descripcion
     * @ORM\Column(name="descripcion", type="text", nullable=true)
     */
    protected $descripcion;

    /**
     * @var string $detalle
     * @ORM\Column(name="detalle", type="text", nullable=true)
     */
    protected $detalle;

    /**
     * @var date $fechaVto
     * @ORM\Column(name="fecha_vto", type="datetime", nullable=false)
     */
    protected $fechaVto;

    /**
     * @var integer $monto
     * @ORM\Column(name="monto", type="decimal", scale=2 )
     */
    protected $monto = 0;

    /**
     * @var integer $mora
     * @ORM\Column(name="mora", type="decimal", scale=2 )
     */
    protected $mora = 0;

    /**
     * @ORM\OneToMany(targetEntity="SG\AdminBundle\Entity\Pago", mappedBy="deuda",cascade={"persist", "remove"})
     */
    protected $pagos;

    /**
     * @var string $cancelada
     * @ORM\Column(name="cancelada", type="boolean")
     */
    protected $cancelada = false;

    /**
     * @var date $fechaCancelacion
     * @ORM\Column(name="fecha_cancelacion", type="datetime", nullable=true)
     */
    protected $fechaCancelacion;

    /**
     * @ORM\OneToMany(targetEntity="SG\AdminBundle\Entity\CajaMovimientoDetalle", mappedBy="deuda")
     */
    protected $movimientos;

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
     * Constructor
     */
    public function __construct() {
        $this->pagos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getDeudaTxt() {
        return $this->concepto . ' - ' . $this->descripcion;
    }

    public function getSaldo() {
        $saldo = $this->monto + $this->mora;
        foreach ($this->getPagos() as $pago) {
            $saldo = $saldo - $pago->getImporte();
        }
        if ($this->getConcepto()->getTipo() == 'L') {
            $monto = 0;
            // restar los items descontados en la liquidaci??n.
            foreach ($this->getMovimientos() as $detmov) {
                $monto = $monto + $detmov->getCajaMovimiento()->getLiquidacionImputaciones();
            }
            $saldo = $saldo - $monto;
        }
        return ($saldo < 0) ? 0 : $saldo;
    }

    public function getUltimoPago() {
        $fecha = null;
        foreach ($this->getPagos() as $pago) {
            $fecha = $pago->getFecha();
        }
        return $fecha;
    }

    public function getVencido() {
        $hoy = new \DateTime;
        return ($this->fechaVto->format('Ymd') < $hoy->format('Ymd')) && ($this->getSaldo() > 0);
    }

    public function getTotal() {
        return $this->monto + $this->mora;
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
     * Set fechaVto
     *
     * @param \DateTime $fechaVto
     * @return Deuda
     */
    public function setFechaVto($fechaVto) {
        $this->fechaVto = $fechaVto;

        return $this;
    }

    /**
     * Get fechaVto
     *
     * @return \DateTime
     */
    public function getFechaVto() {
        return $this->fechaVto;
    }

    /**
     * Set monto
     *
     * @param string $monto
     * @return Deuda
     */
    public function setMonto($monto) {
        $this->monto = $monto;

        return $this;
    }

    /**
     * Get monto
     *
     * @return string
     */
    public function getMonto() {
        return $this->monto;
    }

    /**
     * Set mora
     *
     * @param string $mora
     * @return Deuda
     */
    public function setMora($mora) {
        $this->mora = $mora;

        return $this;
    }

    /**
     * Get mora
     *
     * @return string
     */
    public function getMora() {
        return $this->mora;
    }

    /**
     * Set cancelada
     *
     * @param boolean $cancelada
     * @return Deuda
     */
    public function setCancelada($cancelada) {
        $this->cancelada = $cancelada;

        return $this;
    }

    /**
     * Get cancelada
     *
     * @return boolean
     */
    public function getCancelada() {
        return $this->cancelada;
    }

    /**
     * Set fechaCancelacion
     *
     * @param \DateTime $fechaCancelacion
     * @return Deuda
     */
    public function setFechaCancelacion($fechaCancelacion) {
        $this->fechaCancelacion = $fechaCancelacion;

        return $this;
    }

    /**
     * Get fechaCancelacion
     *
     * @return \DateTime
     */
    public function getFechaCancelacion() {
        return $this->fechaCancelacion;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return Deuda
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
     * Set concepto
     *
     * @param \SG\ConfigBundle\Entity\ConceptoCaja $concepto
     * @return Deuda
     */
    public function setConcepto(\SG\ConfigBundle\Entity\ConceptoCaja $concepto = null) {
        $this->concepto = $concepto;

        return $this;
    }

    /**
     * Get concepto
     *
     * @return \SG\ConfigBundle\Entity\ConceptoCaja
     */
    public function getConcepto() {
        return $this->concepto;
    }

    /**
     * Add pagos
     *
     * @param \SG\AdminBundle\Entity\Pago $pagos
     * @return Deuda
     */
    public function addPago(\SG\AdminBundle\Entity\Pago $pagos) {
        $this->pagos[] = $pagos;

        return $this;
    }

    /**
     * Remove pagos
     *
     * @param \SG\AdminBundle\Entity\Pago $pagos
     */
    public function removePago(\SG\AdminBundle\Entity\Pago $pagos) {
        $this->pagos->removeElement($pagos);
    }

    /**
     * Get pagos
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPagos() {
        return $this->pagos;
    }

    /**
     * Set createdBy
     *
     * @param \SG\ConfigBundle\Entity\Usuario $createdBy
     * @return Deuda
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
     * Set socio
     *
     * @param \SG\AdminBundle\Entity\Socio $socio
     * @return Deuda
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
     * Set descripcion
     *
     * @param string $descripcion
     * @return Deuda
     */
    public function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * Get descripcion
     *
     * @return string
     */
    public function getDescripcion() {
        return $this->descripcion;
    }

    /**
     * Set detalle
     *
     * @param string $detalle
     * @return Deuda
     */
    public function setDetalle($detalle) {
        $this->detalle = $detalle;

        return $this;
    }

    /**
     * Get detalle
     *
     * @return string
     */
    public function getDetalle() {
        return $this->detalle;
    }

    /**
     * Add movimientos
     *
     * @param \SG\AdminBundle\Entity\CajaMovimientoDetalle $movimientos
     * @return Deuda
     */
    public function addMovimiento(\SG\AdminBundle\Entity\CajaMovimientoDetalle $movimientos) {
        $this->movimientos[] = $movimientos;

        return $this;
    }

    /**
     * Remove movimientos
     *
     * @param \SG\AdminBundle\Entity\CajaMovimientoDetalle $movimientos
     */
    public function removeMovimiento(\SG\AdminBundle\Entity\CajaMovimientoDetalle $movimientos) {
        $this->movimientos->removeElement($movimientos);
    }

    /**
     * Get movimientos
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMovimientos() {
        return $this->movimientos;
    }

}