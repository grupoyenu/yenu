<?php

require_once '../../principal/modelos/Constantes.php';
require_once '../../principal/modelos/AutoCargador.php';

AutoCargador::cargarModulos();

$aulas = new Aulas();

$campo = "sector";
$valor = "xxx";
$resultado = $aulas->buscar($campo, $valor);
echo $aulas->getDescripcion();

echo "<pre>";
var_dump($resultado);
echo "</pre>";

