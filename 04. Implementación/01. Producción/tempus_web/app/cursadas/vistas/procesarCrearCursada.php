<?php

require_once '../../principal/modelos/Constantes.php';
require_once '../../principal/modelos/AutoCargador.php';

AutoCargador::cargarModulos();
$exito = FALSE;
if (isset($_POST['idCarrera']) && isset($_POST['idAsignatura']) && isset($_POST['cbClases'])) {

    $exito = TRUE;
    $resultado = "<div class='alert alert-danger text-center' role='alert'>
                    <i class='fas fa-exclamation-triangle'></i> 
                    <strong>No se obtuvo la información desddde el formulario</strong>
                  </div>";
} else {
    $resultado = "<div class='alert alert-danger text-center' role='alert'>
                    <i class='fas fa-exclamation-triangle'></i> 
                    <strong>No se obtuvo la información desde el formulario</strong>
                  </div>";
}

/* RETORNA EL ARREGLO JSON PARA MOSTRAR LA INFORMACION SEGUN CORRESPONDA */

$json[] = array('exito' => $exito, 'resultado' => $resultado);
echo json_encode($json);
