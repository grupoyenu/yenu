<?php

/* SE INCLUYE EL ARCHIVO DE CONSTANTES Y EL AUTOLOAD */

require_once '../../principal/modelo/Constantes.php';
require_once '../../principal/modelo/AutoCargador.php';

/* SE REFERENCIAN LOS NAMESPACE */

use app\cursada\controlador\ControladorCursada;
use app\cursada\modelo\Cursada;
use app\cursada\modelo\Clase;
use app\principal\controlador\ControladorHTML;
use app\principal\modelo\AutoCargador;
use app\principal\modelo\Log;

AutoCargador::cargarModulos();

/* INICIALIZA LA SESION PARA GUARDAR EL LOG */
session_start();


Log::guardar("ERROR", "AAAAAA");
$exito = FALSE;
if (isset($_POST['cbBorrarClases'])) {
    $cursada = new Cursada();
    $agregada = TRUE;
    foreach ($_POST['cbBorrarClases'] as $dia) {
        $idClase = ($_POST['idClase' . $dia] > 0) ? $_POST['idClase' . $dia] : NULL;
        $clase = new Clase($id);
        $cargada = $cursada->agregarClase($clase);
        $agregada = ($cargada) ? $agregada : FALSE;
    }
    if ($agregada) {
        $controlador = new ControladorCursada();
        $eliminacion = $controlador->borrar($cursada);
        $codigo = $eliminacion[0];
        $mensaje = $eliminacion[1];
        $exito = ($codigo == 2) ? TRUE : FALSE;
        $resultado = ControladorHTML::mostrarAlertaResultadoOperacion($eliminacion, $mensaje);
    } else {
        $codigo = 1;
        $mensaje = "Una o más clases no se pudieron agregar a la cursada";
        $resultado = ControladorHTML::mostrarAlertaResultadoOperacion($codigo, $mensaje);
    }
} else {
    $mensaje = "No se recibió la información desde el formulario";
    $resultado = ControladorHTML::mostrarAlertaResultadoOperacion(0, $mensaje);
}

/* RETORNA EL ARREGLO JSON PARA MOSTRAR LA INFORMACION SEGUN CORRESPONDA */
$json[] = array('exito' => $exito, 'resultado' => $resultado);
echo json_encode($json);

