<?php

/*
 * FORMULARIO -> PROCESABUSCARMESAS.PHP
 * JAVASCRIPT -> PROCESABUSCARMESAS.JS (AJAX)
 */

/* AUTOLOAD PARA INCLUIR LOS ARCHIVO NECESARIOS */

require_once '../controladores/Autoload.php';
$autoload = new Autoload();
$autoload->autoloadProcesa();

if ($_POST['radioMesas']) {

    /* SE RECIBE LA INFORMACION DESDE EL FORMULARIO  */

    $idmesa = $_POST['radioMesas'];
    $controladorMesa = new ControladorMesaExamen();
    $eliminacion = $controladorMesa->borrar($idmesa);
    switch ($eliminacion) {
        case 0:
            $class = 'class="alert alert-warning text-center"';
            break;
        case 1:
            $class = 'class="alert alert-danger text-center"';
            break;
        case 2:
            $class = 'class="alert alert-success text-center"';
            break;
        default:
            $class = 'class="alert alert-info text-center"';
            break;
    }
    $div = '<div ' . $class . ' role="alert">' . $controladorMesa->getDescripcion() . '</div>';
    
} else {
    $mensaje = "Procesa eliminación: No se obtuvieron los datos necesarios de la mesa de examen";
    $div = '<div class="alert alert-danger text-center" role="alert">' . $mensaje . '</div>';
}

echo $div;
