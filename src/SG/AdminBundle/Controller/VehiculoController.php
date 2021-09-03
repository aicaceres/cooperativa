<?php

namespace SG\AdminBundle\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use SG\ConfigBundle\Controller\UtilsController;
use SG\AdminBundle\Entity\Vehiculo;
use SG\AdminBundle\Form\VehiculoType;

/**
 * Vehiculo controller.
 */
class VehiculoController extends Controller {

    public function renderVehiculoModalAction(Request $request) {
        $id = $request->get('id');
        $socioId = $request->get('socio');
        $em = $this->getDoctrine()->getManager();

        if ($id) {
            // EDIT
            $entity = $em->getRepository('AdminBundle:Vehiculo')->find($id);
            $urlAction = $this->generateUrl('vehiculo_update', array('id' => $id));
            $permiso = UtilsController::checkPermiso(array('vehiculo', 'abm', 'edit'));
            if (!$permiso) {
                // ir a la vista si no tiene permiso de edición
                $html = $this->renderView('AdminBundle:Vehiculo:_partial_show.html.twig',
                        array('entity' => $entity)
                );
                return new Response($html);
            }
        }
        else {
            // NEW
            $entity = new Vehiculo();
            $socio = $em->getRepository('AdminBundle:Socio')->find($socioId);
            $entity->setSocio($socio);
            $urlAction = $this->generateUrl('vehiculo_create');
            $permiso = UtilsController::checkPermiso(array('vehiculo', 'abm', 'new'));
        }
        if ($permiso) {
            $form = $this->createForm(new VehiculoType(), $entity, array(
                'action' => $urlAction, 'method' => 'POST',
            ));

            $html = $this->renderView('AdminBundle:Vehiculo:_partial_edit.html.twig',
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
        $entity = new Vehiculo();
        $form = $this->createForm(new VehiculoType(), $entity, array(
            'action' => $this->generateUrl('vehiculo_create'),
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
                // armar tr para reemplazar
                $row = $this->renderView('AdminBundle:Vehiculo:_partial_list_tr.html.twig',
                        array('vehiculo' => $entity)
                );
                // armar partial para reemplazar tabla empleados
                $partial = $this->renderView('AdminBundle:Empleado:_partial_list.html.twig',
                        array('entity' => $entity->getSocio())
                );
                $msg = 'OK';
                //$tr = $this->setTableTr($entity);
            }
            catch (\Exception $ex) {
                $msg = $ex->getMessage();
            }
        }
        $result = array('msg' => $msg, 'trhtml' => $row, 'partial' => $partial);
        return new Response(json_encode($result));
    }

    public function updateAction($id, Request $request) {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('AdminBundle:Vehiculo')->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('No existe el Vehículo.');
        }

        $form = $this->createForm(new VehiculoType(), $entity, array(
            'action' => $this->generateUrl('vehiculo_update', array('id' => $id)),
            'method' => 'POST',
        ));
        $form->handleRequest($request);
        $msg = 'No se pudo realizar esta operación.' . chr(13) . ' Verifique los datos ingresados.';
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            try {
                $em->persist($entity);
                $em->flush();
                // armar tr para reemplazar
                $row = $this->renderView('AdminBundle:Vehiculo:_partial_list_tr.html.twig',
                        array('vehiculo' => $entity)
                );
                // armar partial para reemplazar tabla empleados
                $partial = $this->renderView('AdminBundle:Empleado:_partial_list.html.twig',
                        array('entity' => $entity->getSocio())
                );
                $msg = 'OK';
                //$tr = $this->setTableTr($entity);
            }
            catch (\Exception $ex) {
                $msg = $ex->getMessage();
            }
        }
        $result = array('msg' => $msg, 'trhtml' => $row, 'partial' => $partial);
        return new Response(json_encode($result));
    }

    public function deleteAction($id) {
        $msg = 'OK';
        $partial = '';
        if (UtilsController::checkPermiso(array('vehiculo', 'abm', 'delete'))) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AdminBundle:Vehiculo')->find($id);
            $socio = $entity->getSocio();
            $empleado = $entity->getEmpleado() ? true : false;
            try {
                $em->remove($entity);
                $em->flush();
                if ($empleado) {
                    // armar partial con datos de empleados
                    $partial = $this->renderView('AdminBundle:Empleado:_partial_list.html.twig',
                            array('entity' => $socio)
                    );
                }
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
        $html = $this->renderView('AdminBundle:Vehiculo:_partial_show_vehiculos.html.twig',
                array('vehiculos' => $entity->getVehiculos())
        );
        return new Response($html);
    }

    public function setTableTr($obj) {
        $linkActions = $this->renderView('AdminBundle:Vehiculo:_partial_linkactions.html.twig',
                array('vehiculo' => $obj)
        );
        $nombre = ($obj->getEmpleado()) ? $obj->getEmpleado()->getNombreCompleto() : '';
        $empleado = '<a href="#" class="show-modal" data-url="' . $this->generateUrl('vehiculo_update', array('id' => $obj->getId())) . '" title="Empleado Asignado" > ' . $nombre . ' </a>&nbsp;';
        return array(
            $obj->getDominio(),
            $obj->getMarca(),
            $obj->getModelo(),
            $obj->getAnio(),
            $obj->getLineasHtml(),
            $linkActions
        );
    }

}