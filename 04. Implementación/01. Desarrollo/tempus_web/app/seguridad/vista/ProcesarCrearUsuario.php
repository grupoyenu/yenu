<?php

/* SE INCLUYE EL ARCHIVO DE CONSTANTES Y EL AUTOLOAD */

require_once '../../principal/modelo/Constantes.php';
require_once '../../principal/modelo/AutoCargador.php';

/* SE REFERENCIAN LOS NAMESPACE */

use app\seguridad\controlador\ControladorUsuario;
use app\principal\controlador\ControladorHTML;
use app\principal\modelo\AutoCargador;

AutoCargador::cargarModulos();

/* INICIALIZA LA SESION PARA GUARDAR EL LOG */

session_start();

/* INICIO DEL CODIGO PROPIO DEL ARCHIVO */

$exito = FALSE;
if (isset($_POST['nombre'])) {
    $controlador = new ControladorUsuario();
    $nombre = $_POST['nombre'];
    $email = $_POST['correo'];
    $rol = $_POST['rol'];
    $estado = $_POST['estado'];
    $metodo = $_POST['metodo'];
    $clave = isset($_POST['clave']) ? $_POST['clave'] : "";
    $creacion = $controlador->crear($nombre, $email, $rol, $estado, $metodo, $clave);
    $codigo = $creacion[0];
    $mensaje = "{$nombre}: {$creacion[1]}";
    $exito = ($codigo == 2) ? TRUE : FALSE;
    $resultado = ControladorHTML::mostrarAlertaResultadoOperacion($codigo, $mensaje);
} else {
    $mensaje = "No se obtuvo la información desde el formulario";
    $resultado = ControladorHTML::mostrarAlertaResultadoOperacion(0, $mensaje);
}

/* RETORNA EL ARREGLO JSON PARA MOSTRAR LA INFORMACION SEGUN CORRESPONDA */

$json[] = array('exito' => $exito, 'resultado' => $resultado);
echo json_encode($json);
