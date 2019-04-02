<?php

/* AUTOLOAD PARA INCLUIR LOS ARCHIVO NECESARIOS */

require_once '../controladores/Autoload.php';
$autoload = new Autoload();
$autoload->autoloadProcesa();

$div = '<h4 class="text-center p-4">BORRAR PERMISO</h4>';
$exito = false;
if (!empty($_POST)) {

    if ($_POST['idpermiso']) {
        $idpermiso = $_POST['idpermiso'];
        $controladorPermiso = new ControladorPermiso();
        $eliminacion = $controladorPermiso->borrar($idpermiso);
        $exito = ($eliminacion == 2) ? true : false;
        $class = Utilidades::obtenerClassCreacion($eliminacion);
        $div = $div . '<div ' . $class . ' role="alert">' . $controladorPermiso->getDescripcion() . '</div>';
    } else {
        /* NO SE RECIBE LA INFORMACION DESDE EL FORMULARIO  */
        $mensaje = "No se obtuvieron los datos obligatorios del formulario de búsqueda";
        $div = $div . '<div class="alert alert-danger text-center" role="alert">' . $mensaje . '</div>';
    }
} else {
    /* NO SE RECIBE LA INFORMACION DESDE EL FORMULARIO  */
    $mensaje = "No se obtuvieron los datos del formulario de búsqueda";
    $div = $div . '<div class="alert alert-danger text-center" role="alert">' . $mensaje . '</div>';
}

/* RETORNA EL ARREGLO JSON PARA MOSTRAR LA INFORMACION SEGUN CORRESPONDA */

$json[] = array('exito' => $exito, 'div' => $div);
echo json_encode($json);

