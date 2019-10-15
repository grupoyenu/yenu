<?php

/* AUTOLOAD PARA INCLUIR LOS ARCHIVO NECESARIOS */

require_once '../../principal/modelos/Constantes.php';
require_once '../../principal/modelos/AutoCargador.php';

AutoCargador::cargarModulos();

$exito = false;
if (!empty($_POST)) {
    $carrera = $_POST['carrera'];
    $id = $_POST['idasignatura'];
    $asignatura = $_POST['asignatura'];
    $anio = $_POST['anio'];
    $controlador = new ControladorCarreras();
    if ($id) {
        /* SE INDICO UNA ASIGNATURA QUE NO SE ENCUENTRA EN EL ARREGLO DE ASIGNATURAS */
        $creacion = $controlador->agregarAsignatura($carrera, $id, $anio);
    } else {
        /* SE INDICO UNA ASIGNATURA QUE SE ENCUENTRA EN EL ARREGLO DE ASIGNATURAS */
        $resultado = "CREAR " . $asignatura . "/" . $anio;
    }

    switch ($creacion) {
        case 2:
            $exito = true;
            $resultado = '
                <div class="alert alert-success text-center" role="alert">' . $controlador->getDescripcion() . '</div>
                <div class="card text-center">
                    <div class="card-header text-left">Detalle de la asociación</div>
                    <div class="card-body ">
                        <div class="form-row">
                            <label class="col-sm-2 col-form-label text-left">Carrera:</label>
                            <div class="col">
                                <input type="text" class="form-control mb-2" value="' . str_pad($carrera, 3, "0", STR_PAD_LEFT) . '"
                                           title = "Código de la carrera" readonly>
                            </div>
                            <label class="col-sm-2 col-form-label text-left">Asignatura:</label>
                            <div class="col">
                                <input type="text" class="form-control mb-2" value="' . $asignatura . '"
                                           title = "Nombre de la asignatura" readonly>
                            </div>
                        </div>
                        <div class="form-row">
                            <label class="col-sm-2 col-form-label text-left">Año:</label>
                            <div class="col">
                                <input type="text" class="form-control mb-2" value="' . $anio . '°"
                                           title = "Año en que se dicta" readonly>
                            </div>
                            <label class="col-sm-2 col-form-label text-left"></label>
                            <div class="col">
                            </div>
                        </div>
                    </div>
                </div>';
            break;
        case 1:
            $resultado = '<div class="alert alert-warning text-center" role="alert">' . $controlador->getDescripcion() . '</div>';
            break;
        case 0:
            $resultado = '<div class="alert alert-danger text-center" role="alert">' . $controlador->getDescripcion() . '</div>';
            break;
    }
} else {
    /* NO SE RECIBE LA INFORMACION DESDE EL FORMULARIO  */
    $mensaje = "No se obtuvieron los datos del formulario de creación";
    $resultado = '<div class="alert alert-danger text-center" role="alert">' . $mensaje . '</div>';
    Log::escribirLineaError("No se recibio el arreglo de POST");
}

/* RETORNA EL ARREGLO JSON PARA MOSTRAR LA INFORMACION SEGUN CORRESPONDA */

$json[] = array('exito' => $exito, 'div' => $resultado);
echo json_encode($json);
