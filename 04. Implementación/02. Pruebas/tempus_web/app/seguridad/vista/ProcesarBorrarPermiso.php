<?php

/* SE INCLUYE EL ARCHIVO DE CONSTANTES Y EL AUTOLOAD */

require_once '../../principal/modelo/Constantes.php';
require_once '../../principal/modelo/AutoCargador.php';

/* SE REFERENCIAN LOS NAMESPACE */

use app\seguridad\controlador\ControladorPermiso;
use app\principal\controlador\ControladorHTML;
use app\principal\modelo\AutoCargador;

AutoCargador::cargarModulos();

/* INICIALIZA LA SESION PARA GUARDAR EL LOG */

session_start();

/* INICIO DEL CODIGO PROPIO DEL ARCHIVO */

if (isset($_POST['modalIdPermiso'])) {
    $idPermiso = $_POST['modalIdPermiso'];
    $controlador = new ControladorPermiso();
    $eliminacion = $controlador->borrar($idPermiso);
    $codigo = $eliminacion[0];
    $mensaje = $eliminacion[1];
    $resultado = ControladorHTML::mostrarAlertaResultadoOperacion($codigo, $mensaje);
} else {
    $mensaje = "No se recibió la información desde el formulario";
    $resultado = ControladorHTML::mostrarAlertaResultadoOperacion(0, $mensaje);
}

echo $resultado;
