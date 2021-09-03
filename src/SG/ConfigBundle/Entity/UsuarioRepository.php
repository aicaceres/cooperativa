<?php
namespace SG\ConfigBundle\Entity;
use Doctrine\ORM\EntityRepository;

class UsuarioRepository extends EntityRepository
{
  public function findByMyCriteria() {
    return $this->findByMyCriteriaDQL()->getResult();
  }

  public function findByMyCriteriaDQL() {
    $query = $this->_em->createQuery('Select u from SG\ConfigBundle\Entity\Usuario u 
        where u.id>1 order by u.username' );
    return $query;
  }
  
}
?>