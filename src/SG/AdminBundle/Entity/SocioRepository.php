<?php

namespace SG\AdminBundle\Entity;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\ResultSetMapping;

class SocioRepository extends EntityRepository {

    public function findAllByTerm($term) {
        $query = $this->_em->createQuery("Select p.id,p.apellido,p.nombre,p.nroDocumento
              from SG\AdminBundle\Entity\Socio p
              where (p.nombre like '%" . $term . "%' OR p.apellido like '%" . $term . "%'
                     OR CONCAT(CONCAT(p.apellido, ', '), p.nombre) like '%" . $term . "%')
                     AND p.activo=1 order by p.apellido, p.nombre")->setMaxResults(20);
        return $query->getScalarResult();
    }

    public function findEmpleadosBySocio($id) {
        $query = $this->_em->createQueryBuilder();
        $query->select('e')
                ->from('SG\AdminBundle\Entity\Empleado', 'e')
                ->innerJoin('e.socio', 's')
                ->where("s.id = " . $id);
        return $query->getQuery()->getArrayResult();
    }

    public function filtroPorEmpresa($id) {
        $query = $this->_em->createQueryBuilder();
        $query->select('s')
                ->from('SG\AdminBundle\Entity\Socio', 's')
                ->innerJoin('s.empresas', 'e')
                ->where("e.id = " . $id);

        return $query->getQuery()->getResult();
    }

    public function datosInforme($empresaId, $socioId) {
        $query = $this->_em->createQueryBuilder();
        $query->select('m')
                ->from('SG\AdminBundle\Entity\Empleado', 'm')
                ->innerJoin('m.socio', 's');
        if ($empresaId) {
            $query->innerJoin('s.empresas', 'e')
                    ->andWhere("e.id = " . $empresaId);
        }
        if ($socioId) {
            $query->andWhere("s.id = " . $socioId);
        }
        return $query->getQuery()->getResult();
    }

    public function readAuxiliar() {
        $query = $this->_em->createQueryBuilder();
        $query->select('a')
                ->from('SG\AdminBundle\Entity\Auxiliar', 'a');
        return $query->getQuery()->getArrayResult();
    }

}