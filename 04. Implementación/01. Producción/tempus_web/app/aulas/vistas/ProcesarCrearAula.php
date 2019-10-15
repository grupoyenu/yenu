<?php

/* AUTOLOAD PARA INCLUIR LOS ARCHIVO NECESARIOS */

require_once '../../principal/modelos/Constantes.php';
require_once '../../principal/modelos/AutoCargador.php';

AutoCargador::cargarModulos();

$exito = false;
if (!empty($_POST)) {
    /* SE RECIBE LA INFORMACION DESDE EL FORMULARIO  */
    $sector = $_POST['sector'];
    $nombre = $_POST['nombre'];
    $controladorAula = new ControladorAula();
    $creacion = $controladorAula->crear($sector, $nombre);
    switch ($creacion) {
        case 2:
            $exito = true;
            $resultado = '
                <div class="alert alert-success text-center" role="alert">' . $controladorAula->getDescripcion() . '</div>
                <div class="card text-center">
                    <div class="card-header text-left">
                        Detalle del aula 
                    </div>
                    <div class="card-body ">
                        <div class="form-row">
                            <label for="nombre" class="col-sm-2 col-form-label text-left">Nombre:</label>
                            <div class="col">
                                <input type="text" class="form-control mb-2" value="' . $anio . '"
                                           title = "Año en que se dicta" readonly>
                            </div>
                            <label for="nombre" class="col-sm-2 col-form-label text-left">Año:</label>
                            <div class="col">
                                <input type="text" class="form-control mb-2" value="' . $anio . '"
                                           title = "Año en que se dicta" readonly>
                            </div>
                        </div>
                    </div>
                </div>';
            break;
        case 1:
            $resultado = '<div class="alert alert-warning text-center" role="alert">' . $controladorAula->getDescripcion() . '</div>';
            break;
        case 0:
            $resultado = '<div class="alert alert-danger text-center" role="alert">' . $controladorAula->getDescripcion() . '</div>';
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
