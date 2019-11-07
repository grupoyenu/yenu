<?php

require_once '../../principal/modelos/Constantes.php';
require_once '../../principal/modelos/AutoCargador.php';

AutoCargador::cargarModulos();

$mesas[] = array(75, "Licenciatura en mesas", "Asignatura I");
$mesas[] = array(75, "Licenciatura en mesas", "Asignatura II");
$mesas[] = array(75, "Licenciatura en mesas", "Asignatura III");
$mesas[] = array(76, "Licenciatura en cursadas", "Asignatura I");
$mesas[] = array(76, "Licenciatura en cursadas", "Asignatura II");
$mesas[] = array(76, "Licenciatura en cursadas", "Asignatura III");

foreach ($mesas as $datos) {
    $carrera = new Carrera($datos[0], $datos[1]);
    if ($carrera->crear() == 2) {
        $asignatura = new Asignatura(NULL, $datos[2]);
        if ($asignatura->crear() == 2) {
            $idAsignatura = $asignatura->getIdAsignatura();
            $agregar = $carrera->agregarAsignatura($idAsignatura, 1);
            echo "Agregar: " . $agregar;
        } else {
            $errores[] = "No se creo " . $datos[2];
        }
    } else {
        $errores[] = "No se creo " . $datos[0] . " " . $datos[1] . " " . $datos[2];
    }
}

echo "<BR>";
var_dump($errores);
