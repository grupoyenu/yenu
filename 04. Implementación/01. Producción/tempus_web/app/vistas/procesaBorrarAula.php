<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/* AUTOLOAD PARA INCLUIR LOS ARCHIVO NECESARIOS */
require_once '../controladores/Autoload.php';
$autoload = new Autoload();
$autoload->autoloadProcesa();

$div = '<h4 class="text-center p-4">BORRAR AULA</h4>';
$exito = false;
if (isset($_POST['idaula'])) {
    /* SE RECIBE LA INFORMACION DESDE EL FORMULARIO  */
    
    $idaula = $_POST['idaula'];
    $controladorAula = new ControladorAula();
    $eliminacion = $controladorAula->borrar($idaula);
    $exito = ($eliminacion == 2) ? true : false;
    $class = Utilidades::obtenerClassOperacion($eliminacion);
    $div = $div . '<div ' . $class . ' role="alert">' . $controladorPermiso->getDescripcion() . '</div>';
    
} else {
    /* NO SE RECIBE LA INFORMACION DESDE EL FORMULARIO  */

    $mensaje = "No se obtuvieron los datos del formulario de búsqueda";
    $div = $div . '<div class="alert alert-danger text-center" role="alert">' . $mensaje . '</div>';
}

/* RETORNA EL ARREGLO JSON PARA MOSTRAR LA INFORMACION SEGUN CORRESPONDA */

$json[] = array('exito' => $exito, 'div' => $div);
echo json_encode($json);
