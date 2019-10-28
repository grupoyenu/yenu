<?php

require_once '../../principal/modelos/Constantes.php';
require_once '../../principal/modelos/AutoCargador.php';

AutoCargador::cargarModulos();

$docente = new Docente();

$docente->setIdDocente(288);

if ($docente->obtener() == 2) {
    echo "<br>ID:" . $docente->getIdDocente();
    echo "<br>NOMBRE:" . $docente->getNombre();
} else {
    echo "<br> NO SE OBTUVO INFORMACION";
}
