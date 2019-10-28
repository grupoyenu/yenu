<?php

include_once '../../principal/modelos/Constantes.php';
include_once '../../principal/modelos/Log.php';
include_once '../../principal/modelos/Conexion.php';


$consulta = "SELECT * FROM clase where idclase = 97";

$resultado = Conexion::getInstancia()->obtener($consulta);

echo gettype($resultado);

if (gettype($resultado) == "array") {
    echo "biiien";
}