<?php
namespace SG\ConfigBundle\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AuditoriaController extends Controller
{
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $em->getFilters()->disable('softdeleteable');
        $pacientes = $em->getRepository('AdminBundle:Paciente')->findBorrados();
        $turnos = $em->getRepository('AdminBundle:Agenda')->findTurnosBorrados();
        $consultas = $em->getRepository('AdminBundle:Paciente')->findConsultasBorradas();
        $internaciones = $em->getRepository('AdminBundle:Internacion')->findBorradas();
        $practicas = $em->getRepository('AdminBundle:Internacion')->findPracticasBorradas();
        $em->getFilters()->enable('softdeleteable');
        
        return $this->render('ConfigBundle:Auditoria:index.html.twig',array('pacientes'=>$pacientes, 'turnos'=>$turnos,
            'consultas'=>$consultas, 'internaciones'=>$internaciones,'practicas'=>$practicas));
    }

}
