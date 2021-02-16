<?php

/* SE INCLUYE EL ARCHIVO DE CONSTANTES Y EL AUTOLOAD */

require_once '../../principal/modelo/Constantes.php';
require_once '../../principal/modelo/AutoCargador.php';

/* SE REFERENCIAN LOS NAMESPACE */

use app\asignatura\modelo\Asignatura;
use app\carrera\modelo\Carrera;
use app\plan\controlador\ControladorPlan;
use app\principal\controlador\ControladorHTML;
use app\principal\modelo\AutoCargador;

AutoCargador::cargarModulos();

$exito = false;
if (isset($_POST['codigo']) && isset($_POST['asignatura'])) {
    $idCarrera = $_POST['codigo'];
    $idAsignatura = $_POST['asignatura'];
    $anio = $_POST['anio'];
    $carrera = new Carrera($idCarrera);
    $asignatura = new Asignatura($idAsignatura);
    $obcar = $carrera->obtenerPorIdentificador();
    $obasi = $asignatura->obtenerPorIdentificador();
    if (($obcar[0] == 2) && ($obasi[0] == 2)) {
        $controlador = new ControladorPlan();
        $creacion = $controlador->crear($asignatura, $carrera, NULL, NULL, $anio);
        $codigo = $creacion[0];
        $mensaje = $creacion[1];
        $exito = ($codigo == 2) ? TRUE : FALSE;
        $resultado = ControladorHTML::mostrarAlertaResultadoOperacion($codigo, $mensaje);
    } else {
        $codigo = 0;
        $mensaje = "No se obtuvo la información necesaria para agregar asignatura";
        $resultado = ControladorHTML::mostrarAlertaResultadoOperacion($codigo, $mensaje);
    }
} else {
    /* NO SE RECIBE LA INFORMACION DESDE EL FORMULARIO  */
    $mensaje = "No se obtuvo la información desde el formulario";
    $resultado = ControladorHTML::mostrarAlertaResultadoOperacion(0, $mensaje);
}

/* RETORNA EL ARREGLO JSON PARA MOSTRAR LA INFORMACION SEGUN CORRESPONDA */

$json[] = array('exito' => $exito, 'resultado' => $resultado);
echo json_encode($json);
