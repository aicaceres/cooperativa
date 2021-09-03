<?php

namespace SG\AdminBundle\Entity;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;

/**
 * SG\AdminBundle\Entity\Pago
 * @ORM\Table(name="pago")
 * @ORM\Entity()
 */
class Pago {
    /**
     * @var integer $id
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @var date $fecha
     * @ORM\Column(name="fecha", type="date")
     */
    protected $fecha;

    /**
     * @var integer $importe
     * @ORM\Column(name="importe", type="decimal", scale=2 )
     */
    protected $importe;

    /**
     * @var string $descripcion
     * @ORM\Column(name="descripcion", type="string", nullable=true)
     */
    protected $descripcion;

    /**
     * @ORM\ManyToOne(targetEntity="SG\AdminBundle\Entity\Deuda", inversedBy="pagos")
     * @ORM\JoinColumn(name="deuda_id", referencedColumnName="id")
     */
    protected $deuda;

    /**
     * @ORM\ManyToOne(targetEntity="SG\AdminBundle\Entity\CajaMovimiento", inversedBy="pagos")
     * @ORM\JoinColumn(name="caja_movimiento_id", referencedColumnName="id")
     */
    protected $cajaMovimiento;

    /**
     * @ORM\ManyToOne(targetEntity="SG\AdminBundle\Entity\CajaMovimientoDetalle", inversedBy="pagos")
     * @ORM\JoinColumn(name="caja_movimiento_detalle_id", referencedColumnName="id")
     */
    protected $cajaMovimientoDetalle;

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
     * @return Pago
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
     * Set importe
     *
     * @param string $importe
     * @return Pago
     */
    public function setImporte($importe) {
        $this->importe = $importe;

        return $this;
    }

    /**
     * Get importe
     *
     * @return string
     */
    public function getImporte() {
        return $this->importe;
    }

    /**
     * Set descripcion
     *
     * @param string $descripcion
     * @return Pago
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
     * Set created
     *
     * @param \DateTime $created
     * @return Pago
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
     * Set deuda
     *
     * @param \SG\AdminBundle\Entity\Deuda $deuda
     * @return Pago
     */
    public function setDeuda(\SG\AdminBundle\Entity\Deuda $deuda = null) {
        $this->deuda = $deuda;

        return $this;
    }

    /**
     * Get deuda
     *
     * @return \SG\AdminBundle\Entity\Deuda
     */
    public function getDeuda() {
        return $this->deuda;
    }

    /**
     * Set createdBy
     *
     * @param \SG\ConfigBundle\Entity\Usuario $createdBy
     * @return Pago
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
     * Set cajaMovimiento
     *
     * @param \SG\AdminBundle\Entity\CajaMovimiento $cajaMovimiento
     * @return Pago
     */
    public function setCajaMovimiento(\SG\AdminBundle\Entity\CajaMovimiento $cajaMovimiento = null) {
        $this->cajaMovimiento = $cajaMovimiento;

        return $this;
    }

    /**
     * Get cajaMovimiento
     *
     * @return \SG\AdminBundle\Entity\CajaMovimiento
     */
    public function getCajaMovimiento() {
        return $this->cajaMovimiento;
    }

    /**
     * Set cajaMovimientoDetalle
     *
     * @param \SG\AdminBundle\Entity\CajaMovimientoDetalle $cajaMovimientoDetalle
     * @return Pago
     */
    public function setCajaMovimientoDetalle(\SG\AdminBundle\Entity\CajaMovimientoDetalle $cajaMovimientoDetalle = null) {
        $this->cajaMovimientoDetalle = $cajaMovimientoDetalle;

        return $this;
    }

    /**
     * Get cajaMovimientoDetalle
     *
     * @return \SG\AdminBundle\Entity\CajaMovimientoDetalle
     */
    public function getCajaMovimientoDetalle() {
        return $this->cajaMovimientoDetalle;
    }

}