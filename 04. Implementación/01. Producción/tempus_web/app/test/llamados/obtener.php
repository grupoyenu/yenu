<?php

require_once '../../principal/modelos/Constantes.php';
require_once '../../principal/modelos/AutoCargador.php';

AutoCargador::cargarModulos();

$llamado = new Llamado();
$llamado->setIdLlamado(1);
if ($llamado->obtener() == 2) {
    $aula = $llamado->getAula();
    echo '<br>' . $llamado->getIdLlamado();
    echo '<br>' . $llamado->getFecha();
    echo '<br>' . $llamado->getHora();
    if ($aula) {
        echo "<br> ID: " . $aula->getIdAula();
        echo "<br> NOMBRE: " . $aula->getNombre();
        echo "<br> SECTOR: " . $aula->getSector();
    } else {
        echo '<br> AULA: sin asignar';
    }
    echo '<br>' . $llamado->getFechamod();
} else {
    echo "NO SE OBTUVO INFORMACION";
}
