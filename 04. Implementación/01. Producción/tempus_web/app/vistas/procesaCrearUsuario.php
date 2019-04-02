<?php

/* AUTOLOAD PARA INCLUIR LOS ARCHIVO NECESARIOS */

require_once '../controladores/Autoload.php';
$autoload = new Autoload();
$autoload->autoloadProcesa();

$exito = false;
if (!empty($POST)) {
    /* SE RECIBE LA INFORMACION DESDE EL FORMULARIO  */
    
    $email = $_POST['email'];
    $nombre = $POST['nombre'];
    $idrol = $_POST['idrol'];
    
    if($email && $nombre && $idrol) {
        /* SE RECIBE LA INFORMACION DESDE EL FORMULARIO  */
        
        $controladorUsuario = new ControladorUsuario();
        $creacion = $controladorUsuario->crear($email, $nombre, $rol);
        $exito = ($creacion == 2) ? true : false;
        $class = Utilidades::obtenerClassCreacion($creacion);
        $div = '<div ' . $class . ' role="alert">' . $controladorUsuario->getDescripcion() . '</div>';
        
    } else {
        /* NO SE RECIBE PARTE DE LA INFORMACION DESDE EL FORMULARIO  */

        $mensaje = "No se obtuvieron todos los datos obligatorios del formulario de creación";
        $div = '<div class="alert alert-danger text-center" role="alert">' . $mensaje . '</div>';
    }
    
} else {
    /* NO SE RECIBE LA INFORMACION DESDE EL FORMULARIO  */

    $mensaje = "No se obtuvieron los datos del formulario de creación";
    $div = '<div class="alert alert-danger text-center" role="alert">' . $mensaje . '</div>';
}

/* RETORNA EL ARREGLO JSON PARA MOSTRAR LA INFORMACION SEGUN CORRESPONDA */

$json[] = array('exito' => $exito, 'div' => $div);
echo json_encode($json);