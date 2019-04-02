<?php

/*
 * FORMULARIO -> FORMCREARROL.PHP
 * JAVASCRIPT -> CREARROL.JS (AJAX)
 * RESULTADO  -> JSON [BOOLEAN, DIV]
 * 
 */

/* AUTOLOAD PARA INCLUIR LOS ARCHIVO NECESARIOS */

require_once '../controladores/Autoload.php';
$autoload = new Autoload();
$autoload->autoloadProcesa();

$exito = false;
if (isset($_POST['nombre']) && isset($_POST['permisos'])) {
    /* SE RECIBE LA INFORMACION DESDE EL FORMULARIO  */

    $nombre = $_POST['nombre'];
    $permisos = $_POST['permisos'];
    $controladorRol = new ControladorRol();
    $creacion = $controladorRol->crear($nombre, $permisos);
    $exito = ($creacion == 2) ? true : false;
    $class = Utilidades::obtenerClassCreacion($creacion);
    $div = '<div ' . $class . ' role="alert">' . $controladorRol->getDescripcion() . '</div>';
} else {
    /* NO SE RECIBE LA INFORMACION DESDE EL FORMULARIO  */

    $mensaje = "No se obtuvieron los datos del formulario de creación";
    $div = '<div class="alert alert-danger text-center" role="alert">' . $mensaje . '</div>';
}

/* RETORNA EL ARREGLO JSON PARA MOSTRAR LA INFORMACION SEGUN CORRESPONDA */

$json[] = array('exito' => $exito, 'div' => $div);
echo json_encode($json);
