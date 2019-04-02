<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$exito = false;

if (!empty($_POST)) {
    /* SE RECIBE LA INFORMACION DESDE EL FORMULARIO  */
    
    require_once '../controladores/Autoload.php';
    $autoload = new Autoload();
    $autoload->autoloadProcesa();

    $idaula = $_POST['idaula'];
    $sector = $_POST['sector'];
    $nombre = $_POST['nombre'];
    
    $controladorAula = new ControladorAula();
    $modificacion = $controladorAula->modificar($idaula, $sector, $nombre);
    
    switch ($modificacion) {
        case 0:
            $class = 'class="alert alert-warning text-center"';
            break;
        case 1:
            $class = 'class="alert alert-danger text-center"';
            break;
        case 2:
            $exito = true;
            $class = 'class="alert alert-success text-center"';
            break;
        default:
            $class = 'class="alert alert-info text-center"';
            break;
    }
    $div = '<div ' . $class . ' role="alert">' . $controladorAula->getDescripcion() . '</div>';
} else {
    /* NO SE RECIBE LA INFORMACION DESDE EL FORMULARIO  */
    $mensaje = "No se obtuvieron los datos del formulario de modificación";
    $div = '<div class="alert alert-danger text-center" role="alert">' . $mensaje . '</div>';
}

$json[] = array('exito' => $exito, 'div' => $div);
echo json_encode($json);
