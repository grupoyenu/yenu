<?php

/* SE INCLUYE EL ARCHIVO DE CONSTANTES Y EL AUTOLOAD */

require_once '../../principal/modelo/Constantes.php';
require_once '../../principal/modelo/AutoCargador.php';

/* SE REFERENCIAN LOS NAMESPACE */

use app\aula\controlador\ControladorAula;
use app\principal\modelo\AutoCargador;

AutoCargador::cargarModulos();

/* INICIALIZA LA SESION PARA GUARDAR LOG */

session_start();

$arreglo = array();
if (isset($_POST['nombre'])) {
    $nombre = $_POST['nombre'];
    $controlador = new ControladorAula();
    $resultado = $controlador->listarAulas($nombre);
    if ($resultado[0] == 2) {
        $aulas = $resultado[1];
        foreach ($aulas as $aula) {
            $id = $aula['id'];
            $sector = $aula['sector'];
            $nombre = $aula['nombre'];
            $arreglo[] = array('id' => $id, 'text' => "{$sector} - {$nombre}");
        }
    }
}

echo json_encode($arreglo);
