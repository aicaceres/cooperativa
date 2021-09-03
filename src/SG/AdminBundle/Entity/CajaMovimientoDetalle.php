<?php
namespace SG\AdminBundle\Entity;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * SG\AdminBundle\Entity\CajaMovimientoDetalle
 * @ORM\Table(name="caja_movimiento_detalle")
 * @ORM\Entity()
 */
class CajaMovimientoDetalle
{
    /**
     * @var integer $id
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @var integer $orden
     * @ORM\Column(name="orden", type="integer" )
     */
    protected $orden;
    
    /**
     *@ORM\ManyToOne(targetEntity="SG\ConfigBundle\Entity\ConceptoCaja")
     *@ORM\JoinColumn(name="concepto_caja_id", referencedColumnName="id")
     */
    protected $concepto;

     /**
     * @var string $descripcion
     * @ORM\Column(name="descripcion", type="string", nullable=true)
     */
    protected $descripcion;

    /**
     * @var integer $importe
     * @ORM\Column(name="importe", type="decimal", scale=2 )
     */
    protected $importe;

    /**
     * @var integer $saldo
     * @ORM\Column(name="saldo", type="decimal", scale=2 )
     */
    protected $saldo=0;

     /**
     *@ORM\ManyToOne(targetEntity="SG\AdminBundle\Entity\CajaMovimiento", inversedBy="detalles")
     *@ORM\JoinColumn(name="caja_movimiento_id", referencedColumnName="id")
     */
    protected $cajaMovimiento;
    
     /**
     * @ORM\OneToMany(targetEntity="SG\AdminBundle\Entity\Pago", mappedBy="cajaMovimientoDetalle",cascade={"persist", "remove"})
     */
    protected $pagos;   

    /**
     *@ORM\ManyToOne(targetEntity="SG\AdminBundle\Entity\Deuda")
     *@ORM\JoinColumn(name="deuda_id", referencedColumnName="id")
     */
    protected $deuda;    


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->pagos = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set orden
     *
     * @param integer $orden
     * @return CajaMovimientoDetalle
     */
    public function setOrden($orden)
    {
        $this->orden = $orden;

        return $this;
    }

    /**
     * Get orden
     *
     * @return integer 
     */
    public function getOrden()
    {
        return $this->orden;
    }

    /**
     * Set descripcion
     *
     * @param string $descripcion
     * @return CajaMovimientoDetalle
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * Get descripcion
     *
     * @return string 
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * Set importe
     *
     * @param string $importe
     * @return CajaMovimientoDetalle
     */
    public function setImporte($importe)
    {
        $this->importe = $importe;

        return $this;
    }

    /**
     * Get importe
     *
     * @return string 
     */
    public function getImporte()
    {
        return $this->importe;
    }

    /**
     * Set saldo
     *
     * @param string $saldo
     * @return CajaMovimientoDetalle
     */
    public function setSaldo($saldo)
    {
        $this->saldo = $saldo;

        return $this;
    }

    /**
     * Get saldo
     *
     * @return string 
     */
    public function getSaldo()
    {
        return $this->saldo;
    }

    /**
     * Set concepto
     *
     * @param \SG\ConfigBundle\Entity\ConceptoCaja $concepto
     * @return CajaMovimientoDetalle
     */
    public function setConcepto(\SG\ConfigBundle\Entity\ConceptoCaja $concepto = null)
    {
        $this->concepto = $concepto;

        return $this;
    }

    /**
     * Get concepto
     *
     * @return \SG\ConfigBundle\Entity\ConceptoCaja 
     */
    public function getConcepto()
    {
        return $this->concepto;
    }

    /**
     * Set cajaMovimiento
     *
     * @param \SG\AdminBundle\Entity\CajaMovimiento $cajaMovimiento
     * @return CajaMovimientoDetalle
     */
    public function setCajaMovimiento(\SG\AdminBundle\Entity\CajaMovimiento $cajaMovimiento = null)
    {
        $this->cajaMovimiento = $cajaMovimiento;

        return $this;
    }

    /**
     * Get cajaMovimiento
     *
     * @return \SG\AdminBundle\Entity\CajaMovimiento 
     */
    public function getCajaMovimiento()
    {
        return $this->cajaMovimiento;
    }

    /**
     * Add pagos
     *
     * @param \SG\AdminBundle\Entity\Pago $pagos
     * @return CajaMovimientoDetalle
     */
    public function addPago(\SG\AdminBundle\Entity\Pago $pagos)
    {
        $this->pagos[] = $pagos;

        return $this;
    }

    /**
     * Remove pagos
     *
     * @param \SG\AdminBundle\Entity\Pago $pagos
     */
    public function removePago(\SG\AdminBundle\Entity\Pago $pagos)
    {
        $this->pagos->removeElement($pagos);
    }

    /**
     * Get pagos
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPagos()
    {
        return $this->pagos;
    }

    /**
     * Set deuda
     *
     * @param \SG\AdminBundle\Entity\Deuda $deuda
     * @return CajaMovimientoDetalle
     */
    public function setDeuda(\SG\AdminBundle\Entity\Deuda $deuda = null)
    {
        $this->deuda = $deuda;

        return $this;
    }

    /**
     * Get deuda
     *
     * @return \SG\AdminBundle\Entity\Deuda 
     */
    public function getDeuda()
    {
        return $this->deuda;
    }
}
