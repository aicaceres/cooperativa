<?php

namespace SG\AdminBundle\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use SG\ConfigBundle\Controller\UtilsController;
use SG\AdminBundle\Entity\Socio;
use SG\AdminBundle\Form\SocioType;

/**
 * Socio controller.
 */
class SocioController extends Controller {

    /**
     * Lists all Socio entities.
     */
    public function listAction(Request $request) {
        if ($this->get('security.context')->isGranted('IS_AUTHENTICATED_FULLY')) {
            $em = $this->getDoctrine()->getManager();
            $user = $em->getRepository('ConfigBundle:Usuario')->find($this->get('security.context')->getToken()->getUser()->getId());
            $perfil = $user->getPerfil();
            if ($perfil->getSocio()) {
                $empresaId = $request->get('empresa');
                if ($empresaId) {
                    $entities = $em->getRepository('AdminBundle:Socio')->filtroPorEmpresa($empresaId);
                }
                else {
                    $entities = $em->getRepository('AdminBundle:Socio')->findAll();
                }
                $empresas = $em->getRepository('ConfigBundle:Empresa')->findAll();

                $deleteForms = array();
                foreach ($entities as $entity) {
                    $deleteForms[$entity->getId()] = $this->createDeleteForm($entity->getId())->createView();
                }

                return $this->render('AdminBundle:Socio:list.html.twig', array(
                            'entities' => $entities,
                            'empresas' => $empresas,
                            'empresa' => $empresaId,
                            'deleteForms' => $deleteForms,
                ));
            }
            else {
                $session = $this->get('session');
                $session->getFlashBag()->add('danger', 'Usted no posee los permisos necesarios para acceder a la sección Socios');
                return $this->redirect($this->generateUrl('admin_homepage'));
            }
        }
        else {
            return $this->redirect($this->generateUrl('login', array()));
        }
    }

    /**
     * Creates a form to delete a Socio entity by id.
     * @param mixed $id The entity id
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id) {
        return $this->createFormBuilder()
                        ->setAction($this->generateUrl('socio_abm_delete', array('id' => $id)))
                        ->setMethod('DELETE')
                        ->getForm()
        ;
    }

    /**
     * Deletes a Socio entity.
     */
    public function deleteAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('ConfigBundle:Usuario')->find($this->get('security.context')->getToken()->getUser()->getId());
        $perfil = $user->getPerfil();
        $permisoId = $em->getRepository('ConfigBundle:Permiso')->getModuloTag('socio', 'abm', 'delete');
        $permiso = $em->getRepository('ConfigBundle:Permiso')->find($permisoId['id']);
        if ($perfil->getPermisos()->contains($permiso)) {
            $form = $this->createDeleteForm($id);
            $form->handleRequest($request);

            if ($form->isValid()) {
                $entity = $em->getRepository('AdminBundle:Socio')->find($id);
                if (!$entity) {
                    throw $this->createNotFoundException('No se encuentra el Socio.');
                }
                //Registro actualizacion
                $entity->setUpdated(new \DateTime());
                $em->persist($entity);
                $em->flush();
                //Borro
                $em->remove($entity);
                $em->flush();
            }
        }
        else {
            $session = $this->get('session');
            $session->getFlashBag()->add('danger', 'Usted no posee los permisos necesarios para realizar esta acción');
        }

        return $this->redirect($this->generateUrl('socio_abm'));
    }

    /**
     * Creates a new Socio entity.
     */
    public function createAction(Request $request) {
        $data = $request->get('sg_adminbundle_socio');
        $new = $data['savenew'];

        $entity = new Socio();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
            if ($new == 'S')
                return $this->redirect($this->generateUrl('socio_abm_new'));
            else
                return $this->redirect($this->generateUrl('socio_abm_edit', array('id' => $entity->getId())));
        }

        return $this->render('AdminBundle:Socio:edit.html.twig', array(
                    'entity' => $entity,
                    'form' => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Socio entity.
     * @param Socio $entity The entity
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Socio $entity) {
        $form = $this->createForm(new SocioType(), $entity, array(
            'action' => $this->generateUrl('socio_create'),
            'method' => 'POST',
        ));
        return $form;
    }

    /**
     * Displays a form to create a new Socio entity.
     */
    public function newAction() {
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('ConfigBundle:Usuario')->find($this->get('security.context')->getToken()->getUser()->getId());
        $perfil = $user->getPerfil();
        $permisoId = $em->getRepository('ConfigBundle:Permiso')->getModuloTag('socio', 'abm', 'new');
        $permiso = $em->getRepository('ConfigBundle:Permiso')->find($permisoId['id']);
        if ($perfil->getPermisos()->contains($permiso)) {
            $entity = new Socio();
            $localidad = $em->getRepository('ConfigBundle:Localidad')->findOneByPordefecto(1);
            $entity->setLocalidad($localidad);

            $form = $this->createCreateForm($entity);
            return $this->render('AdminBundle:Socio:edit.html.twig', array(
                        'entity' => $entity,
                        'form' => $form->createView(),
            ));
        }
        else {
            $session = $this->get('session');
            $session->getFlashBag()->add('danger', 'Usted no posee los permisos necesarios para realizar esta acción');
            return $this->redirect($this->generateUrl('socio_abm'));
        }
    }

    /**
     * Finds and displays a Socio entity.
     */
    public function showAction($id) {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('AdminBundle:Socio')->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('No se encuentra el Socio.');
        }
        $editForm = $this->createEditForm($entity);
        return $this->render('AdminBundle:Socio:show.html.twig', array(
                    'entity' => $entity,
                    'form' => $editForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Socio entity.
     */
    public function editAction($id) {
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('ConfigBundle:Usuario')->find($this->get('security.context')->getToken()->getUser()->getId());
        $perfil = $user->getPerfil();
        $permisoId = $em->getRepository('ConfigBundle:Permiso')->getModuloTag('socio', 'abm', 'edit');
        $permiso = $em->getRepository('ConfigBundle:Permiso')->find($permisoId['id']);
        if ($perfil->getPermisos()->contains($permiso)) {
            $entity = $em->getRepository('AdminBundle:Socio')->find($id);
            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Medico entity.');
            }

            $editForm = $this->createEditForm($entity);
            $deleteForm = $this->createDeleteForm($id);

            return $this->render('AdminBundle:Socio:edit.html.twig', array(
                        'entity' => $entity,
                        'form' => $editForm->createView(),
                        'delete_form' => $deleteForm->createView(),
            ));
        }
        else {
            $session = $this->get('session');
            $session->getFlashBag()->add('danger', 'Usted no posee los permisos necesarios para realizar esta acción');
            return $this->redirect($this->generateUrl('socio_abm'));
        }
    }

    /**
     * Creates a form to edit a Socio entity.
     * @param Socio $entity The entity
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Socio $entity) {
        $form = $this->createForm(new SocioType(), $entity, array(
            'action' => $this->generateUrl('socio_update', array('id' => $entity->getId())),
            'method' => 'POST',
        ));

        return $form;
    }

    /**
     * Edits an existing Socio entity.
     */
    public function updateAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('AdminBundle:Socio')->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('No existe el Socio.');
        }
        /* $originalDomLab = new ArrayCollection();
          foreach ($entity->getDomicilios() as $item) {
          $originalDomLab->add($item);
          } */

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            // remove the relationship
            /* foreach ($originalDomLab as $item) {
              if (false === $entity->getDomicilios()->contains($item)) {
              $em->remove($item);
              }
              } */
            $em->flush();
            return $this->redirect($this->generateUrl('socio_abm'));
        }

        return $this->render('AdminBundle:Socio:edit.html.twig', array(
                    'entity' => $entity,
                    'form' => $editForm->createView(),
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /* Suggest */

    public function getSocioSuggestAction() {
        $term = $this->getRequest()->get('term');
        $em = $this->getDoctrine()->getManager();
        $items = $em->getRepository('AdminBundle:Socio')->findAllByTerm($term);
        $array = array();
        if ($items) {
            foreach ($items as $item) {
                $nombre = $item['apellido'] . ', ' . $item['nombre'] . ' (DNI ' . $item['nroDocumento'] . ')';
                array_push($array,
                        array('id' => $item['id'], 'label' => $nombre, 'nombre' => $item['apellido'] . ', ' . $item['nombre']));
            }
        }
        return new Response(json_encode($array));
    }

    public function printListadoAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        if ($request->get('empresa')) {
            $empresa = $em->getRepository('ConfigBundle:Empresa')->find($request->get('empresa'));
        }
        else {
            $empresa = null;
        }
        $socios = $em->getRepository('AdminBundle:Socio')->findAll();
        if ($empresa) {
            $socios = $em->getRepository('AdminBundle:Socio')->filtroPorEmpresa($empresa->getId());
        }
        $logo = __DIR__ . '/../../../../web/assets/img/logos/membrete.png';

        $facade = $this->get('ps_pdf.facade');
        $response = new Response();
        $this->render('AdminBundle:Socio:listado.pdf.twig',
                array('socios' => $socios, 'empresa' => $empresa, 'logo' => $logo), $response);

        $xml = $response->getContent();
        $content = $facade->render($xml);

        return new Response($content, 200, array('content-type' => 'application/pdf',
            'Content-Disposition' => 'filename=ListadoSocios.pdf'));
    }

    public function mailingAction() {
        $asunto = $this->getRequest()->get('asunto');
        $titulo = $this->getRequest()->get('titulo');
        $mensaje = $this->getRequest()->get('mensaje');

        $em = $this->getDoctrine()->getManager();
        $socios = $em->getRepository('AdminBundle:Socio')->findAll();
        $hoy = new \DateTime(date('d-m-Y'));
        $param = $em->getRepository('ConfigBundle:Configuracion')->find(1);
        foreach ($socios as $socio) {
            foreach ($socio->getDeudas() as $deuda) {
                if (count($deuda->getPagos()) == 0 && $deuda->getFechaVto() < $hoy) {
                    $dias = UtilsController::diasTranscurridos($deuda->getFechaVto()->format('Y-m-d'), date('Y-m-d'));
                    //calcular mora
                    if ($param->getTipoRecargoCuota() == 'P') {
                        $recargo = ($deuda->getMonto() * ($param->getMontoRecargoCuota() / 100)) * $dias;
                    }
                    else {
                        $recargo = $param->getMontoRecargoCuota() * $dias;
                    }
                    $deuda->setMora($recargo);
                }
            }
        }

        return $this->render('AdminBundle:Socio:mailing.html.twig', array(
                    'entities' => $socios,
                    'asunto' => $asunto,
                    'titulo' => $titulo,
                    'mensaje' => $mensaje
        ));
    }

    public function sendMailingAction() {
        $mails = $this->getRequest()->get('mails');
        $asunto = $this->getRequest()->get('asunto');
        $mensaje = $this->getRequest()->get('mensaje');

        $em = $this->getDoctrine()->getManager();
        $cabecera = 'http://diwebmisiones.com.ar/cofomi/membrete.png';

        foreach ($mails as $socioId) {
            $socio = $em->getRepository('AdminBundle:Socio')->find($socioId);
            if (filter_var($socio->getEmail(), FILTER_VALIDATE_EMAIL)) {
                $message = \Swift_Message::newInstance()
                        ->setSubject($asunto)
                        ->setFrom('notificaciones@cofomi.com.ar')
                        ->setTo($socio->getEmail());
                $message->setBody(
                        $this->renderView('ConfigBundle:Mails:mail.html.twig', array(
                            'socio' => $socio->getNombreCompleto(),
                            'mensaje' => $mensaje,
                            'cabecera' => $cabecera)
                        ), 'text/html'
                );
                $this->get('mailer')->send($message);
            }
        }
        return new Response('OK');
    }

    /*
     * LISTADO DE LIQUIDACIONES
     */

    public function liquidacionAction($id) {
        $em = $this->getDoctrine()->getManager();
        $socio = $em->getRepository('AdminBundle:Socio')->find($id);
        if (!$socio) {
            $socio = null;
        }

        return $this->render('AdminBundle:Socio:liquidacion.html.twig', array('socio' => $socio));
    }

    public function getDatosLiquidacionesAction() {
        $id = $this->getRequest()->get('socioId');
        $em = $this->getDoctrine()->getManager();
        $socio = $em->getRepository('AdminBundle:Socio')->find($id);
        $liquidaciones = $em->getRepository('AdminBundle:Caja')->getLiquidacionesBySocio($id);
        $partial = $this->renderView('AdminBundle:Socio:_liquidaciones_list.html.twig', array('liquidaciones' => $liquidaciones,));
        return new Response(json_encode($partial));


        $hoy = new \DateTime(date('d-m-Y'));
        $deleteForms = array();

        foreach ($socio->getDeudas() as $deuda) {
            $deleteForms[$deuda->getId()] = $this->createDeleteDeudaForm($deuda->getId())->createView();
            if (count($deuda->getPagos()) == 0 && $deuda->getFechaVto() < $hoy) {
                $dias = UtilsController::diasTranscurridos($deuda->getFechaVto()->format('Y-m-d'), date('Y-m-d'));
                //calcular mora
                if ($param->getTipoRecargoCuota() == 'P') {
                    $recargo = ($deuda->getMonto() * ($param->getMontoRecargoCuota() / 100)) * $dias;
                }
                else {
                    $recargo = $param->getMontoRecargoCuota() * $dias;
                }
                $deuda->setMora($recargo);
            }
        }

        $partial = $this->renderView('AdminBundle:Socio:_partial_datosCtaCte.html.twig', array('socio' => $socio, 'deleteForms' => $deleteForms, 'vencido' => $vencido));
        return new Response(json_encode($partial));
    }

    /*
     * INFORMES
     */

    public function informePorEmpresaAction($id) {

    }

    public function importAction() {
        $em = $this->getDoctrine()->getManager();
        $auxiliar = $em->getRepository('AdminBundle:Socio')->readAuxiliar();
        foreach ($auxiliar as $item) {
            $socio = new Socio();
            $socio->setNombre($item['nombre']);
            $socio->setApellido($item['apellido']);
            $socio->setNroDocumento($item['dni']);
            $socio->setCuit($item['cuit']);
            $socio->setDireccion($item['direccion']);
            $socio->setTelefono($item['telefono']);
            $socio->setCelular($item['celular']);
            $socio->setEmail($item['email']);
            $socio->setContacto($item['contacto']);
            if ($item['fechanac']) {
                $aux = explode('-', $item['fechanac']);
                $fechanac = new \DateTime(date('d-m-Y', strtotime($aux[0] . '-' . $aux[1] . '-19' . $aux[2])));
                $socio->setFechaNacimiento($fechanac);
            }
            if ($item['localidad']) {
                $loc = $em->getRepository('ConfigBundle:Localidad')->findOneByName(trim($item['localidad']));
                $socio->setLocalidad($loc);
            }
            if ($item['empresas']) {
                $emp = $em->getRepository('ConfigBundle:Empresa')->findOneByNombre(trim($item['empresas']));
                $socio->addEmpresa($emp);
            }
            $socio->setActivo(true);
            $em->persist($socio);
        }
        $em->flush();
        return $this->redirect($this->generateUrl('admin_homepage'));
    }

}