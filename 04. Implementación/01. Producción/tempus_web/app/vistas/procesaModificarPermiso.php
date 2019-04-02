<?php

/* AUTOLOAD PARA INCLUIR LOS ARCHIVO NECESARIOS */

require_once '../controladores/Autoload.php';
$autoload = new Autoload();
$autoload->autoloadProcesa();

$exito = false;
if (!empty($_POST)) {
    
    $idpermiso = $_POST['idpermiso'];
    $nombre = $_POST['nombre'];

    if ($idpermiso && $nombre) {

        $controladorPermiso = new ControladorPermiso();
        $modificacion = $controladorPermiso->modificar($idpermiso, $nombre);
        $exito = ($modificacion == 2) ? true : false;
        $class = Utilidades::obtenerClassCreacion($modificacion);
        $div = '<div ' . $class . ' role="alert">' . $controladorPermiso->getDescripcion() . '</div>';
    } else {
        /* NO SE RECIBE PARTE DE LA INFORMACION DESDE EL FORMULARIO  */
        
        $mensaje = "No se obtuvieron todos los datos obligatorios del formulario de modificación";
        $div = '<div class="alert alert-danger text-center" role="alert">' . $mensaje . '</div>';
    }
} else {
    /* NO SE RECIBE LA INFORMACION DESDE EL FORMULARIO  */

    $mensaje = "No se obtuvieron los datos del formulario de modificación";
    $div = '<div class="alert alert-danger text-center" role="alert">' . $mensaje . '</div>';
}


$json[] = array('exito' => $exito, 'div' => $div);
echo json_encode($json);
