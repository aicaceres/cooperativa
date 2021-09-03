<?php

namespace SG\ConfigBundle\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class UtilsController extends Controller {

    /// CHECK PERMISOS DE SISTEMA
    public function checkPermiso($tags) {
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('ConfigBundle:Usuario')->find($this->get('security.context')->getToken()->getUser()->getId());
        $perfil = $user->getPerfil();
        $permisoId = $em->getRepository('ConfigBundle:Permiso')->getModuloTag($tags[0], $tags[1], $tags[2]);
        $permiso = $em->getRepository('ConfigBundle:Permiso')->find($permisoId['id']);
        return $perfil->getPermisos()->contains($permiso);
    }

    /* public function indexAction($name)
      {
      return $this->render('ConfigBundle:Default:index.html.twig', array('name' => $name));
      } */

    ##Location

    public function provinciasAction(Request $request) {
        $pais_id = $request->request->get('pais_id');
        $em = $this->getDoctrine()->getManager();
        $provincias = $em->getRepository('ConfigBundle:Provincia')->findByPaisId($pais_id);
        return new JsonResponse($provincias);
    }

    public function localidadesAction(Request $request) {
        $provincia_id = $request->request->get('provincia_id');
        $em = $this->getDoctrine()->getManager();
        $localidades = $em->getRepository('ConfigBundle:Localidad')->findByProvinciaId($provincia_id);
        return new JsonResponse($localidades);
    }

    public function codPostalAction(Request $request) {
        $localidad_id = $request->request->get('localidad_id');
        $em = $this->getDoctrine()->getManager();
        $localidad = $em->getRepository('ConfigBundle:Localidad')->find($localidad_id);
        $cod = ($localidad->getCodPostal()) ? $localidad->getCodPostal() : '';
        return new JsonResponse($cod);
    }

    public function calculaEdadAction($fecha) {
        list($Y, $m, $d) = explode("-", $fecha);
        $edad = date("md") < $m . $d ? date("Y") - $Y - 1 : date("Y") - $Y;
        return new JsonResponse($edad);
    }

    public static function diasTranscurridos($fecha_i, $fecha_f) {
        $dias = (strtotime($fecha_i) - strtotime($fecha_f)) / 86400;
        $dias = abs($dias);
        $dias = floor($dias);
        return $dias;
    }

    /// PARA FECHAS
    public static function toAnsiDate($value) {
        if (is_array($value))
            $value = isset($value['text']) ? $value['text'] : null;

        if (strpos($value, '-') === false)
            return $value;

        $date = UtilsController::toArray($value);

        $ansi = $date['Y'] . '-' . $date['m'] . '-' . $date['d'];
        /* $ansi .= isset($date['H']) ? ' '.$date['H'].':'.$date['i'].':'.$date['s'] : ''; */

        return $ansi;
    }

    public static function toArray($value) {
        if (strpos($value, '-') === false)
            return array('Y' => '1969', 'm' => '01', 'd' => '01');

        $parts = explode('-', $value);
        $years = explode(' ', $parts[2]);
        //    $hours = isset($years[1]) ? explode(':',$years[1]) : null;

        $date = array('d' => $parts[0], 'm' => $parts[1], 'Y' => $years[0]);
        //       if($hours)
        //       $date = array_merge($date,array('H'=>$hours[0],'i'=>$hours[1],'s'=>$hours[2]));

        return $date;
    }

    public static function longDateSpanish($fecha, $dayname = FALSE) {
        $date = strtotime($fecha->format('Y-m-d'));
        $dia = date("l", $date);

        if ($dia == "Monday")
            $dia = "Lunes";
        if ($dia == "Tuesday")
            $dia = "Martes";
        if ($dia == "Wednesday")
            $dia = "Miércoles";
        if ($dia == "Thursday")
            $dia = "Jueves";
        if ($dia == "Friday")
            $dia = "Viernes";
        if ($dia == "Saturday")
            $dia = "Sabado";
        if ($dia == "Sunday")
            $dia = "Domingo";

        $dia2 = date("d", $date);

        $mes = date("F", $date);

        if ($mes == "January")
            $mes = "Enero";
        if ($mes == "February")
            $mes = "Febrero";
        if ($mes == "March")
            $mes = "Marzo";
        if ($mes == "April")
            $mes = "Abril";
        if ($mes == "May")
            $mes = "Mayo";
        if ($mes == "June")
            $mes = "Junio";
        if ($mes == "July")
            $mes = "Julio";
        if ($mes == "August")
            $mes = "Agosto";
        if ($mes == "September")
            $mes = "Setiembre";
        if ($mes == "October")
            $mes = "Octubre";
        if ($mes == "November")
            $mes = "Noviembre";
        if ($mes == "December")
            $mes = "Diciembre";

        $ano = date("Y", $date);
        if ($dayname)
            $fecha = "$dia, $dia2 de $mes de $ano";
        else
            $fecha = "$dia2 de $mes de $ano";

        return $fecha;
    }

    //// TRUNCADO DE CADENAS
    public static function myTruncate($string, $limit, $break = " ", $pad = "…") {
        // return with no change if string is shorter than $limit
        if (strlen($string) <= $limit)
            return $string;
        // is $break present between $limit and the end of the string?
        if (false !== ($breakpoint = strpos($string, $break, $limit))) {
            if ($breakpoint < strlen($string) - 1) {
                $string = substr($string, 0, $breakpoint) . $pad;
            }
        } return $string;
    }

}