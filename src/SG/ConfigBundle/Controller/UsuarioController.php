<?php
namespace SG\ConfigBundle\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\HttpFoundation\Response;

use SG\ConfigBundle\Entity\Usuario;
use SG\ConfigBundle\Form\UsuarioType;
/**
 * Usuario controller.
 */
class UsuarioController extends Controller
{
    protected $roles = array('ROLE_ADMIN'=>'Administrador','ROLE_USER'=>'Usuario');
    /**
     * Login de usuario
     */
    public function loginAction(Request $request) {
        $session = $request->getSession();
        if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
            $error = $request->attributes->get(
                    SecurityContext::AUTHENTICATION_ERROR
            );
        } else {
            $error = $session->get(SecurityContext::AUTHENTICATION_ERROR);
            $session->remove(SecurityContext::AUTHENTICATION_ERROR);
        }

        return $this->render('ConfigBundle::login.html.twig', array(
            'last_username' => $session->get(SecurityContext::LAST_USERNAME),
            'error'         => $error
        ));
    }
    
    /**
     * Lists all Usuario entities.
     */
    public function indexAction()
    {
        if ($this->get('security.context')->isGranted('IS_AUTHENTICATED_FULLY')) {
            $em = $this->getDoctrine()->getManager();
            $user = $em->getRepository('ConfigBundle:Usuario')->find($this->get('security.context')->getToken()->getUser()->getId());
            $perfil = $user->getPerfil();
            if (in_array("usuario", $perfil->getItemMenu())) {
                $entities = $em->getRepository('ConfigBundle:Usuario')->findAll();
                $deleteForms = array();

                foreach ($entities as $entity) {
                    $deleteForms[$entity->getId()] = $this->createDeleteForm($entity->getId())->createView();
                }

                return $this->render('ConfigBundle:Usuario:list.html.twig', array(
                    'entities' => $entities,
                    'roles'    => $this->roles,
                    'deleteForms' => $deleteForms,
                ));                               
            } else {
                $session = $this->get('session');
                $session->getFlashBag()->add('danger', 'Usted no posee los permisos necesarios para acceder a la sección Usuarios');
                return $this->redirect($this->generateUrl('admin_homepage'));
            }            
        } else {
            return $this->redirect($this->generateUrl('login', array()));
        }                            
    }
    
    /**
     * Displays a form to create a new Usuario entity.
     */
    public function newAction()
    {
        $entity = new Usuario();
        $form   = $this->createCreateForm($entity);
        return $this->render('ConfigBundle:Usuario:edit.html.twig', array(
            'entity' => $entity,
            'roles'  => $this->roles,
            'form'   => $form->createView(),
        ));
    }
    
    /**
     * Creates a new Usuario entity.
     */
       public function createAction(Request $request)
    {
        $entity = new Usuario();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);
        //$this->get('session')->getFlashBag()->clear();
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            // Codifica el password
            $factory = $this->get('security.encoder_factory');
            $codificador = $factory->getEncoder($entity);
            $password = $codificador->encodePassword($entity->getPassword(), $entity->getSalt());
            $entity->setPassword($password);     
            //$entity->setRoles($request->get('roles_user'));
            try{
                $em->persist($entity);
                $em->flush();
                $this->get('session')->getFlashBag()->add('success','El usuario fue creado con éxito!' ); 
                return $this->redirect($this->generateUrl('seguridad_usuario'));
            } catch (\Doctrine\DBAL\DBALException $e) {
                if($e->getCode()==23000){
                     $this->get('session')->getFlashBag()->add('danger','El nombre de usuario ya existe!' );    
                }
            }
        }
        return $this->render('ConfigBundle:Usuario:edit.html.twig', array(
            'entity' => $entity,
            'roles'  => $this->roles,
            'form'   => $form->createView(),
        ));
    }
    
        /**
    * Creates a form to create a Usuario entity.
    * @param Usuario $entity The entity
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Usuario $entity)
    {
        $form = $this->createForm(new UsuarioType(), $entity, array(
            'action' => $this->generateUrl('seguridad_usuario_create'),
            'method' => 'POST',
        ));
        return $form;
    }       

    /**
     * Displays a form to edit an existing Usuario entity.
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('ConfigBundle:Usuario')->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('No existe el Usuario que está buscando.');
        }
        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);
        return $this->render('ConfigBundle:Usuario:edit.html.twig', array(
            'entity'      => $entity,
            'roles'  => $this->roles,
            'form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Usuario entity.
    * @param Usuario $entity The entity
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Usuario $entity)
    {
        $form = $this->createForm(new UsuarioType(), $entity, array(
            'action' => $this->generateUrl('seguridad_usuario_update', array('id' => $entity->getId())),
            'method' => 'POST',
        ));
        return $form;
    }
    
    /**
     * Edits an existing Usuario entity.
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('ConfigBundle:Usuario')->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('No existe el Usuario que está buscando.');
        }
        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        
        if ($request->getMethod() == 'POST') {
            $passwordOriginal = $editForm->getData()->getPassword();
            $editForm->handleRequest($request);
            if ($editForm->isValid()) {
                if (null == $entity->getPassword()) {
                    $entity->setPassword($passwordOriginal);
                } else {
                    // Codifica el password
                    $factory = $this->get('security.encoder_factory');
                    $codificador = $factory->getEncoder($entity);
                    $password = $codificador->encodePassword($entity->getPassword(), $entity->getSalt());
                    $entity->setPassword($password);
                }
               // $entity->setRoles($request->get('roles_user'));
                $em->persist($entity);
                $em->flush();
                $this->get('session')->getFlashBag()->add('info','Los datos fueron modificados con éxito!' ); 
                return $this->redirect($this->generateUrl('seguridad_usuario_edit', array('id' => $id)));
            }
        }        
        return $this->render('ConfigBundle:Usuario:edit.html.twig', array(
             'entity'      => $entity,
             'roles'  => $this->roles,
             'form'   => $editForm->createView(),
             'delete_form' => $deleteForm->createView(),
        ));
    }
    
    /**
     * Deletes a Usuario entity.
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('ConfigBundle:Usuario')->find($id);
            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Usuario entity.');
            }
            $em->remove($entity);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success','El usuario fue eliminado!' ); 
        }
        return $this->redirect($this->generateUrl('seguridad_usuario'));
    }

    /**
     * Creates a form to delete a Usuario entity by id.
     * @param mixed $id The entity id
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('seguridad_usuario_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
    
    /**
     * Deletes a Usuario entity from Ajax.
     */
    public function deleteAjaxAction()
    {
        $id = $this->getRequest()->get('id');
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('ConfigBundle:Usuario')->find($id);
        try{
            $em->remove($entity);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success','El usuario fue eliminado!' ); 
            $msg ='OK';
        } catch (\Exception $ex) {
            $msg= $ex->getTraceAsString();
        }
        return new Response(json_encode($msg));
    }
    
    
    /**
     * Displays a form to edit an existing Usuario entity.
     */
    public function profileAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('ConfigBundle:Usuario')->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('No existe el Usuario que está buscando.');
        }
        $editForm = $this->createEditForm($entity);
        return $this->render('ConfigBundle:Usuario:profile.html.twig', array(
            'entity'      => $entity,
            'roles'  => $this->roles,
            'form'   => $editForm->createView(),
        ));
    }
    /**
     * Edits an existing Usuario entity.
     */
    public function updateProfileAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('ConfigBundle:Usuario')->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('No existe el Usuario que está buscando.');
        }
        $editForm = $this->createEditForm($entity);
        if ($request->getMethod() == 'POST') {
            $passwordOriginal = $editForm->getData()->getPassword();
            $editForm->handleRequest($request);
            if ($editForm->isValid()) {
                if (null == $entity->getPassword()) {
                    $entity->setPassword($passwordOriginal);
                } else {
                    // Codifica el password
                    $factory = $this->get('security.encoder_factory');
                    $codificador = $factory->getEncoder($entity);
                    $password = $codificador->encodePassword($entity->getPassword(), $entity->getSalt());
                    $entity->setPassword($password);
                }
               // $entity->setRoles($request->get('roles_user'));
                $em->persist($entity);
                $em->flush();
                $this->get('session')->getFlashBag()->add('info','Los datos fueron modificados con éxito!' ); 
                return $this->redirect($this->generateUrl('admin_homepage'));
            }
        }        
        return $this->render('ConfigBundle:Usuario:edit.html.twig', array(
             'entity'      => $entity,
             'roles'  => $this->roles,
             'form'   => $editForm->createView(),
        ));
    }    
}
