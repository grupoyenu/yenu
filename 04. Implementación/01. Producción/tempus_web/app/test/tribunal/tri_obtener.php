<?php

require_once '../../principal/modelos/Constantes.php';
require_once '../../principal/modelos/AutoCargador.php';

AutoCargador::cargarModulos();

$tribunal = new Tribunal();

$tribunal->setIdTribunal(92);

if ($tribunal->obtener() == 2) {
    $presidente = $tribunal->getPresidente();
    $vocal1 = $tribunal->getVocal1();
    $vocal2 = $tribunal->getVocal2();
    $suplente = $tribunal->getSuplente();

    echo "<br> IDEPRE: " . $presidente->getIdDocente();
    echo "<br> NOMPRE: " . $presidente->getNombre();
    echo "<br> IDEVOP: " . $vocal1->getIdDocente();
    echo "<br> NOMVOP: " . $vocal1->getNombre();
    if ($vocal2) {
        echo "<br> IDEVOS: " . $vocal2->getIdDocente();
        echo "<br> NOMVOS: " . $vocal2->getNombre();
        if ($suplente) {
            echo "<br> IDESUP: " . $suplente->getIdDocente();
            echo "<br> NOMSUP: " . $suplente->getNombre();
        }
    }
} else {
    echo "NO SE OBTUVO INFORMACION";
}

