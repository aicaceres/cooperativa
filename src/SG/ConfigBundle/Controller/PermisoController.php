<?php
namespace SG\ConfigBundle\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use SG\ConfigBundle\Entity\Permiso;
use SG\ConfigBundle\Form\PermisoType;

class PermisoController extends Controller
{
    /**
     * Lists all entities.
     */ 
    public function indexAction() 
    {
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('ConfigBundle:Permiso')->findAll();
        $deleteForms = array();

        foreach ($entities as $entity) {
            $deleteForms[$entity->getId()] = $this->createDeleteForm($entity->getId())->createView();
        }
        
        return $this->render('ConfigBundle:Permiso:list.html.twig', array(
            'entities' => $entities,
            'deleteForms' => $deleteForms,
        ));
    }
    
    /**
    * Creates a form to create a entity.
    * @param Permiso $entity The entity
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Permiso $entity)
    {
        $form = $this->createForm(new PermisoType(), $entity, array(
            'action' => $this->generateUrl('seguridad_permiso_create'),
            'method' => 'POST',
        ));
        return $form;
    } 
    
    
    /**
     * Creates a new  entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Permiso();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            $this->get('session')->getFlashBag()->add('success','permiso fue creada con éxito!' ); 
            return $this->redirect($this->generateUrl('seguridad_permiso'));
        }

        return $this->render('AdminBundle:Permiso:edit.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    
    
    /**
     * Displays a form to edit an existing entity.
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('ConfigBundle:Permiso')->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('No existe Permiso que está buscando.');
        }
        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);
        return $this->render('ConfigBundle:Permiso:edit.html.twig', array(
            'entity'      => $entity,
            'form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a  entity.
    * @param Permiso $entity The entity
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Permiso $entity)
    {
        $form = $this->createForm(new PermisoType(), $entity, array(
            'action' => $this->generateUrl('seguridad_permiso_update', array('id' => $entity->getId())),
            'method' => 'POST',
        ));
        return $form;
    }
    
    
    /**
     * Displays a form to create a new  entity.
     */
    public function newAction()
    {
        $entity = new Permiso();   
        $form   = $this->createCreateForm($entity);
        return $this->render('ConfigBundle:Permiso:edit.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }
    
    /**
     * Edits an existing entity.
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('ConfigBundle:Permiso')->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('No existe Permiso que está buscando.');
        }
        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        
        if ($request->getMethod() == 'POST') {
            $editForm->handleRequest($request);
            if ($editForm->isValid()) {
                $em->persist($entity);
                $em->flush();
                $this->get('session')->getFlashBag()->add('info','Los datos fueron modificados con éxito!' ); 
                return $this->redirect($this->generateUrl('seguridad_permiso_edit', array('id' => $id)));
            }
        }        
        return $this->render('ConfigBundle:Permiso:edit.html.twig', array(
             'entity'      => $entity,
             'form'   => $editForm->createView(),
             'delete_form' => $deleteForm->createView(),
        ));
    }
 
        /**
     * Deletes a entity.
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('ConfigBundle:Permiso')->find($id);
            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Permiso entity.');
            }
            $em->remove($entity);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success','Permiso fue eliminado!' ); 
        }
        return $this->redirect($this->generateUrl('seguridad_permiso'));
    }
    
     /**
     * Creates a form to delete a  entity by id.
     * @param mixed $id The entity id
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('seguridad_permiso_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
