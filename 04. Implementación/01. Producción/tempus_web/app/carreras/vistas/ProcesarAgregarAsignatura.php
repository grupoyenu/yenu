<?php

/* AUTOLOAD PARA INCLUIR LOS ARCHIVO NECESARIOS */

require_once '../../principal/modelos/Constantes.php';
require_once '../../principal/modelos/AutoCargador.php';

AutoCargador::cargarModulos();

$exito = false;
if (isset($_POST['codigo']) && isset($_POST['asignatura'])) {
    $codigo = $_POST['codigo'];
    $idAsignatura = $_POST['asignatura'];
    $nombreAsignatura = $_POST['nombreAsignatura'];
    $anio = $_POST['anio'];
    if (substr($idAsignatura, 0, 1) == "_") {
        $asignatura = new Asignatura(NULL, $nombreAsignatura);
        $creacion = $asignatura->crear();
        if ($creacion == 2) {
            $controladorCarrera = new ControladorCarreras();
            $idAsignatura = $asignatura->getIdAsignatura();
            $creacion = $controladorCarrera->agregarAsignatura($codigo, $idAsignatura, $anio);
            $exito = ($creacion == 2) ? true : false;
            $mensaje = $controladorCarrera->getDescripcion();
            $resultado = ControladorHTML::mostrarAlertaResultadoOperacion($creacion, $mensaje);
        } else {
            $mensaje = "Asignatura: " . $asignatura->getDescripcion();
            $resultado = ControladorHTML::mostrarAlertaResultadoOperacion($creacion, $mensaje);
        }
    } else {
        $controladorCarrera = new ControladorCarreras();
        $creacion = $controladorCarrera->agregarAsignatura($codigo, $idAsignatura, $anio);
        $exito = ($creacion == 2) ? true : false;
        $mensaje = $controladorCarrera->getDescripcion();
        $resultado = ControladorHTML::mostrarAlertaResultadoOperacion($creacion, $mensaje);
    }
} else {
    /* NO SE RECIBE LA INFORMACION DESDE EL FORMULARIO  */
    $mensaje = "No se obtuvo la información desde el formulario";
    $resultado = ControladorHTML::mostrarAlertaResultadoOperacion(0, $mensaje);
}

/* RETORNA EL ARREGLO JSON PARA MOSTRAR LA INFORMACION SEGUN CORRESPONDA */

$json[] = array('exito' => $exito, 'resultado' => $resultado);
echo json_encode($json);
