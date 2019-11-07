<?php

require_once '../../principal/modelos/Constantes.php';
require_once '../../principal/modelos/AutoCargador.php';

AutoCargador::cargarModulos();

$carreras = array();

$carreras[] = array(54, "Analista de sistemas");
$carreras[] = array(43, "Ingenieria en telefe");
$carreras[] = array(54, "Ingenieria en trece");
$carreras[] = array(16, "Analista de sistemas");

foreach ($carreras as $datos) {
    $carrera = new Carrera($datos[0], $datos[1]);
    $creacion = $carrera->crear();
    if ($creacion == 2) {
        echo "<br>" . $carrera->getDescripcion() . " " . $carrera->getCodigo();
    } else {
        echo "<br>" . $carrera->getDescripcion() . " " . $creacion;
    }
}
