<?php

namespace SG\AdminBundle\Entity;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * SG\AdminBundle\Entity\CajaMovimiento
 * @ORM\Table(name="caja_movimiento")
 * @ORM\Entity()
 */
class CajaMovimiento {
    /**
     * @var integer $id
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="SG\AdminBundle\Entity\CajaApertura", inversedBy="movimientos")
     * @ORM\JoinColumn(name="caja_apertura_id", referencedColumnName="id")
     */
    protected $cajaApertura;

    /**
     * @var string $tipo
     * @ORM\Column(name="tipo", type="string")
     */
    protected $tipo = 'I';

    /**
     * @var date $fecha
     * @ORM\Column(name="fecha", type="datetime", nullable=false)
     */
    protected $fecha;

    /**
     * @var string $descripcion
     * @ORM\Column(name="descripcion", type="string", nullable=true)
     */
    protected $descripcion;

    /**
     * @var string $responsablePago
     * @ORM\Column(name="responsable_pago", type="string", nullable=true)
     */
    protected $responsablePago;

    /**
     * @ORM\ManyToOne(targetEntity="SG\AdminBundle\Entity\Socio")
     * @ORM\JoinColumn(name="socio_id", referencedColumnName="id", onDelete="SET NULL")
     */
    protected $socio;

    /**
     * @var integer $total
     * @ORM\Column(name="total", type="decimal", scale=2 )
     */
    protected $total;

    /**
     * @var integer $pago
     * @ORM\Column(name="pago", type="decimal", scale=2,nullable=true )
     */
    protected $pago;

    /**
     * @var string $descripcionPago
     * @ORM\Column(name="descripcion_pago", type="string", nullable=true)
     */
    protected $descripcionPago;

    /**
     * @ORM\OneToMany(targetEntity="SG\AdminBundle\Entity\CajaMovimientoDetalle", mappedBy="cajaMovimiento",cascade={"persist", "remove"})
     */
    protected $detalles;

    /**
     * @ORM\OneToMany(targetEntity="SG\AdminBundle\Entity\Pago", mappedBy="cajaMovimiento",cascade={"persist", "remove"})
     */
    protected $pagos;

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
        $this->detalles = new \Doctrine\Common\Collections\ArrayCollection();
        $this->pagos = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set fecha
     *
     * @param \DateTime $fecha
     * @return CajaMovimiento
     */
    public function setFecha($fecha) {
        $this->fecha = $fecha;

        return $this;
    }

    /**
     * Get fecha
     *
     * @return \DateTime
     */
    public function getFecha() {
        return $this->fecha;
    }

    /**
     * Set responsablePago
     *
     * @param string $responsablePago
     * @return CajaMovimiento
     */
    public function setResponsablePago($responsablePago) {
        $this->responsablePago = $responsablePago;

        return $this;
    }

    /**
     * Get responsablePago
     *
     * @return string
     */
    public function getResponsablePago() {
        return $this->responsablePago;
    }

    /**
     * Set total
     *
     * @param string $total
     * @return CajaMovimiento
     */
    public function setTotal($total) {
        $this->total = $total;

        return $this;
    }

    /**
     * Get total
     *
     * @return string
     */
    public function getTotal() {
        return $this->total;
    }

    /**
     * Set pago
     *
     * @param string $pago
     * @return CajaMovimiento
     */
    public function setPago($pago) {
        $this->pago = $pago;

        return $this;
    }

    /**
     * Get pago
     *
     * @return string
     */
    public function getPago() {
        return $this->pago;
    }

    /**
     * Set descripcionPago
     *
     * @param string $descripcionPago
     * @return CajaMovimiento
     */
    public function setDescripcionPago($descripcionPago) {
        $this->descripcionPago = $descripcionPago;

        return $this;
    }

    /**
     * Get descripcionPago
     *
     * @return string
     */
    public function getDescripcionPago() {
        return $this->descripcionPago;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return CajaMovimiento
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
     * Set cajaApertura
     *
     * @param \SG\AdminBundle\Entity\CajaApertura $cajaApertura
     * @return CajaMovimiento
     */
    public function setCajaApertura(\SG\AdminBundle\Entity\CajaApertura $cajaApertura = null) {
        $this->cajaApertura = $cajaApertura;

        return $this;
    }

    /**
     * Get cajaApertura
     *
     * @return \SG\AdminBundle\Entity\CajaApertura
     */
    public function getCajaApertura() {
        return $this->cajaApertura;
    }

    /**
     * Set socio
     *
     * @param \SG\AdminBundle\Entity\Socio $socio
     * @return CajaMovimiento
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
     * Add detalles
     *
     * @param \SG\AdminBundle\Entity\CajaMovimientoDetalle $detalles
     * @return CajaMovimiento
     */
    public function addDetalle(\SG\AdminBundle\Entity\CajaMovimientoDetalle $detalles) {
        $detalles->setCajaMovimiento($this);
        $this->detalles[] = $detalles;
        return $this;
    }

    /**
     * Remove detalles
     *
     * @param \SG\AdminBundle\Entity\CajaMovimientoDetalle $detalles
     */
    public function removeDetalle(\SG\AdminBundle\Entity\CajaMovimientoDetalle $detalles) {
        $this->detalles->removeElement($detalles);
    }

    /**
     * Get detalles
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDetalles() {
        return $this->detalles;
    }

    /**
     * Add pagos
     *
     * @param \SG\AdminBundle\Entity\Pago $pagos
     * @return CajaMovimiento
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
     * @return CajaMovimiento
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
     * Set tipo
     *
     * @param string $tipo
     * @return CajaMovimiento
     */
    public function setTipo($tipo) {
        $this->tipo = $tipo;

        return $this;
    }

    /**
     * Get tipo
     *
     * @return string
     */
    public function getTipo() {
        return $this->tipo;
    }

    /**
     * Set descripcion
     *
     * @param string $descripcion
     * @return CajaMovimiento
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

    /*
     * Item tipo liquidaci??n del detalle 
     */

    public function getDetalleLiquidacion() {
        $liq = null;
        foreach ($this->getDetalles() as $det) {
            if ($det->getConcepto()->getTipo() == 'L') {
                $liq = $det;
                break;
            }
        }
        return $liq;
    }

    /*
     * Valor total de los items descontados en el movimiento de liquidacion
     */

    public function getLiquidacionImputaciones() {
        $imp = 0;
        foreach ($this->getDetalles() as $det) {
            if ($det->getConcepto()->getTipo() != 'L') {
                $imp = $imp + $det->getImporte();
            }
        }
        return $imp;
    }

}