<?php

namespace SG\AdminBundle\Entity;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * SG\AdminBundle\Entity\CajaApertura
 * @ORM\Table(name="caja_apertura")
 * @ORM\Entity()
 */
class CajaApertura {
    /**
     * @var integer $id
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="SG\AdminBundle\Entity\Caja", inversedBy="aperturas")
     * @ORM\JoinColumn(name="caja_id", referencedColumnName="id")
     */
    protected $caja;

    /**
     * @var date $fechaApertura
     * @ORM\Column(name="fecha_apertura", type="datetime", nullable=false)
     */
    protected $fechaApertura;

    /**
     * @var integer $montoApertura
     * @ORM\Column(name="monto_apertura", type="decimal", scale=2 )
     */
    protected $montoApertura;

    /**
     * @var date $fechaCierre
     * @ORM\Column(name="fecha_cierre", type="datetime", nullable=true)
     */
    protected $fechaCierre;

    /**
     * @var integer $montoCierre
     * @ORM\Column(name="monto_cierre", type="decimal", scale=2, nullable=true )
     */
    protected $montoCierre;

    /**
     * @var User $updatedBy
     * @Gedmo\Blameable(on="update")
     * @ORM\ManyToOne(targetEntity="SG\ConfigBundle\Entity\Usuario")
     * @ORM\JoinColumn(name="updated_by", referencedColumnName="id")
     */
    private $updatedBy;

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
     * @ORM\OneToMany(targetEntity="SG\AdminBundle\Entity\CajaMovimiento", mappedBy="cajaApertura")
     */
    protected $movimientos;

    public function __toString() {
        return (string) $this->getId();
    }

    public function getTotalMovimientos() {
        $total = 0;
        foreach ($this->getMovimientos() as $mov) {
            if ($mov->getTipo() == 'I') {
                $total += $mov->getPago();
            }
            elseif ($mov->getTipo() == 'E') {
                $total -= $mov->getTotal();
            }
            else {
                foreach ($mov->getDetalles() as $det) {
                    if ($det->getConcepto()->getTipo() == 'L') {
                        $total -= $det->getImporte();
                    }
                    else {
                        $total += $det->getImporte();
                    }
                }
            }
        }

        return $total;
    }

    public function getDiferencia() {
        return ($this->getMontoApertura() + $this->getTotalMovimientos()) - $this->getMontoCierre();
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
     * Set fechaApertura
     *
     * @param \DateTime $fechaApertura
     * @return CajaApertura
     */
    public function setFechaApertura($fechaApertura) {
        $this->fechaApertura = $fechaApertura;

        return $this;
    }

    /**
     * Get fechaApertura
     *
     * @return \DateTime
     */
    public function getFechaApertura() {
        return $this->fechaApertura;
    }

    /**
     * Set montoApertura
     *
     * @param string $montoApertura
     * @return CajaApertura
     */
    public function setMontoApertura($montoApertura) {
        $this->montoApertura = $montoApertura;

        return $this;
    }

    /**
     * Get montoApertura
     *
     * @return string
     */
    public function getMontoApertura() {
        return $this->montoApertura;
    }

    /**
     * Set fechaCierre
     *
     * @param \DateTime $fechaCierre
     * @return CajaApertura
     */
    public function setFechaCierre($fechaCierre) {
        $this->fechaCierre = $fechaCierre;

        return $this;
    }

    /**
     * Get fechaCierre
     *
     * @return \DateTime
     */
    public function getFechaCierre() {
        return $this->fechaCierre;
    }

    /**
     * Set montoCierre
     *
     * @param string $montoCierre
     * @return CajaApertura
     */
    public function setMontoCierre($montoCierre) {
        $this->montoCierre = $montoCierre;

        return $this;
    }

    /**
     * Get montoCierre
     *
     * @return string
     */
    public function getMontoCierre() {
        return $this->montoCierre;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return CajaApertura
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
     * Set caja
     *
     * @param \SG\AdminBundle\Entity\Caja $caja
     * @return CajaApertura
     */
    public function setCaja(\SG\AdminBundle\Entity\Caja $caja = null) {
        $this->caja = $caja;

        return $this;
    }

    /**
     * Get caja
     *
     * @return \SG\AdminBundle\Entity\Caja
     */
    public function getCaja() {
        return $this->caja;
    }

    /**
     * Set updatedBy
     *
     * @param \SG\ConfigBundle\Entity\Usuario $updatedBy
     * @return CajaApertura
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
     * Set createdBy
     *
     * @param \SG\ConfigBundle\Entity\Usuario $createdBy
     * @return CajaApertura
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
     * Constructor
     */
    public function __construct() {
        $this->movimientos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add movimientos
     *
     * @param \SG\AdminBundle\Entity\CajaMovimiento $movimientos
     * @return CajaApertura
     */
    public function addMovimiento(\SG\AdminBundle\Entity\CajaMovimiento $movimientos) {
        $this->movimientos[] = $movimientos;

        return $this;
    }

    /**
     * Remove movimientos
     *
     * @param \SG\AdminBundle\Entity\CajaMovimiento $movimientos
     */
    public function removeMovimiento(\SG\AdminBundle\Entity\CajaMovimiento $movimientos) {
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