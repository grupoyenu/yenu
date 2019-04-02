<?php

include_once '../modelos/Conexion.php';




$arreglo = array();

$arreglo[1][] = array('nombre' => "CUS", 'inicio' => "16:00", 'fin' => "18:00");
$arreglo[1][] = array('nombre' => "ICC", 'inicio' => "18:00", 'fin' => "20:00");

$arreglo[3] = array('nombre' => "CUS", 'inicio' => "16:00", 'fin' => "18:00");
$arreglo[3] = array('nombre' => "ICC", 'inicio' => "18:00", 'fin' => "20:00");

echo "<pre>";
var_dump($arreglo);
echo "</pre>";

/*
$arreglo = NULL;



if(!empty($arreglo)) {
    echo "<br> NO ES NULO";
}
echo "<br>RETORNAR";


$dias = array();
$dias[2]= "eeee";
var_dump($dias);


$r = isset($v) ?: 'No Value';

echo "<br>".$r;


$inicio = "12:50";
$fin = "12:40";


$horaInicio = substr($inicio, 0, 2);
$horaFin = substr($fin, 0, 2);

echo $inicio." < ".$fin.": ";
if ($horaInicio < $horaFin) {
    echo "true";
} else {
    if ($horaInicio == $horaFin) {
        $minutosInicio = substr($inicio, 3, 2);
        $minutosFin = substr($fin, 3, 2);
        echo ($minutosInicio < $minutosFin) ? "true" : "false";
    }
    return "false";
}

 */