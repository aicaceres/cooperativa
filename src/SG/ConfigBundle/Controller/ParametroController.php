<?php

namespace SG\ConfigBundle\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use SG\ConfigBundle\Form\ParametroType;
use SG\ConfigBundle\Entity\TipoOperacion;
use SG\ConfigBundle\Entity\ConceptoCaja;
use SG\ConfigBundle\Entity\Empresa;

class ParametroController extends Controller {
    private $tableDesc = array('ConceptoCaja' => 'Conceptos de Caja', 'Empresa' => 'Empresas',
        'TipoOperacion' => 'Tipos de Operaciones', 'Configuracion' => 'Configuración General');

    public function indexAction($table) {
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('ConfigBundle:Usuario')->find($this->get('security.context')->getToken()->getUser()->getId());
        $perfil = $user->getPerfil();
        if ($perfil->getParametro()) {
            if ($table == 'Configuracion') {
                $entity = $em->getRepository('ConfigBundle:Configuracion')->find(1);
                $urlUpdate = $this->generateUrl('parametro_update', array('table' => 'Configuracion', 'id' => $entity->getId()));

                $form = $this->createForm(new ParametroType(), $entity, array(
                    'action' => $urlUpdate,
                    'method' => 'POST',
                ));
                $html = $this->renderView('ConfigBundle:Parametro:edit.html.twig', array('entity' => $entity, 'form' => $form->createView(), 'table' => $table)
                );
            }
            else {
                $entities = $em->getRepository('ConfigBundle:' . $table)->findAll();
                $html = $this->renderView('ConfigBundle:Parametro:list.html.twig', array('entities' => $entities, 'table' => $table)
                );
            }

            return $this->render('ConfigBundle:Parametro:index.html.twig', array(
                        'title' => $this->tableDesc[$table], 'html' => json_encode($html)
            ));
        }
        else {
            $session = $this->get('session');
            $session->getFlashBag()->add('danger', 'Usted no posee los permisos necesarios para acceder a la sección Configuración');
            return $this->redirect($this->generateUrl('admin_homepage'));
        }
    }

    public function listAction($table) {
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('ConfigBundle:' . $table)->findAll();
        $html = $this->renderView('ConfigBundle:Parametro:list.html.twig',
                array('entities' => $entities)
        );
        return new Response($html);
    }

    public function newAction($table) {
        $entity = $this->getNewObject($table);
        $urlCreate = $this->generateUrl('parametro_create', array('table' => $table));
        $form = $this->createForm(new ParametroType(), $entity, array(
            'action' => $urlCreate, 'method' => 'POST',
        ));

        $html = $this->renderView('ConfigBundle:Parametro:edit.html.twig',
                array('entity' => $entity, 'form' => $form->createView(), 'table' => $table)
        );
        return $this->render('ConfigBundle:Parametro:index.html.twig', array(
                    'title' => $this->tableDesc[$table], 'html' => json_encode($html)
        ));
    }

    public function createAction(Request $request, $table) {
        $entity = $this->getNewObject($table);
        $urlCreate = $this->generateUrl('parametro_create', array('table' => $table));
        $form = $this->createForm(new ParametroType(), $entity, array(
            'action' => $urlCreate, 'method' => 'POST',
        ));
        $form->handleRequest($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            try {
                $em->persist($entity);
                $em->flush();
                $this->get('session')->getFlashBag()->add('info', 'Creado con éxito!');
                return $this->redirect($this->generateUrl('parametro', array('table' => $table)));
            }
            catch (\Exception $ex) {
                $this->get('session')->getFlashBag()->add('danger', $ex->getTraceAsString());
            }
        }
        $html = $this->renderView('ConfigBundle:Parametro:edit.html.twig',
                array('entity' => $entity, 'form' => $form->createView(), 'table' => $table));
        return $this->render('ConfigBundle:Parametro:index.html.twig', array(
                    'title' => $this->tableDesc[$table], 'html' => json_encode($html)
        ));
    }

    public function editAction($table, $id) {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('ConfigBundle:' . $table)->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('No existe');
        }
        $urlUpdate = $this->generateUrl('parametro_update',
                array('table' => $table, 'id' => $entity->getId()));

        $form = $this->createForm(new ParametroType(), $entity, array(
            'action' => $urlUpdate,
            'method' => 'POST',
        ));
        $html = $this->renderView('ConfigBundle:Parametro:edit.html.twig',
                array('entity' => $entity, 'form' => $form->createView(), 'table' => $table));
        return $this->render('ConfigBundle:Parametro:index.html.twig', array(
                    'title' => $this->tableDesc[$table], 'html' => json_encode($html)
        ));
    }

    public function updateAction(Request $request, $table, $id) {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('ConfigBundle:' . $table)->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('No existe.');
        }
        $urlUpdate = $this->generateUrl('parametro_update', array('table' => $table, 'id' => $entity->getId()));

        $form = $this->createForm(new ParametroType(), $entity, array(
            'action' => $urlUpdate,
            'method' => 'POST',
        ));

        $form->handleRequest($request);
        if ($form->isValid()) {
            try {
                $em->persist($entity);
                $em->flush();
                $this->get('session')->getFlashBag()->add('info', 'Modificado con éxito!');
                return $this->redirect($this->generateUrl('parametro', array('table' => $table)));
            }
            catch (\Exception $ex) {
                $this->get('session')->getFlashBag()->add('danger', $ex->getTraceAsString());
            }
        }
        $html = $this->renderView('ConfigBundle:Parametro:edit.html.twig',
                array('entity' => $entity, 'form' => $form->createView(), 'table' => $table)
        );
        return $this->render('ConfigBundle:Parametro:index.html.twig', array(
                    'title' => $this->tableDesc[$table], 'html' => json_encode($html)
        ));
    }

    /**
     * Deletes a Parametro entity.
     */
    public function deleteAction($table, $id) {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('ConfigBundle:' . $table)->find($id);

        if ($table == 'Empresa') {
            if (count($entity->getSocios()) > 0) {
                $msg = 'No se puede eliminar este item porque es utilizado en el sistema!';
                $this->get('session')->getFlashBag()->add('danger', $msg);
                return $this->redirect($this->generateUrl('parametro', array('table' => $table)));
            }
        }
        try {
            $em->remove($entity);
            $em->flush();
            $this->get('session')->getFlashBag()->add('info', 'Se ha eliminado con éxito!');
        }
        catch (\Exception $ex) {
            if (strpos($ex->getMessage(), '1451') === false) {
                $msg = 'Ha ocurrido un error!';
            }
            else {
                $msg = 'No se puede eliminar este item porque es utilizado en el sistema!';
            }
            $this->get('session')->getFlashBag()->add('danger', $msg);
        }

        return $this->redirect($this->generateUrl('parametro', array('table' => $table)));
    }

    public function getMontoConceptoCajaAction() {
        $em = $this->getDoctrine()->getManager();
        $concepto = $em->getRepository('ConfigBundle:ConceptoCaja')->find($this->getRequest()->get('conceptoId'));
        return new Response(json_encode($concepto->getMonto()));
    }

    /*
     * Functions
     */

    private function getNewObject($obj) {
        switch ($obj) {
            case 'ConceptoCaja':
                $entity = new ConceptoCaja();
                break;
            case 'Empresa':
                $entity = new Empresa();
                break;
            case 'TipoOperacion':
                $entity = new TipoOperacion();
                break;
        }
        return $entity;
    }

    public function renderAddParametroAction(Request $request) {
        $table = $request->get('tabla');
        $entity = $this->getNewObject($table);
        $urlCreate = $this->generateUrl('parametro_create_ajax', array('table' => $table));
        $form = $this->createForm(new ParametroType(), $entity, array(
            'action' => $urlCreate, 'method' => 'POST',
        ));

        $html = $this->renderView('ConfigBundle:Parametro:partial-edit.html.twig',
                array('entity' => $entity, 'form' => $form->createView(), 'table' => $table)
        );
        return new Response($html);
    }

    public function createParametroAction(Request $request) {
        $table = $request->get('table');
        $entity = $this->getNewObject($table);
        $urlCreate = $this->generateUrl('parametro_create_ajax', array('table' => $table));
        $form = $this->createForm(new ParametroType(), $entity, array(
            'action' => $urlCreate, 'method' => 'POST',
        ));
        $form->handleRequest($request);
        $msg = 'No se pudo realizar esta operación.' . chr(13) . ' Verifique que no exista el valor que está intentando ingresar.';
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            try {
                $em->persist($entity);
                $em->flush();
                $msg = 'OK';
            }
            catch (\Exception $ex) {
                $msg = $ex->getMessage();
            }
        }
        $result = array('msg' => $msg, 'nombre' => $entity->getNombre(), 'id' => $entity->getId());
        return new Response(json_encode($result));
    }

}