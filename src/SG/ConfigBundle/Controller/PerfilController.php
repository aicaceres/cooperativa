<?php

namespace SG\ConfigBundle\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\Common\Collections\ArrayCollection;
use SG\ConfigBundle\Entity\Perfil;
use SG\ConfigBundle\Form\PerfilType;

class PerfilController extends Controller {

    public function indexAction() {
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('ConfigBundle:Perfil')->findAll();
        $deleteForms = array();

        foreach ($entities as $entity) {
            $deleteForms[$entity->getId()] = $this->createDeleteForm($entity->getId())->createView();
        }

        return $this->render('ConfigBundle:Perfil:list.html.twig', array(
                    'entities' => $entities,
                    'deleteForms' => $deleteForms,
        ));
    }

    /**
     * Creates a form to create a entity.
     * @param Perfil $entity The entity
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Perfil $entity) {
        $form = $this->createForm(new PerfilType(), $entity, array(
            'action' => $this->generateUrl('seguridad_perfil_create'),
            'method' => 'POST',
        ));
        return $form;
    }

    /**
     * Displays a form to create a new  entity.
     */
    public function newAction() {
        $entity = new Perfil();

        $form = $this->createCreateForm($entity);
        return $this->render('ConfigBundle:Perfil:edit.html.twig', array(
                    'entity' => $entity,
                    'form' => $form->createView()
        ));
    }

    /**
     * Creates a new  entity.
     *
     */
    public function createAction(Request $request) {
        $entity = new Perfil();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $permisos = $this->addPermisosToForm($form);

            // cargar a permisos del perfil
            foreach ($permisos as $permiso) {
                $entity->addPermiso($permiso);
            }

            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            $this->get('session')->getFlashBag()->add('success', 'El perfil fue creada con éxito!');
            return $this->redirect($this->generateUrl('seguridad_perfil'));
        }

        return $this->render('AdminBundle:Perfil:edit.html.twig', array(
                    'entity' => $entity,
                    'form' => $form->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing entity.
     */
    public function editAction($id) {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('ConfigBundle:Perfil')->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('No existe el perfil que está buscando.');
        }
        $editForm = $this->createEditForm($entity);
        $editForm->get('socioAbm')->setData($entity->getPermisos());
        $editForm->get('socioCtaCte')->setData($entity->getPermisos());
        $editForm->get('empleadoAbm')->setData($entity->getPermisos());
        $editForm->get('vehiculoAbm')->setData($entity->getPermisos());
        $editForm->get('usuarioAbm')->setData($entity->getPermisos());
        $editForm->get('perfilAbm')->setData($entity->getPermisos());

        $deleteForm = $this->createDeleteForm($id);
        return $this->render('ConfigBundle:Perfil:edit.html.twig', array(
                    'entity' => $entity,
                    'form' => $editForm->createView(),
                    'delete_form' => $deleteForm->createView()
        ));
    }

    /**
     * Creates a form to edit a  entity.
     * @param Perfil $entity The entity
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Perfil $entity) {
        $form = $this->createForm(new PerfilType(), $entity, array(
            'action' => $this->generateUrl('seguridad_perfil_update', array('id' => $entity->getId())),
            'method' => 'POST',
        ));
        return $form;
    }

    /**
     * Edits an existing entity.
     */
    public function updateAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('ConfigBundle:Perfil')->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('No existe el perfil que está buscando.');
        }
        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);

        if ($request->getMethod() == 'POST') {
            $editForm->handleRequest($request);
            if ($editForm->isValid()) {

                $formPermisos = $this->addPermisosToForm($editForm);
                //cargar nuevos al perfil
                foreach ($formPermisos as $item) {
                    if (false === $entity->getPermisos()->contains($item)) {
                        $entity->addPermiso($item);
                    }
                }
                //eliminar los permisos
                foreach ($entity->getPermisos() as $item) {
                    if (false === $formPermisos->contains($item)) {
                        $entity->removePermiso($item);
                    }
                }

                $em = $this->getDoctrine()->getManager();
                $em->persist($entity);
                $em->flush();
                $this->get('session')->getFlashBag()->add('info', 'Los datos fueron modificados con éxito!');
                return $this->redirect($this->generateUrl('seguridad_perfil_edit', array('id' => $id)));
            }
        }
        return $this->render('ConfigBundle:Perfil:edit.html.twig', array(
                    'entity' => $entity,
                    'form' => $editForm->createView(),
                    'delete_form' => $deleteForm->createView()
        ));
    }

    /**
     * Deletes a entity.
     */
    public function deleteAction(Request $request, $id) {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('ConfigBundle:Perfil')->find($id);
            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Perfil entity.');
            }
            $em->remove($entity);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'El perfil fue eliminado!');
        }
        return $this->redirect($this->generateUrl('seguridad_perfil'));
    }

    /**
     * Creates a form to delete a  entity by id.
     * @param mixed $id The entity id
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id) {
        return $this->createFormBuilder()
                        ->setAction($this->generateUrl('seguridad_perfil_delete', array('id' => $id)))
                        ->setMethod('DELETE')
                        ->getForm()
        ;
    }

    private function addPermisosToForm($form) {
        $permisos = new ArrayCollection();
        // array de permisos del form
        foreach ($form->get("socioAbm")->getData() as $item) {
            $permisos->add($item);
        }
        foreach ($form->get("socioCtaCte")->getData() as $item) {
            $permisos->add($item);
        }
        foreach ($form->get("empleadoAbm")->getData() as $item) {
            $permisos->add($item);
        }
        foreach ($form->get("vehiculoAbm")->getData() as $item) {
            $permisos->add($item);
        }
        foreach ($form->get("cajaAdm")->getData() as $item) {
            $permisos->add($item);
        }
        foreach ($form->get("usuarioAbm")->getData() as $item) {
            $permisos->add($item);
        }
        foreach ($form->get("perfilAbm")->getData() as $item) {
            $permisos->add($item);
        }
        return $permisos;
    }

}