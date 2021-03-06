<?php
namespace SG\ConfigBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * SG\ConfigBundle\Entity\Configuracion
 * @ORM\Table(name="configuracion")
 * @ORM\Entity()
 */
class Configuracion
{
    /**
     * @var integer $id
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;
     
    /**
     * @var integer $diaVtoCuota
     * @ORM\Column(name="dia_vto_cuota", type="integer")
     */
     protected $diaVtoCuota=10;

    /**
     * @var integer $tipoRecargoCuota
     * @ORM\Column(name="tipo_recargo_cuota", type="string")
     */
     protected $tipoRecargoCuota;
     
     /**
     * @var integer $montoRecargoCuota
     * @ORM\Column(name="monto_recargo_cuota", type="decimal", scale=3)
     */
     protected $montoRecargoCuota;

     /**
     * @var string $textoMailMorosos
     * @ORM\Column(name="texto_mail_morosos", type="text", nullable=true)
     */
    protected $textoMailMorosos;
    
    /**
     * @var User $updatedBy
     * @Gedmo\Blameable(on="update")
     * @ORM\ManyToOne(targetEntity="SG\ConfigBundle\Entity\Usuario")
     * @ORM\JoinColumn(name="updated_by", referencedColumnName="id")
     */
    private $updatedBy;

    /**
     * @var datetime $updated
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime")
     */
    private $updated;


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
     * Set diaVtoCuota
     *
     * @param integer $diaVtoCuota
     * @return Parametros
     */
    public function setDiaVtoCuota($diaVtoCuota)
    {
        $this->diaVtoCuota = $diaVtoCuota;

        return $this;
    }

    /**
     * Get diaVtoCuota
     *
     * @return integer 
     */
    public function getDiaVtoCuota()
    {
        return $this->diaVtoCuota;
    }

    /**
     * Set tipoRecargoCuota
     *
     * @param string $tipoRecargoCuota
     * @return Parametros
     */
    public function setTipoRecargoCuota($tipoRecargoCuota)
    {
        $this->tipoRecargoCuota = $tipoRecargoCuota;

        return $this;
    }

    /**
     * Get tipoRecargoCuota
     *
     * @return string 
     */
    public function getTipoRecargoCuota()
    {
        return $this->tipoRecargoCuota;
    }

    /**
     * Set montoRecargoCuota
     *
     * @param integer $montoRecargoCuota
     * @return Parametros
     */
    public function setMontoRecargoCuota($montoRecargoCuota)
    {
        $this->montoRecargoCuota = $montoRecargoCuota;

        return $this;
    }

    /**
     * Get montoRecargoCuota
     *
     * @return integer 
     */
    public function getMontoRecargoCuota()
    {
        return $this->montoRecargoCuota;
    }

    /**
     * Set updated
     *
     * @param \DateTime $updated
     * @return Parametros
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;

        return $this;
    }

    /**
     * Get updated
     *
     * @return \DateTime 
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * Set updatedBy
     *
     * @param \SG\ConfigBundle\Entity\Usuario $updatedBy
     * @return Parametros
     */
    public function setUpdatedBy(\SG\ConfigBundle\Entity\Usuario $updatedBy = null)
    {
        $this->updatedBy = $updatedBy;

        return $this;
    }

    /**
     * Get updatedBy
     *
     * @return \SG\ConfigBundle\Entity\Usuario 
     */
    public function getUpdatedBy()
    {
        return $this->updatedBy;
    }

    /**
     * Set textoMailMorosos
     *
     * @param string $textoMailMorosos
     * @return Configuracion
     */
    public function setTextoMailMorosos($textoMailMorosos)
    {
        $this->textoMailMorosos = $textoMailMorosos;

        return $this;
    }

    /**
     * Get textoMailMorosos
     *
     * @return string 
     */
    public function getTextoMailMorosos()
    {
        return $this->textoMailMorosos;
    }
}
