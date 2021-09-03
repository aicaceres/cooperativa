<?php

namespace SG\AdminBundle\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use SG\AdminBundle\Controller\DeudaController;
use SG\AdminBundle\Entity\CajaApertura;
use SG\AdminBundle\Form\CajaAperturaType;
use SG\AdminBundle\Form\CajaCierreType;
use SG\AdminBundle\Entity\CajaMovimiento;
use SG\AdminBundle\Entity\CajaMovimientoDetalle;
use SG\AdminBundle\Form\CajaMovimientoType;
use SG\AdminBundle\Entity\Deuda;
use SG\AdminBundle\Entity\Pago;

/**
 * Caja controller.
 */
class CajaController extends Controller {

    public function movimientoAction() {
        $em = $this->getDoctrine()->getManager();
        $printurl = null;
        if ($this->get('session')->get('printMov')) {
            $printurl = $this->generateUrl('caja_print_movimiento', array('id' => $this->get('session')->get('printMov')));
            $this->get('session')->set('printMov', null);
        }
        $apertura = $em->getRepository('AdminBundle:CajaApertura')->findOneBy(
                array('caja' => '1', 'fechaCierre' => NULL)
        );
        if (!$apertura) {
            $this->get('session')->getFlashBag()->add('danger', 'Aún no se ha realizado la apertura de caja.');
            return $this->redirect($this->generateUrl('caja_aperturacierre'));
        }

        $deleteForms = array();
        foreach ($apertura->getMovimientos() as $entity) {
            $deleteForms[$entity->getId()] = $this->createDeleteMovimientoForm($entity->getId())->createView();
        }
        return $this->render('AdminBundle:Caja:movimientos_list.html.twig', array(
                    'apertura' => $apertura,
                    'deleteForms' => $deleteForms,
                    'printurl' => $printurl
        ));
    }

    public function aperturaCierreAction() {
        $em = $this->getDoctrine()->getManager();
        $caja = $em->getRepository('AdminBundle:Caja')->find(1);
        return $this->render('AdminBundle:Caja:apertura-cierre.html.twig', array(
                    'caja' => $caja
        ));
    }

    public function aperturaAction() {
        $em = $this->getDoctrine()->getManager();
        $caja = $em->getRepository('AdminBundle:Caja')->find(1);

        $apertura = new CajaApertura();
        $apertura->setCaja($caja);
        $apertura->setFechaApertura(new \DateTime);
        $form = $this->createForm(new CajaAperturaType(), $apertura, array(
            'action' => $this->generateUrl('caja_apertura_create'),
            'method' => 'POST',
        ));

        return $this->render('AdminBundle:Caja:apertura.html.twig', array(
                    'entity' => $apertura,
                    'form' => $form->createView()
        ));
    }

    public function aperturaCreateAction(Request $request) {
        $apertura = new CajaApertura();
        $form = $this->createForm(new CajaAperturaType(), $apertura, array(
            'action' => $this->generateUrl('caja_apertura_create'),
            'method' => 'POST',
        ));
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->getConnection()->beginTransaction();
            try {
                $apertura->setFechaApertura(new \DateTime);
                $caja = $em->getRepository('AdminBundle:Caja')->find($apertura->getCaja()->getId());
                $caja->setAbierta(1);
                $em->persist($caja);

                $em->persist($apertura);
                $em->flush();
                $em->getConnection()->commit();

                $this->get('session')->getFlashBag()->add('success', 'La caja fue abierta con éxito!');
                return $this->redirect($this->generateUrl('caja_aperturacierre'));
            }
            catch (\Exception $ex) {
                $this->get('session')->getFlashBag()->add('danger', $ex->getMessage());
                $em->getConnection()->rollback();
            }
        }

        return $this->render('AdminBundle:Caja:apertura.html.twig', array(
                    'entity' => $apertura,
                    'form' => $form->createView()
        ));
    }

    public function aperturaUpdateAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();
        $apertura = $em->getRepository('AdminBundle:CajaApertura')->find($id);

        if ($request->getMethod() == 'POST') {
            $form = $this->createForm(new CajaCierreType(), $apertura, array(
                'action' => $this->generateUrl('caja_apertura_update', array('id' => $apertura->getId())),
                'method' => 'POST',
            ));
            $form->handleRequest($request);

            if ($form->isValid()) {
                $apertura->setFechaCierre(new \DateTime);
                $caja = $apertura->getCaja();
                $caja->setAbierta(false);
                $em->persist($apertura);
                $em->persist($caja);
                $em->flush();
                $this->get('session')->getFlashBag()->add('info', 'El cierre se ha realizado con éxito!');
                return $this->redirect($this->generateUrl('caja_aperturacierre'));
                return $this->render('AdminBundle:Caja:informe-cierre.html.twig', array(
                            'apertura' => $apertura
                ));
            }
        }
        return $this->render('AdminBundle:Caja:cierre.html.twig', array(
                    'entity' => $apertura,
                    'form' => $form->createView()
        ));
    }

    public function cierreAction($id) {
        $em = $this->getDoctrine()->getManager();        
        $apertura = $em->getRepository('AdminBundle:Caja')->findAperturaCaja($id);
        if ($apertura) {
            $apertura->setFechaCierre(new \DateTime);
            $form = $this->createForm(new CajaCierreType(), $apertura, array(
                'action' => $this->generateUrl('caja_apertura_update', array('id' => $apertura->getId())),
                'method' => 'POST',
            ));

            return $this->render('AdminBundle:Caja:cierre.html.twig', array(
                        'entity' => $apertura,
                        'form' => $form->createView()
            ));
        }
        else {
            $this->get('session')->getFlashBag()->add('danger', 'No se realizó el cierre');
        }       
        return $this->redirect($this->generateUrl('caja_aperturacierre'));
    }

    private function createDeleteMovimientoForm($id) {
        return $this->createFormBuilder()
                        ->setAction($this->generateUrl('caja_movimiento_delete', array('id' => $id)))
                        ->setMethod('DELETE')
                        ->getForm()
        ;
    }

    public function deleteMovimientoAction(Request $request, $id) {
        $form = $this->createDeleteMovimientoForm($id);
        $form->handleRequest($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AdminBundle:CajaMovimiento')->find($id);
            if (!$entity) {
                throw $this->createNotFoundException('No se encuentra.');
            }
            $em->remove($entity);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'El movimiento de caja fue eliminado!');
        }
        return $this->redirect($this->generateUrl('caja_movimiento'));
    }

    public function movimientoAddAction($apId, $tipo) {
        $em = $this->getDoctrine()->getManager();
        $apertura = $em->getRepository('AdminBundle:CajaApertura')->find($apId);
        $movimiento = new CajaMovimiento();
        $movimiento->setCajaApertura($apertura);
        $movimiento->setTipo($tipo);

        if ($movimiento->getTipo() == 'L') {
            $detalle = new CajaMovimientoDetalle();
            $detalle->setDescripcion('Monto a liquidar');
            $concepto = $em->getRepository('ConfigBundle:ConceptoCaja')->findOneByTipo('L');
            $detalle->setConcepto($concepto);
            $movimiento->addDetalle($detalle);
            $html = 'AdminBundle:Caja:movimiento-liquidacion.html.twig';
            $form = $this->createForm(new CajaMovimientoType(), $movimiento, array(
                'action' => $this->generateUrl('caja_liquidacion_create'),
                'method' => 'POST',
            ));
        }
        else {
            $html = 'AdminBundle:Caja:movimiento.html.twig';
            $form = $this->createForm(new CajaMovimientoType(), $movimiento, array(
                'action' => $this->generateUrl('caja_movimiento_create'),
                'method' => 'POST',
            ));
        }

        return $this->render($html, array(
                    'entity' => $movimiento,
                    'form' => $form->createView()
        ));
    }

    public function egresoAddAction($apId) {
        die;

        $em = $this->getDoctrine()->getManager();
        $apertura = $em->getRepository('AdminBundle:CajaApertura')->find($apId);
        $egreso = new CajaMovimiento();
        $egreso->setCajaApertura($apertura);
        $egreso->setTipo('E');

        $form = $this->createForm(new CajaMovimientoType(), $egreso, array(
            'action' => $this->generateUrl('caja_movimiento_create'),
            'method' => 'POST',
        ));

        return $this->render('AdminBundle:Caja:egreso.html.twig', array(
                    'entity' => $egreso,
                    'form' => $form->createView()
        ));
    }

    public function movimientoCreateAction(Request $request) {
        $data = $this->getRequest()->get('sg_adminbundle_cajamovimiento');
        $movimiento = new CajaMovimiento();
        $movimiento->setTipo($data['tipo']);

        $form = $this->createForm(new CajaMovimientoType(), $movimiento, array(
            'action' => $this->generateUrl('caja_movimiento_create'),
            'method' => 'POST'
        ));
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->getConnection()->beginTransaction();
            try {
                $movimiento->setFecha(new \DateTime);
                if ($movimiento->getSocio()) {
                    $movimiento->setResponsablePago($movimiento->getSocio()->getNombreCompleto());
                    $montoPago = $movimiento->getPago();
                    foreach ($movimiento->getDetalles() as $item) {
                        if (is_null($item->getDeuda())) {
                            // crear item deuda
                            $deuda = new Deuda();
                            $deuda->setSocio($movimiento->getSocio());
                            $deuda->setConcepto($item->getConcepto());
                            $deuda->setDescripcion($item->getDescripcion());
                            $deuda->setFechaVto(new \DateTime);
                            $deuda->setMonto($item->getImporte());
                            $item->setDeuda($deuda);
                        }
                        else {
                            $deuda = $em->getRepository('AdminBundle:Deuda')->find($item->getDeuda()->getId());
                            // calcular si se esta pagando mora.
                            $deuda->setMora($item->getImporte() - $deuda->getMonto());
                        }
                        $pago = new Pago();
                        $pago->setDeuda($deuda);
                        $pago->setFecha(new \DateTime);
                        $pago->setCajaMovimiento($movimiento);
                        $pago->setCajaMovimientoDetalle($item);

                        if ($montoPago >= $item->getImporte()) {
                            // cubre el pago
                            $deuda->setCancelada(true);
                            $deuda->setFechaCancelacion(new \DateTime);
                            $pago->setImporte($item->getImporte());
                            $montoPago -= $item->getImporte();
                        }
                        else {
                            // queda saldo
                            $pago->setImporte($montoPago);
                            $montoPago = 0;
                        }
                        // registrar el pago
                        $em->persist($deuda);
                        $em->persist($pago);
                    }
                }
                $em->persist($movimiento);
                $em->flush();
                $em->getConnection()->commit();

                $this->get('session')->getFlashBag()->add('success', 'El movimiento fue guardado con éxito!');
                $this->get('session')->set('printMov', $movimiento->getId());

                return $this->redirect($this->generateUrl('caja_movimiento'));
            }
            catch (\Exception $ex) {
                $this->get('session')->getFlashBag()->add('danger', $ex->getMessage());
                $em->getConnection()->rollback();
            }
        }

        return $this->render('AdminBundle:Caja:movimiento.html.twig', array(
                    'entity' => $movimiento,
                    'form' => $form->createView()
        ));
    }

    public function liquidacionCreateAction(Request $request) {
        $data = $this->getRequest()->get('sg_adminbundle_cajamovimiento');
        $movimiento = new CajaMovimiento();
        $movimiento->setTipo($data['tipo']);

        $form = $this->createForm(new CajaMovimientoType(), $movimiento, array(
            'action' => $this->generateUrl('caja_liquidacion_create'),
            'method' => 'POST'
        ));
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->getConnection()->beginTransaction();
            try {
                $movimiento->setFecha(new \DateTime);
                $movimiento->setResponsablePago('Liquidación Socio: ' . $movimiento->getSocio()->getNombreCompleto());
                $montoPago = $movimiento->getPago();
                // generar deuda para item liquidación
                $liq = $movimiento->getDetalleLiquidacion();
                $deudaLiq = new Deuda();
                $deudaLiq->setSocio($movimiento->getSocio());
                $deudaLiq->setConcepto($liq->getConcepto());
                $deudaLiq->setDescripcion($liq->getDescripcion());
                $deudaLiq->setFechaVto(new \DateTime);
                $deudaLiq->setMonto($liq->getImporte());
                $em->persist($deudaLiq);
                $montoLiq = $liq->getImporte();
                foreach ($movimiento->getDetalles() as $item) {
                    if ($item->getConcepto()->getTipo() == 'L') {
                        // LIQUIDACION
                        $item->setDeuda($deudaLiq);
                        // item liquidacion
                        $itemLiq = $item;
                        continue;
                    }
                    else {
                        // OTROS ITEMS
                        $importePago = $item->getImporte();
                        $deuda = $em->getRepository('AdminBundle:Deuda')->find($item->getDeuda()->getId());
                        // calcular si se esta pagando mora.
                        $deuda->setMora(DeudaController::getMontoMora($deuda));
                        // generar el pago
                        $pago = new Pago();
                        $pago->setDeuda($deuda);
                        $pago->setFecha(new \DateTime);
                        $pago->setCajaMovimiento($movimiento);
                        $pago->setCajaMovimientoDetalle($item);
                        if ($montoLiq >= $importePago) {
                            // si se cubre la deuda cancelarla
                            if ($deuda->getSaldo() <= $importePago) {
                                $deuda->setCancelada(true);
                                $deuda->setFechaCancelacion(new \DateTime);
                            }
                            else {
                                $deuda->setMora(0);
                            }
                            // registrar importe de pago
                            $pago->setImporte($importePago);
                            $montoLiq -= $importePago;
                        }
                        else {
                            // queda saldo
                            $pago->setImporte($montoLiq);
                            $montoLiq = 0;
                        }
                        // registrar el pago
                        $em->persist($deuda);
                        $em->persist($pago);
                    }
                }
                $saldo = $montoLiq - $montoPago;
                if ($saldo == 0) {
                    $deudaLiq->setCancelada(true);
                    $deudaLiq->setFechaCancelacion(new \DateTime);
                    $em->persist($deudaLiq);
                }
                else {
                    $itemLiq->setSaldo($saldo);
                }
                // Generar el pago para la deuda liquidacion
                $pago = new Pago();
                $pago->setDeuda($deudaLiq);
                $pago->setFecha(new \DateTime);
                $pago->setCajaMovimiento($movimiento);
                $pago->setCajaMovimientoDetalle($liq);
                $pago->setImporte($montoPago);
                $em->persist($pago);

                $em->persist($movimiento);
                $em->flush();
                $em->getConnection()->commit();

                $this->get('session')->getFlashBag()->add('success', 'El movimiento fue guardado con éxito!');
                $this->get('session')->set('printMov', $movimiento->getId());

                return $this->redirect($this->generateUrl('caja_movimiento'));
            }
            catch (\Exception $ex) {
                $this->get('session')->getFlashBag()->add('danger', $ex->getMessage());
                $em->getConnection()->rollback();
            }
        }

        return $this->render('AdminBundle:Caja:movimiento.html.twig', array(
                    'entity' => $movimiento,
                    'form' => $form->createView()
        ));
    }

    /*
     * Obtener datos del detalle de un ingreso/gasto
     */

    public function getDetalleMovimientoAction(Request $request) {
        $id = $request->get('id');
        $tipo = $request->get('tipo');
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('AdminBundle:CajaMovimiento')->find($id);

        $partial = $this->renderView('AdminBundle:Caja:_partial_detalle_movimiento.html.twig', array(
            'entity' => $entity, 'tipo' => $tipo));
        return new Response($partial);
    }

    public function informeCierreAction($id) {
        $em = $this->getDoctrine()->getManager();
        $apertura = $em->getRepository('AdminBundle:CajaApertura')->find($id);
        $movimientos = $em->getRepository('AdminBundle:Caja')->findMovimientosCajaApertura($apertura->getId());

        return $this->render('AdminBundle:Caja:informe-cierre.html.twig', array(
                    'apertura' => $apertura, 'movimientos' => $movimientos
        ));
    }

    public function printMovimientoAction($id) {
        $em = $this->getDoctrine()->getManager();
        $movimiento = $em->getRepository('AdminBundle:CajaMovimiento')->find($id);
        $logo = __DIR__ . '/../../../../web/assets/img/logos/membrete.png';

        $facade = $this->get('ps_pdf.facade');
        $response = new Response();
        $this->render('AdminBundle:Caja:printMovimiento.pdf.twig',
                array('movimiento' => $movimiento, 'logo' => $logo), $response);

        $xml = $response->getContent();
        $content = $facade->render($xml);

        return new Response($content, 200, array('content-type' => 'application/pdf',
            'Content-Disposition' => 'filename=movimiento.pdf'));
    }

    public function printCierreAction($id) {
        $em = $this->getDoctrine()->getManager();
        $apertura = $em->getRepository('AdminBundle:CajaApertura')->find($id);
        $movimientos = $em->getRepository('AdminBundle:Caja')->findMovimientosCajaApertura($apertura->getId());
        $logo = __DIR__ . '/../../../../web/assets/img/logos/membrete.png';

        $facade = $this->get('ps_pdf.facade');
        $response = new Response();
        $this->render('AdminBundle:Caja:printCierre.pdf.twig',
                array('apertura' => $apertura, 'movimientos' => $movimientos, 'logo' => $logo), $response);

        $xml = $response->getContent();
        $content = $facade->render($xml);

        return new Response($content, 200, array('content-type' => 'application/pdf',
            'Content-Disposition' => 'filename=cierre.pdf'));
    }

    public function informesAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $caja = $em->getRepository('AdminBundle:Caja')->find(1);
        $conceptos = $em->getRepository('ConfigBundle:ConceptoCaja')->findAll();
        $hoy = new \DateTime;
        $desde = is_null($request->get('fecha_desde')) ? $hoy->format('d-m-Y') : $request->get('fecha_desde');
        $hasta = is_null($request->get('fecha_hasta')) ? $hoy->format('d-m-Y') : $request->get('fecha_hasta');
        $startDate = new \DateTime(date('d-m-Y', strtotime($desde)));
        $endDate = new \DateTime(date('d-m-Y', strtotime($hasta)));
        $criterio = array('desde' => $desde, 'hasta' => $hasta,
            'concepto_caja' => $request->get('concepto_caja'));

        $movimientos = $em->getRepository('AdminBundle:Caja')->findMovimientosByCriterio($criterio);

        return $this->render('AdminBundle:Caja:informes.html.twig', array(
                    'caja' => $caja, 'conceptos' => $conceptos, 'movimientos' => $movimientos, 'criterio' => $criterio,
                    'startDate' => $startDate->format('d/m/Y'), 'endDate' => $endDate->format('d/m/Y')
        ));
    }

    public function printInformeAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $caja = $em->getRepository('AdminBundle:Caja')->find(1);
        $hoy = new \DateTime;
        $desde = is_null($request->get('fecha_desde')) ? $hoy->format('d-m-Y') : $request->get('fecha_desde');
        $hasta = is_null($request->get('fecha_hasta')) ? $hoy->format('d-m-Y') : $request->get('fecha_hasta');
        $criterio = array('desde' => $desde, 'hasta' => $hasta,
            'concepto_caja' => $request->get('concepto_caja'));
        if ($request->get('concepto_caja')) {
            $concepto = $em->getRepository('ConfigBundle:ConceptoCaja')->find($request->get('concepto_caja'));
        }
        else {
            $concepto = null;
        }
        $movimientos = $em->getRepository('AdminBundle:Caja')->findMovimientosByCriterio($criterio);

        $logo = __DIR__ . '/../../../../web/assets/img/logos/membrete.png';

        $facade = $this->get('ps_pdf.facade');
        $response = new Response();
        $this->render('AdminBundle:Caja:printInforme.pdf.twig',
                array('caja' => $caja, 'movimientos' => $movimientos, 'concepto' => $concepto,
                    'criterio' => $criterio, 'logo' => $logo), $response);

        $xml = $response->getContent();
        $content = $facade->render($xml);

        return new Response($content, 200, array('content-type' => 'application/pdf',
            'Content-Disposition' => 'filename=informeCaja.pdf'));
    }

}