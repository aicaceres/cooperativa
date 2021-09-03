<?php
namespace SG\AdminBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use SG\ConfigBundle\Controller\UtilsController;

class HomeController extends Controller
{
    public function indexAction() {
        
        if ($this->get('security.context')->isGranted('IS_AUTHENTICATED_FULLY')) {
            $em = $this->getDoctrine()->getManager();
            $socios = $em->getRepository('AdminBundle:Socio')->findAll();
            $vencimientos = $em->getRepository('AdminBundle:Deuda')->findVencimientosDelMes();
            
            $hoy = new \DateTime(date('d-m-Y'));
            $param = $em->getRepository('ConfigBundle:Configuracion')->find(1);
                foreach ($vencimientos as $deuda) {
                    if( count($deuda->getPagos())==0 &&  $deuda->getFechaVto() < $hoy ){
                        $dias = UtilsController::diasTranscurridos( $deuda->getFechaVto()->format('Y-m-d'), date('Y-m-d') );                
                        //calcular mora
                        if($param->getTipoRecargoCuota()=='P'){
                            $recargo = ($deuda->getMonto()*($param->getMontoRecargoCuota()/100)) * $dias;
                        }else{
                            $recargo = $param->getMontoRecargoCuota()*$dias;                    
                        }
                        $deuda->setMora( $recargo );
                    }                
                }    
            
            return $this->render('AdminBundle:Home:index.html.twig', 
                    array('socios'=>$socios, 'vencimientos'=>$vencimientos));            
            
        } else {
            return $this->redirect($this->generateUrl('login', array()));
        }
    }

}
