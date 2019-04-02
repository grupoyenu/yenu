<?php

/* AUTOLOAD PARA INCLUIR LOS ARCHIVO NECESARIOS */

require_once '../controladores/Autoload.php';
$autoload = new Autoload();
$autoload->autoloadProcesa();

$exito = false;
if (!empty($POST)) {
    /* SE RECIBE LA INFORMACION DESDE EL FORMULARIO  */
    
    $codigoCarrera = $_POST['codigoCarrera'];
    $nombreCarrera = $_POST['nombreCarrera'];
    $nombreAsignatura = $_POST['nombreAsignatura'];
    $anio = $_POST['selectAnio'];

    if ($codigoCarrera && $nombreCarrera && $nombreAsignatura && $anio) {
        $carrera = new Carrera();
        $asignatura = new Asignatura();
        $carrera->constructor($codigoCarrera, $nombreCarrera);
        $asignatura->constructor($nombreAsignatura);
        $controladorPlan = new ControladorPlan();
        $creacion = $controladorPlan->crear($carrera, $asignatura, $anio);
        $exito = ($creacion == 2) ? true : false;
        $class = Utilidades::obtenerClassCreacion($creacion);
        echo '<div ' . $class . ' role="alert">' . $controladorPlan->getDescripcion() . '</div>';
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