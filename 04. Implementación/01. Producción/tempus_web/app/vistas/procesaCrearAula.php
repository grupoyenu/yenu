<?php

/*
 * FORMULARIO -> FORMCREARAULA.PHP
 * JAVASCRIPT -> CREARAULA.JS (AJAX)
 * RESULTADO  -> JSON [BOOLEAN, DIV]
 */

/* AUTOLOAD PARA INCLUIR LOS ARCHIVO NECESARIOS */

require_once '../controladores/Autoload.php';
$autoload = new Autoload();
$autoload->autoloadProcesa();

$exito = false;
if (!empty($POST)) {
    /* SE RECIBE LA INFORMACION DESDE EL FORMULARIO  */

    $sector = $_POST['sector'];
    $nombre = $_POST['nombre'];
    $controladorAula = new ControladorAula();
    $creacion = $controladorAula->crear($sector, $nombre);
    $exito = ($creacion == 2) ? true : false;
    $class = Utilidades::obtenerClassCreacion($creacion);
    $div = '<div ' . $class . ' role="alert">' . $controladorAula->getDescripcion() . '</div>';
} else {
    /* NO SE RECIBE LA INFORMACION DESDE EL FORMULARIO  */

    $mensaje = "No se obtuvieron los datos del formulario de creación";
    $div = '<div class="alert alert-danger text-center" role="alert">' . $mensaje . '</div>';
}
/* RETORNA EL ARREGLO JSON PARA MOSTRAR LA INFORMACION SEGUN CORRESPONDA */

$json[] = array('exito' => $exito, 'div' => $div);
echo json_encode($json);
