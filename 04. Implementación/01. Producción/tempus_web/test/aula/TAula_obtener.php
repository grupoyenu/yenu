<?php

include_once '../../app/principal/modelos/Constantes.php';
include_once '../../app/principal/modelos/AutoCargador.php';

use modelos\AutoCargador as Cargador;
use modelos\Aula as Aula;

Cargador::cargarModulos();

$id = 10;
$aula = new Aula($id);
$resultado = $aula->obtenerPorIdentificador();

if ($resultado[0] == 2) {
    echo "<br>" . $resultado[1];
    echo "<br> Identificador: " . $aula->getIdAula();
    echo "<br> Sector: " . $aula->getSector();
    echo "<br> Nombre: " . $aula->getNombre();
} else {
    echo "<br>" . $resultado[1];
}
