<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once '../../principal/modelos/Constantes.php';
require_once '../../principal/modelos/AutoCargador.php';

AutoCargador::cargarModulos();

$consulta = "SELECT idasignatura FROM asignatura WHERE nombre = 'Analisis'";
$resultado = Conexion::getInstancia()->obtener($consulta);

if (gettype($resultado) == "array") {
    echo $resultado['idasignatura'];
} else {
    $me = ($resultado == 0) ? "Error" : "No existe";
    echo "NO EXISTE " . $me;
}