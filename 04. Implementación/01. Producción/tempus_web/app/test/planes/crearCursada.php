<?php

require_once '../../principal/modelos/Constantes.php';
require_once '../../principal/modelos/AutoCargador.php';

AutoCargador::cargarModulos();

$plan = new Plan();
$plan->setAsignatura(81);
$plan->setCarrera(72);

$lunes = new Clase(array(NULL, 1, '10:00', '12:00', 21, NULL));
$martes = new Clase(array(NULL, 2, '10:00', '11:00', 21, NULL));
$miercoles = new Clase(array(NULL, 3, '12:00', '14:00', 13, NULL));
$jueves = new Clase(array(NULL, 4, '12:00', '14:00', 21, NULL));
$viernes = new Clase(array(NULL, 5, '12:00', '14:00', 21, NULL));

$clases = array($lunes, $martes, $miercoles, $jueves, $viernes);
$plan->setClases($clases);

$creacion = $plan->crearClases();
echo "<br> Resultado: " . $creacion . " " . $plan->getDescripcion();

foreach ($plan->getClases() as $clase) {
    if ($clase->getDescripcion()) {
        echo "<br>" . $clase->getDescripcion();
    }
}


$dias = $plan->obtenerDiasCursada();
foreach ($dias as $dia) {
    if ($dia['dia'] == 3) {
        echo "salta";
        continue;
    }
    echo "<br>" . $dia['dia'];
}

if (array_search(4, $dias)) {
    echo "<br>EXISTE 3 EN EL ARRAY";
}

if (array_search(7, $dias)) {
    echo "<br>EXISTE 7 EN EL ARRAY";
} else {
    echo "<br>NO EXISTE 7 EN EL ARRAY";
}