<?php

/* AUTOLOAD PARA INCLUIR LOS ARCHIVO NECESARIOS */

require_once '../controladores/Autoload.php';
$autoload = new Autoload();
$autoload->autoloadProcesa();

$exito = false;
if (isset($_POST['nombre'])) {
    /* SE RECIBE LA INFORMACION DESDE EL FORMULARIO  */
    
    $nombre = $_POST['nombre'];
    $controladorPermiso = new ControladorPermiso();
    $creacion = $controladorPermiso->crear($nombre);
    $exito = ($creacion == 2) ? true : false;
    $class = Utilidades::obtenerClassCreacion($creacion);
    $div = '<div ' . $class . ' role="alert">' . $controladorPermiso->getDescripcion() . '</div>';
} else {
    /* NO SE RECIBE LA INFORMACION DESDE EL FORMULARIO  */
    
    $mensaje = "No se obtuvieron los datos del formulario de creación";
    $div = '<div class="alert alert-danger text-center" role="alert">' . $mensaje . '</div>';
}
/* RETORNA EL ARREGLO JSON PARA MOSTRAR LA INFORMACION SEGUN CORRESPONDA */

$json[] = array('exito' => $exito, 'div' => $div);
echo json_encode($json);
