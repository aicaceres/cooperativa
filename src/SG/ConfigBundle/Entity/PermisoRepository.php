<?php
namespace SG\ConfigBundle\Entity;
use Doctrine\ORM\EntityRepository;

/**
 * PermisoRepository
 */
class PermisoRepository extends EntityRepository
{
    public function getModuloTag($modulo,$item=NULL,$tag) {
        $query = $this->getEntityManager()->createQuery("
        SELECT p.id
        FROM ConfigBundle:Permiso p
        WHERE p.modulo=:mod AND p.item = :item AND p.tag = :tag
        ")->setParameter('mod', $modulo)
        ->setParameter('item', $item)
        ->setParameter('tag', $tag);
 
        return $query->getOneOrNullResult(); 
    }
   
}