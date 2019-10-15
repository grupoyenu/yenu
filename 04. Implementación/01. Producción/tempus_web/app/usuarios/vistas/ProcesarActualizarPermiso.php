<?php

require_once '../../principal/modelos/Constantes.php';
require_once '../../principal/modelos/AutoCargador.php';

AutoCargador::cargarModulos();
$resultado = "";
$exito = false;
if (isset($_POST['operacion'])) {
    $controlador = new ControladorPermisos();
    $operacion = $_POST['operacion'];
    if ($operacion == "crear") {
        $nombre = $_POST['nombre'];
        $creacion = $controlador->crear($nombre);
        switch ($creacion) {
            case 2:
                $exito = true;
                $resultado = '<div class="alert alert-success text-center" role="alert"><strong>' . $controlador->getDescripcion() . '</strong></div>';
                break;
            case 1:
                $resultado = '<div class="alert alert-warning text-center" role="alert"><strong>' . $controlador->getDescripcion() . '</strong></div>';
                break;
            case 0:
                $resultado = '<div class="alert alert-danger text-center" role="alert"><strong>' . $controlador->getDescripcion() . '</strong></div>';
                break;
        }
    } else {
        
    }
} else {
    $resultado = '<div class="alert alert-danger text-center" role="alert"><strong>No se obtuvo la información del formulario</strong></div>';
}

$json[] = array('exito' => $exito, 'div' => $resultado);
echo json_encode($json);
