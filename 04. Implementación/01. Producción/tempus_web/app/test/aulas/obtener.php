<?php

require_once '../../principal/modelos/Constantes.php';
require_once '../../principal/modelos/AutoCargador.php';

AutoCargador::cargarModulos();

$aula = new Aula();
$aula->setIdAula(4);

if ($aula->obtener(FALSE, FALSE) == 2) {
    echo "<br> ID: " . $aula->getIdAula();
    echo "<br> NOMBRE: " . $aula->getNombre();
    echo "<br> SECTOR: " . $aula->getSector();
} else {
    echo "NO SE OBTUVO INFORMACION";
}

$aula->setIdAula(1);
if ($aula->obtener(TRUE, TRUE) == 2) {
    echo '<br>';
    echo "<br> ID: " . $aula->getIdAula();
    echo "<br> NOMBRE: " . $aula->getNombre();
    echo "<br> SECTOR: " . $aula->getSector();
    if ($aula->getClases()) {
        echo "<br> CLASES:";
        foreach ($aula->getClases() as $clase) {
            echo "<br>|___  " . $clase["idclase"] . " " . $clase["carrera"] . " " . $clase["asignatura"] . " " . $clase["desde"] . " " . $clase["hasta"] . " " . $clase["fechamod"];
        }
    } else {
        echo "<br> CLASES: no";
    }

    if ($aula->getMesas()) {
        echo "<br> MESAS:";
        foreach ($aula->getMesas() as $mesa) {
            echo "<br>|___  " . $mesa["idmesa"] . " / " . $mesa["asignatura"] . " / " . $mesa["carrera"];
        }
    } else {
        echo "<br> MESAS: no";
    }
} else {
    echo "NO SE OBTUVO INFORMACION";
}
