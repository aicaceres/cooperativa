<?php
namespace SG\ConfigBundle\Entity;
use Doctrine\ORM\EntityRepository;

/**
 * ConceptoCajaRepository
 */
class ConceptoCajaRepository extends EntityRepository
{
    public function findConceptosByTipo($tipo) {

    $query = $this->getEntityManager()->createQuery("
            SELECT cc
            FROM ConfigBundle:ConceptoCaja cc
            WHERE cc.tipo = :tipo
        ")->setParameter('tipo', $tipo);

        return $query->getArrayResult();
  }
}