<?php

namespace SG\AdminBundle\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use SG\ConfigBundle\Controller\UtilsController;
use SG\AdminBundle\Entity\Empleado;
use SG\AdminBundle\Form\EmpleadoType;
use SG\AdminBundle\Controller\VehiculoController;

/**
 * Empleado controller.
 */
class EmpleadoController extends Controller {

    public function renderEmpleadoModalAction(Request $request) {
        $id = $request->get('id');
        $socioId = $request->get('socio');
        $em = $this->getDoctrine()->getManager();

        if ($id) {
            // EDIT
            $entity = $em->getRepository('AdminBundle:Empleado')->find($id);
            $urlAction = $this->generateUrl('empleado_update', array('id' => $id));
            $permiso = UtilsController::checkPermiso(array('empleado', 'abm', 'edit'));
            if (!$permiso) {
                // ir a la vista si no tiene permiso de edición
                $html = $this->renderView('AdminBundle:Empleado:_partial_show.html.twig',
                        array('entity' => $entity)
                );
                return new Response($html);
            }
        }
        else {
            // NEW
            $entity = new Empleado();
            $socio = $em->getRepository('AdminBundle:Socio')->find($socioId);
            $entity->setSocio($socio);
            $urlAction = $this->generateUrl('empleado_create');
            $permiso = UtilsController::checkPermiso(array('empleado', 'abm', 'new'));
        }
        if ($permiso) {
            $form = $this->createForm(new EmpleadoType(), $entity, array(
                'action' => $urlAction, 'method' => 'POST',
            ));

            $html = $this->renderView('AdminBundle:Empleado:_partial_edit.html.twig',
                    array('entity' => $entity, 'form' => $form->createView(), 'urlaction' => $urlAction)
            );
        }
        else {
            $session = $this->get('session');
            $session->getFlashBag()->add('danger', 'Usted no posee los permisos necesarios para realizar esta acción');
            $html = $this->renderView('AdminBundle::form-notification.html.twig');
        }
        return new Response($html);
    }

    public function createAction(Request $request) {
        $entity = new Empleado();
        $form = $this->createForm(new EmpleadoType(), $entity, array(
            'action' => $this->generateUrl('empleado_create'),
            'method' => 'POST',
        ));
        $form->handleRequest($request);
        $msg = 'No se pudo realizar esta operación.' . chr(13) . ' Verifique los datos ingresados.';
        $row = '';
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            try {
                $em->persist($entity);
                $em->flush();
                $msg = 'OK';
                // armar tr para reemplazar
                $row = $this->renderView('AdminBundle:Empleado:_partial_list_tr.html.twig',
                        array('empleado' => $entity)
                );
            }
            catch (\Exception $ex) {
                $msg = $ex->getMessage();
            }
        }
        $result = array('msg' => $msg, 'trhtml' => $row);
        return new Response(json_encode($result));
    }

    public function updateAction($id, Request $request) {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('AdminBundle:Empleado')->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('No existe el Empleado.');
        }
        $form = $this->createForm(new EmpleadoType(), $entity, array(
            'action' => $this->generateUrl('empleado_update', array('id' => $id)),
            'method' => 'POST',
        ));
        $form->handleRequest($request);
        $msg = 'No se pudo realizar esta operación.' . chr(13) . ' Verifique los datos ingresados.';
        if ($form->isValid()) {
            try {
                $em->persist($entity);
                $em->flush();
                $msg = 'OK';
                // armar tr para reemplazar
                $row = $this->renderView('AdminBundle:Empleado:_partial_list_tr.html.twig',
                        array('empleado' => $entity)
                );
            }
            catch (\Exception $ex) {
                $msg = $ex->getMessage();
            }
        }
        $result = array('msg' => $msg, 'id' => $entity->getId(), 'trhtml' => $row);
        return new Response(json_encode($result));
    }

    public function deleteAction($id) {
        $msg = 'OK';
        $partial = '';
        if (UtilsController::checkPermiso(array('empleado', 'abm', 'delete'))) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AdminBundle:Empleado')->find($id);
            try {
                $vehiculos = $entity->getVehiculos();
                if (count($vehiculos) > 0) {
                    foreach ($vehiculos as $vehiculo) {
                        $vehiculo->setEmpleado(NULL);
                        $em->persist($vehiculo);
                    }
                    // armar partial para reemplazar tabla vehículos
                    $partial = $this->renderView('AdminBundle:Vehiculo:_partial_list.html.twig',
                            array('entity' => $entity->getSocio())
                    );
                }

                $em->remove($entity);
                $em->flush();
            }
            catch (\Exception $ex) {
                $msg = $ex->getMessage();
            }
        }
        else {
            $msg = 'Usted no posee los permisos necesarios para realizar esta acción';
        }
        $result = array('msg' => $msg, 'partial' => $partial);
        return new Response(json_encode($result));
    }

    public function showAction($id) {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('AdminBundle:Empleado')->find($id);
        $html = $this->renderView('AdminBundle:Empleado:_partial_show.html.twig',
                array('entity' => $entity)
        );
        return new Response($html);
    }

    public function listaxsocioAction($id) {
        $em = $this->getDoctrine()->getManager();
        $lista = $em->getRepository('AdminBundle:Empleado')->findEmpleadosBySocio($id);
        return new Response(json_encode($lista));
    }

    private function setTableTr($obj) {
        $linkActions = $this->renderView('AdminBundle:Empleado:_partial_linkactions.html.twig',
                array('id' => $obj->getId(), 'vehiculos' => $obj->getVehiculos())
        );
        return array(
            $obj->getNombreCompleto(),
            $obj->getNroDocumento(),
            $obj->getCuit(),
            $obj->getTelefonos(),
            $linkActions
        );
    }

    public function informeAction(Request $request) {
        $empresaId = $request->get('empresa');
        $socioId = $request->get('socio');
        $em = $this->getDoctrine()->getManager();
        $empresas = $em->getRepository('ConfigBundle:Empresa')->findAll();
        $socios = $em->getRepository('AdminBundle:Socio')->findAll();
        $lista = $em->getRepository('AdminBundle:Empleado')->datosInforme($empresaId, $socioId);
        return $this->render('AdminBundle:Empleado:informe.html.twig', array(
                    'lista' => $lista,
                    'empresa' => $empresaId,
                    'empresas' => $empresas,
                    'socio' => $socioId,
                    'socios' => $socios
        ));
    }

    public function printInformeAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $empresaId = $request->get('empresa');
        $socioId = $request->get('socio');
        $lista = $em->getRepository('AdminBundle:Empleado')->datosInforme($empresaId, $socioId);
        if ($request->get('empresa')) {
            $empresa = $em->getRepository('ConfigBundle:Empresa')->find($empresaId);
        }
        else {
            $empresa = null;
        }
        if ($request->get('socio')) {
            $socio = $em->getRepository('AdminBundle:Socio')->find($socioId);
        }
        else {
            $socio = null;
        }

        $logo = __DIR__ . '/../../../../web/assets/img/logos/membrete.png';

        $facade = $this->get('ps_pdf.facade');
        $response = new Response();
        $this->render('AdminBundle:Empleado:informe.pdf.twig',
                array('socio' => $socio, 'empresa' => $empresa, 'lista' => $lista, 'logo' => $logo), $response);

        $xml = $response->getContent();
        $content = $facade->render($xml);

        return new Response($content, 200, array('content-type' => 'application/pdf',
            'Content-Disposition' => 'filename=ListadoEmpleados.pdf'));
    }

}