<?php

namespace SG\AdminBundle\Entity;
use Doctrine\ORM\EntityRepository;
use SG\ConfigBundle\Controller\UtilsController;

class CajaRepository extends EntityRepository {

    public function findAperturaCaja($caja) {
        $query = $this->_em->createQueryBuilder();
        $query->select('a')
                ->from('SG\AdminBundle\Entity\CajaApertura', 'a')
                ->innerJoin('a.caja', 'c')
                ->where('c.id=' . $caja)
                ->andWhere('a.fechaCierre is null')
                ->setMaxResults(1);
        return $query->getQuery()->getOneOrNullResult();
    }

    public function findMovimientosCajaApertura($apId) {
        $query = $this->_em->createQueryBuilder();
        $query->select('c')
                ->from('SG\AdminBundle\Entity\CajaMovimiento', 'c')
                ->innerJoin('c.cajaApertura', 'a')
                ->where('a.id=' . $apId);
        return $query->getQuery()->getResult();
    }

    public function findMovimientosByCriterio($criterio) {
        $query = $this->_em->createQueryBuilder();
        $desde = UtilsController::toAnsiDate($criterio['desde']) . " 00:00";
        $hasta = UtilsController::toAnsiDate($criterio['hasta']) . " 23:59";
        $query->select('d')
                ->from('SG\AdminBundle\Entity\CajaMovimientoDetalle', 'd')
                ->innerJoin('d.cajaMovimiento', 'c')
                ->where("c.fecha between '" . $desde . "' and '" . $hasta . "'");
        if ($criterio['concepto_caja']) {
            $query->andWhere('d.concepto=' . $criterio['concepto_caja']);
        }
        return $query->getQuery()->getResult();
    }

    public function findMovimientosCaja($ap = null) {
        $gastos = $this->_em->createQueryBuilder('g')
                ->select('g.id,1 tipo,g.fecha, g.descripcion, g.total, u.username')
                ->from('SG\AdminBundle\Entity\CajaGasto', 'g')
                ->innerJoin('g.cajaApertura', 'a')
                ->innerJoin('g.createdBy', 'u');
        if ($ap) {
            $gastos->where('a.id=:ap')
                    ->setParameter('ap', $ap);
        }
        $ingresos = $this->_em->createQueryBuilder('i')
                ->select('i.id,2 tipo,i.fecha, i.responsablePago descripcion, i.pago total, u.username')
                ->from('SG\AdminBundle\Entity\CajaIngreso', 'i')
                ->innerJoin('i.cajaApertura', 'a')
                ->innerJoin('i.createdBy', 'u');
        if ($ap) {
            $ingresos->where('a.id=:ap')
                    ->setParameter('ap', $ap);
        }
        $datos = array_merge($gastos->getQuery()->getArrayResult(), $ingresos->getQuery()->getArrayResult());
        $ord = usort($datos, function($a1, $a2) {
            $value1 = strtotime($a1['fecha']->format('Y-m-d H:i'));
            $value2 = strtotime($a2['fecha']->format('Y-m-d H:i'));
            return $value1 - $value2;
        });

        return $datos;
    }

    public function getSaldosCajaByNinio($ninioId) {
        $query = $this->_em->createQueryBuilder();
        $query->select('d')
                ->from('SG\AdminBundle\Entity\CajaIngresoDetalle', 'd')
                ->where('d.ninio=' . $ninioId);
        return $query->getQuery()->getResult();
    }

    public function getDistinctNinioIngreso($id) {
        $query = $this->_em->createQueryBuilder();
        $query->select("distinct n.id, n.nombre, n.apellido, '' sala, '' turno, n.nroDocumento ")
                ->from('SG\AdminBundle\Entity\CajaIngreso', 'c')
                ->innerJoin('c.detalles', 'd')
                ->innerJoin('d.ninio', 'n')
                ->where('c.id=' . $id);
        return $query->getQuery()->getResult();
    }

    public function getSaldoInicial($desde, $caja) {
        $query = $this->_em->createQueryBuilder();
        $gastos = $this->_em->createQueryBuilder('g')
                ->select('sum(g.total) total')
                ->from('SG\AdminBundle\Entity\CajaGasto', 'g')
                ->innerJoin('g.cajaApertura', 'a')
                ->where('a.caja=' . $caja->getId());
        $ingresos = $this->_em->createQueryBuilder('i')
                ->select('SUM( i.pago) total')
                ->from('SG\AdminBundle\Entity\CajaIngreso', 'i')
                ->innerJoin('i.cajaApertura', 'a')
                ->where('a.caja=' . $caja->getId());
        if ($desde) {
            $gastos->andWhere("g.fecha <'" . UtilsController::toAnsiDate($desde) . " 00:00'");
            $ingresos->andWhere("i.fecha <'" . UtilsController::toAnsiDate($desde) . " 00:00'");
        }
        return $ingresos->getQuery()->getSingleScalarResult() - $gastos->getQuery()->getSingleScalarResult();
    }

    public function findMovimientosInformeCaja($desde, $hasta, $caja) {

        $gastos = $this->_em->createQueryBuilder('g')
                ->select('g.id,1 tipo,g.fecha, g.descripcion, g.total, u.username')
                ->from('SG\AdminBundle\Entity\CajaGasto', 'g')
                ->innerJoin('g.cajaApertura', 'a')
                ->innerJoin('g.createdBy', 'u');

        $ingresos = $this->_em->createQueryBuilder('i')
                ->select('i.id,2 tipo,i.fecha, i.responsablePago descripcion, i.pago total, u.username')
                ->from('SG\AdminBundle\Entity\CajaIngreso', 'i')
                ->innerJoin('i.cajaApertura', 'a')
                ->innerJoin('i.createdBy', 'u');
        if ($desde) {
            $gastos->andWhere("g.fecha >='" . UtilsController::toAnsiDate($desde) . " 00:00'");
            $ingresos->andWhere("i.fecha >='" . UtilsController::toAnsiDate($desde) . " 00:00'");
        }
        if ($hasta) {
            $gastos->andWhere("g.fecha <='" . UtilsController::toAnsiDate($hasta) . " 23:59'");
            $ingresos->andWhere("i.fecha <='" . UtilsController::toAnsiDate($hasta) . " 23:59'");
        }
        $datos = array_merge($gastos->getQuery()->getArrayResult(), $ingresos->getQuery()->getArrayResult());
        $ord = usort($datos, function($a1, $a2) {
            $value1 = strtotime($a1['fecha']->format('Y-m-d H:i'));
            $value2 = strtotime($a2['fecha']->format('Y-m-d H:i'));
            return $value1 - $value2;
        });

        return $datos;
    }

    public function findMovimientosAnual($caja) {
        $gastos = $this->_em->createQueryBuilder('g')
                ->select('g.id,1 tipo,g.fecha, g.descripcion, g.total, u.username')
                ->from('SG\AdminBundle\Entity\CajaGasto', 'g')
                ->innerJoin('g.cajaApertura', 'a')
                ->innerJoin('g.createdBy', 'u');

        $ingresos = $this->_em->createQueryBuilder('i')
                ->select('i.id,2 tipo,i.fecha, i.responsablePago descripcion, i.pago total, u.username')
                ->from('SG\AdminBundle\Entity\CajaIngreso', 'i')
                ->innerJoin('i.cajaApertura', 'a')
                ->innerJoin('i.createdBy', 'u');
        $datos = array_merge($gastos->getQuery()->getArrayResult(), $ingresos->getQuery()->getArrayResult());
        $ord = usort($datos, function($a1, $a2) {
            $value1 = strtotime($a1['fecha']->format('Y-m-d H:i'));
            $value2 = strtotime($a2['fecha']->format('Y-m-d H:i'));
            return $value1 - $value2;
        });

        return $datos;
    }

    public function getSaldoInicialAnual($anio, $caja) {
        $inicio = $anio . '-12-31 23:59';

        $query = $this->_em->createQueryBuilder();
        $gastos = $this->_em->createQueryBuilder('g')
                ->select('sum(g.total) total')
                ->from('SG\AdminBundle\Entity\CajaGasto', 'g')
                ->innerJoin('g.cajaApertura', 'a')
                ->where('a.caja=' . $caja->getId());
        $ingresos = $this->_em->createQueryBuilder('i')
                ->select('SUM( i.pago) total')
                ->from('SG\AdminBundle\Entity\CajaIngreso', 'i')
                ->innerJoin('i.cajaApertura', 'a')
                ->where('a.caja=' . $caja->getId());
        if ($desde) {
            $gastos->andWhere("g.fecha <'" . UtilsController::toAnsiDate($desde) . " 00:00'");
            $ingresos->andWhere("i.fecha <'" . UtilsController::toAnsiDate($desde) . " 00:00'");
        }
        return $ingresos->getQuery()->getSingleScalarResult() - $gastos->getQuery()->getSingleScalarResult();
    }

    public function getLiquidacionesBySocio($id) {
        $query = $this->_em->createQueryBuilder();
        $query->select('c')
                ->from('SG\AdminBundle\Entity\CajaMovimiento', 'c')
                ->innerJoin('c.socio', 's')
                ->where("s.id = " . $id)
                ->andWhere("c.tipo='L'")
                ->orderBy('c.fecha');
        return $query->getQuery()->getResult();
    }

}
?>