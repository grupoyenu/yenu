<?php

require_once '../../principal/modelos/Constantes.php';
require_once '../../principal/modelos/AutoCargador.php';

AutoCargador::cargarModulos();
$exito = FALSE;
if (isset($_POST['idCarrera']) && isset($_POST['idAsignatura']) && isset($_POST['cbClases'])) {
    $controlador = new ControladorCursada();
    $idAsignatura = $_POST['idAsignatura'];
    $idCarrera = $_POST['idCarrera'];
    $clases = array();
    foreach ($_POST['cbClases'] as $dia) {
        $horaInicio = $_POST['horaInicio' . $dia];
        $horaFin = $_POST['horaFin' . $dia];
        $aula = $_POST['idAula' . $dia];
        $clase = new Clase(NULL, $dia, $horaInicio, $horaFin, $aula);
        $clases[] = $clase;
    }
    $creacion = $controlador->crear($idCarrera, $idAsignatura, $clases);
    $mensaje = $controlador->getDescripcion();
    $exito = ($creacion == 2) ? TRUE : FALSE;
    $resultado = ControladorHTML::mostrarAlertaResultadoOperacion($creacion, $mensaje);
} else {
    $resultado = "<div class='alert alert-danger text-center' role='alert'>
                    <i class='fas fa-exclamation-triangle'></i> 
                    <strong>No se obtuvo la información desde el formulario</strong>
                  </div>";
}

/* RETORNA EL ARREGLO JSON PARA MOSTRAR LA INFORMACION SEGUN CORRESPONDA */

$json[] = array('exito' => $exito, 'resultado' => $resultado);
echo json_encode($json);
