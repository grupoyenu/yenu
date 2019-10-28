<?php

require_once '../../principal/modelos/Constantes.php';
require_once '../../principal/modelos/AutoCargador.php';

AutoCargador::cargarModulos();


/* ASIGNATURA SIN IDENTIFICADOR */
$asignaturaUno = new Asignatura();
if ($asignaturaUno->obtener() == 2) {
    echo "SE OBTUVO LA INFORMACION DE LA ASIGNATURA";
} else {
    echo "NO SE OBTUVO INFORMACION: " . $asignaturaUno->getDescripcion();
}

$asignaturaDos = new Asignatura();
$asignaturaDos->setIdAsignatura(82);
if ($asignaturaDos->obtener() == 2) {
    echo '<br><br>SE OBTUVO INFORMACION DE LA ASIGNATURA';
    echo "<br> ID: " . $asignaturaDos->getIdAsignatura();
    echo "<br> NOMBRE: " . $asignaturaDos->getNombre();
} else {
    echo"<br>No se obtuvo informacion: " . $asignaturaDos->getDescripcion();
}

$asignaturaTres = new Asignatura();
$asignaturaTres->setIdAsignatura(4956);
if ($asignaturaTres->obtener() == 2) {
    echo '<br><br>SE OBTUVO INFORMACION DE LA ASIGNATURA';
    echo "<br> ID: " . $asignaturaTres->getIdAsignatura();
    echo "<br> NOMBRE: " . $asignaturaTres->getNombre();
} else {
    echo"<br>No se obtuvo informacion: " . $asignaturaTres->getDescripcion();
}
