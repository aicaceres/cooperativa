<?php

namespace SG\ConfigBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * SG\ConfigBundle\Entity\ConceptoCaja
 * @ORM\Table(name="concepto_caja")
 * @ORM\Entity(repositoryClass="SG\ConfigBundle\Entity\ConceptoCajaRepository")
 */
class ConceptoCaja {
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
     * @var string $tipo
     * @ORM\Column(name="tipo", type="string", nullable=true)
     */
    protected $tipo = 'I';

    /**
     * @ORM\Column(name="requiere_socio", type="boolean", nullable=true)
     */
    protected $requiereSocio = false;

    /**
     * @var string $monto
     * @ORM\Column(name="monto", type="decimal", scale=2, nullable=true)
     */
    protected $monto;

    /**
     * @ORM\Column(name="de_sistema", type="string", nullable=true)
     */
    // pago de inscripcion='PI'; pago de cuota='PC'; gasto compensado='GC'
    protected $deSistema = false;

    public function __toString() {
        return $this->nombre;
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
     * Set nombre
     *
     * @param string $nombre
     * @return ConceptoCaja
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
     * Set tipo
     *
     * @param string $tipo
     * @return ConceptoCaja
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
     * Set requiereSocio
     *
     * @param boolean $requiereSocio
     * @return ConceptoCaja
     */
    public function setRequiereSocio($requiereSocio) {
        $this->requiereSocio = $requiereSocio;

        return $this;
    }

    /**
     * Get RequiereSocio
     *
     * @return boolean
     */
    public function getRequiereSocio() {
        return $this->requiereSocio;
    }

    /**
     * Set deSistema
     *
     * @param string $deSistema
     * @return ConceptoCaja
     */
    public function setDeSistema($deSistema) {
        $this->deSistema = $deSistema;

        return $this;
    }

    /**
     * Get deSistema
     *
     * @return string
     */
    public function getDeSistema() {
        return $this->deSistema;
    }

    /**
     * Set monto
     *
     * @param string $monto
     * @return ConceptoCaja
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

}