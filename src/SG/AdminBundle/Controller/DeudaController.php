<?php

namespace SG\AdminBundle\Controller;
#use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use SG\ConfigBundle\Controller\UtilsController;
use SG\AdminBundle\Entity\Deuda;
use SG\AdminBundle\Form\DeudaType;
use SG\AdminBundle\Form\CuotaType;

/**
 * Deuda controller.
 */
class DeudaController extends Controller {

    public function ctacteAction($id) {
        $em = $this->getDoctrine()->getManager();
        $socio = $em->getRepository('AdminBundle:Socio')->find($id);
        if (!$socio) {
            $socio = null;
        }

        return $this->render('AdminBundle:Socio:ctacte.html.twig', array('socio' => $socio));
    }

    public function getDatosCtaCteAction() {
        $id = $this->getRequest()->get('socioId');
        $vencido = $this->getRequest()->get('estado');
        $em = $this->getDoctrine()->getManager();
        //$param = $em->getRepository('ConfigBundle:Configuracion')->find(1);
        $socio = $em->getRepository('AdminBundle:Socio')->find($id);
        //$hoy = new \DateTime(date('d-m-Y'));
        $deleteForms = array();

        foreach ($socio->getDeudas() as $deuda) {
            $deleteForms[$deuda->getId()] = $this->createDeleteDeudaForm($deuda->getId())->createView();
            $deuda->setMora($this->getMora($deuda));
            /* if ($deuda->getFechaVto() < $hoy) {
              $dias = UtilsController::diasTranscurridos($deuda->getFechaVto()->format('Y-m-d'), date('Y-m-d'));
              //calcular mora
              if ($param->getTipoRecargoCuota() == 'P') {
              $recargo = ($deuda->getSaldo() * ($param->getMontoRecargoCuota() / 100)) * $dias;
              }
              else {
              $recargo = $param->getMontoRecargoCuota() * $dias;
              }
              $deuda->setMora($recargo);
              } */
        }

        $partial = $this->renderView('AdminBundle:Socio:_partial_datosCtaCte.html.twig', array('socio' => $socio, 'deleteForms' => $deleteForms, 'vencido' => $vencido));
        return new Response(json_encode($partial));
    }

    public function newDeudaAction() {
        $tipo = $this->getRequest()->get('tipo');
        $em = $this->getDoctrine()->getManager();
        $socio = $em->getRepository('AdminBundle:Socio')->find($this->getRequest()->get('socioId'));
        $parametros = $em->getRepository('ConfigBundle:Configuracion')->find(1);
        $fechaVto = strtotime($parametros->getDiaVtoCuota() . '-' . date('m-Y'));
        $entity = new Deuda();
        $entity->setSocio($socio);
        $entity->setFechaVto(new \DateTime(date('d-m-Y', $fechaVto)));

        if ($tipo == "deuda") {
            $form = $this->createCreateDeudaForm($entity);
        }
        else {
            /* $concepto = $em->getRepository('ConfigBundle:ConceptoCaja')->findOneByDeSistema(1);
              $entity->setConcepto($concepto);
              $entity->setMonto($concepto->getMonto()); */
            $form = $this->createCreateCuotaForm($entity);
            $form->get('cantidadCuotas')->setData('1');
        }

        $partial = $this->renderView('AdminBundle:Socio:_partial_newDeuda.html.twig', array(
            'entity' => $entity,
            'tipo' => $tipo,
            'form' => $form->createView()
        ));
        return new Response(json_encode($partial));
    }

    private function createCreateDeudaForm(Deuda $entity) {
        $form = $this->createForm(new DeudaType(), $entity, array(
            'action' => $this->generateUrl('socio_create_deuda'),
            'method' => 'POST',
        ));
        return $form;
    }

    private function createCreateCuotaForm(Deuda $entity) {
        $form = $this->createForm(new CuotaType(), $entity, array(
            'action' => $this->generateUrl('socio_create_deuda'),
            'method' => 'POST',
        ));
        return $form;
    }

    public function createDeudaAction(Request $request) {
        $tipo = $request->get('tipo');
        $data = $request->get('sg_adminbundle_deuda');
        $deuda = new Deuda();
        if ($tipo == 'deuda')
            $form = $this->createCreateDeudaForm($deuda);
        else
            $form = $this->createCreateCuotaForm($deuda);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->getConnection()->beginTransaction();
            try {
                if ($tipo == 'cuota') {
                    $meses = array('ENE', 'FEB', 'MAR', 'ABR', 'MAY', 'JUN', 'JUL', 'AGO', 'SEP', 'OCT', 'NOV', 'DIC');
                    if ($data['cantidadCuotas'] > 1) {
                        // Una o varias cuotas mensuales
                        $fechaVencimiento = strtotime($deuda->getFechaVto()->format('d-m-Y'));
                        for ($i = 1; $i <= $data['cantidadCuotas']; $i++) {
                            $cuota = new Deuda();
                            $cuota->setSocio($deuda->getSocio());
                            $cuota->setConcepto($deuda->getConcepto());
                            $cuota->setMonto($deuda->getMonto());
                            $cuota->setFechaVto(new \DateTime(date('d-m-Y', $fechaVencimiento)));
                            $cuota->setDetalle('CUOTA ' . $meses[$cuota->getFechaVto()->format('n') - 1] . '/' . $cuota->getFechaVto()->format('Y'));
                            $cuota->setDescripcion($deuda->getDescripcion());
                            $cuota->setCreated($deuda->getCreated());
                            $cuota->setCreatedBy($deuda->getCreatedBy());
                            $em->persist($cuota);
                            $em->flush();
                            $fechaVencimiento = strtotime('+1 month', $fechaVencimiento);
                        }
                    }
                    else {
                        if (isset($data['anual'])) {
                            $deuda->setDescripcion('Anual ' . $deuda->getDescripcion());
                        }
                        else {
                            $deuda->setDetalle('CUOTA ' . $meses[$deuda->getFechaVto()->format('n') - 1] . '/' . $deuda->getFechaVto()->format('Y'));
                        }
                        $em->persist($deuda);
                        $em->flush();
                    }
                }
                else {
                    //guardar 1 registro de dueda
                    $em->persist($deuda);
                    $em->flush();
                }
                $em->getConnection()->commit();
                return new Response(json_encode('OK'));
            }
            catch (\PDOException $e) {
                $em->getConnection()->rollback();
                return new Response(json_encode($e));
            }
        }
        return new Response(json_encode('ERROR'));
    }

    private function createDeleteDeudaForm($id) {
        return $this->createFormBuilder()
                        ->setAction($this->generateUrl('socio_delete_deuda', array('id' => $id)))
                        ->setMethod('POST')
                        ->getForm()
        ;
    }

    public function deleteDeudaAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('ConfigBundle:Usuario')->find($this->get('security.context')->getToken()->getUser()->getId());
        $perfil = $user->getPerfil();
        $permisoId = $em->getRepository('ConfigBundle:Permiso')->getModuloTag('socio', 'ctacte', 'delete');
        $permiso = $em->getRepository('ConfigBundle:Permiso')->find($permisoId['id']);
        $msg = 'No pudo realizarse el borrado!';
        if ($perfil->getPermisos()->contains($permiso)) {
            $form = $this->createDeleteDeudaForm($id);
            $form->handleRequest($request);
            if ($form->isValid()) {
                $entity = $em->getRepository('AdminBundle:Deuda')->find($id);
                if (!$entity) {
                    throw $this->createNotFoundException('No se encuentra el Item.');
                }
                //Borro
                $em->remove($entity);
                $em->flush();
                $msg = 'OK';
            }
        }
        else {
            $session = $this->get('session');
            $session->getFlashBag()->add('danger', 'Usted no posee los permisos necesarios para realizar esta acción');
        }

        return new Response($msg);
        //return $this->redirect($this->generateUrl('socio_ctacte'));
    }

    public function getDeudaAction() {
        $socioId = $this->getRequest()->get('socioId');
        $tipo = $this->getRequest()->get('tipo');
        $em = $this->getDoctrine()->getManager();
        $socio = $em->getRepository('AdminBundle:Socio')->find($socioId);
        //$param = $em->getRepository('ConfigBundle:Configuracion')->find(1);
        //$hoy = new \DateTime(date('d-m-Y'));
        foreach ($socio->getListaDeudas() as $deuda) {
            $deuda->setMora($this->getMora($deuda));

            /* if ($deuda->getFechaVto() < $hoy) {
              $dias = UtilsController::diasTranscurridos($deuda->getFechaVto()->format('Y-m-d'), date('Y-m-d'));
              //calcular mora
              if ($param->getTipoRecargoCuota() == 'P') {
              $recargo = ($deuda->getSaldo() * ($param->getMontoRecargoCuota() / 100)) * $dias;
              }
              else {
              $recargo = $param->getMontoRecargoCuota() * $dias;
              }
              $deuda->setMora($recargo);
              } */
        }
        if ($tipo == 'L') {
            $partial = $this->renderView('AdminBundle:Socio:_partial_socio_liqdeuda.html.twig', array('socio' => $socio));
        }
        else {
            $partial = $this->renderView('AdminBundle:Socio:_partial_socio_deuda.html.twig', array('socio' => $socio));
        }
        return new Response(json_encode($partial));
    }

    public function printEstadoDeudaAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();
        $socio = $em->getRepository('AdminBundle:Socio')->find($id);
        $vencido = $request->get('estado');

        //$param = $em->getRepository('ConfigBundle:Configuracion')->find(1);
        //$hoy = new \DateTime(date('d-m-Y'));
        foreach ($socio->getDeudas() as $deuda) {
            $deuda->setMora($this->getMora($deuda));
            /* if (count($deuda->getPagos()) == 0 && $deuda->getFechaVto() < $hoy) {
              $dias = UtilsController::diasTranscurridos($deuda->getFechaVto()->format('Y-m-d'), date('Y-m-d'));
              //calcular mora
              if ($param->getTipoRecargoCuota() == 'P') {
              $recargo = ($deuda->getMonto() * ($param->getMontoRecargoCuota() / 100)) * $dias;
              }
              else {
              $recargo = $param->getMontoRecargoCuota() * $dias;
              }
              $deuda->setMora($recargo);
              } */
        }
        $logo = __DIR__ . '/../../../../web/assets/img/logos/membrete.png';

        $facade = $this->get('ps_pdf.facade');
        $response = new Response();
        $this->render('AdminBundle:Socio:estado-deuda.pdf.twig',
                array('socio' => $socio, 'vencido' => $vencido, 'logo' => $logo), $response);

        $xml = $response->getContent();
        $content = $facade->render($xml);

        return new Response($content, 200, array('content-type' => 'application/pdf',
            'Content-Disposition' => 'filename=estadoDeuda.pdf'));
    }

    public function exportEstadoDeudaAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();
        $socio = $em->getRepository('AdminBundle:Socio')->find($id);
        //$param = $em->getRepository('ConfigBundle:Configuracion')->find(1);
        $vencido = $request->get('estado');
        //$hoy = new \DateTime(date('d-m-Y'));
        foreach ($socio->getDeudas() as $deuda) {
            $deuda->setMora($this->getMora($deuda));
            /* if (count($deuda->getPagos()) == 0 && $deuda->getFechaVto() < $hoy) {
              $dias = UtilsController::diasTranscurridos($deuda->getFechaVto()->format('Y-m-d'), date('Y-m-d'));
              //calcular mora
              if ($param->getTipoRecargoCuota() == 'P') {
              $recargo = ($deuda->getMonto() * ($param->getMontoRecargoCuota() / 100)) * $dias;
              }
              else {
              $recargo = $param->getMontoRecargoCuota() * $dias;
              }
              $deuda->setMora($recargo);
              } */
        }
        $partial = $this->renderView('AdminBundle:Socio:estado-deuda-xls.html.twig',
                array('socio' => $socio, 'vencido' => $vencido));

        $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $socio->getNombreCompleto())));
        $fileName = 'Estado_Deuda_' . $slug . '_' . $hoy->format('dmY_Hi');
        $response = new Response();
        $response->setStatusCode(200);
        $response->headers->set('Content-Type', 'application/vnd.ms-excel; charset=UTF-8');
        $response->headers->set('Content-Disposition', 'filename="' . $fileName . '.xls"');
        $response->setContent($partial);
        return $response;



        $logo = __DIR__ . '/../../../../web/assets/img/logos/membrete.png';

        $facade = $this->get('ps_pdf.facade');
        $response = new Response();
        $this->render('AdminBundle:Socio:estado-deuda.pdf.twig',
                array('socio' => $socio, 'logo' => $logo), $response);

        $xml = $response->getContent();
        $content = $facade->render($xml);

        return new Response($content, 200, array('content-type' => 'application/pdf',
            'Content-Disposition' => 'filename=estadoDeuda.pdf'));
    }

    public function deudaShowAction($id, $mora) {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('AdminBundle:Deuda')->find($id);
        $html = $this->renderView('AdminBundle:Socio:deuda-show.html.twig',
                array('entity' => $entity, 'mora' => $mora)
        );
        return new Response($html);
    }

    private function getMora($deuda) {
        $em = $this->getDoctrine()->getManager();
        $param = $em->getRepository('ConfigBundle:Configuracion')->find(1);
        $hoy = new \DateTime(date('d-m-Y'));
        if ($deuda->getFechaVto() < $hoy) {
            $dias = UtilsController::diasTranscurridos($deuda->getFechaVto()->format('Y-m-d'), date('Y-m-d'));
            //calcular mora
            if ($param->getTipoRecargoCuota() == 'P') {
                $recargo = ($deuda->getSaldo() * ($param->getMontoRecargoCuota() / 100)) * $dias;
            }
            else {
                $recargo = $param->getMontoRecargoCuota() * $dias;
            }
            $deuda->setMora($deuda->getMora() + $recargo);
        }
        return $deuda->getMora();
    }

    public static function getMontoMora($deuda) {
        return $deuda->getMora($deuda);
    }

}