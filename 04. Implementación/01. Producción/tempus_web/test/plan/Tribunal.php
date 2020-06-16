<?php

include_once '../../app/principal/modelo/Constantes.php';
include_once '../../app/principal/modelo/AutoCargador.php';

use app\docente\modelo\Docente as Docente;
use app\mesa\modelo\Tribunal as Tribunal;
use app\principal\modelo\AutoCargador as Cargador;

Cargador::cargarModulos();


$presidente = new Docente(NULL, 'Emanuel Marquez');
$vocal1 = new Docente(null, 'Jose');
$vocal2 = new Docente(null, 'Pedro');
$suplente = new Docente(null, 'Marcelo');


$tribunal = new Tribunal();

$tribunal->agregarDocente($presidente);
$tribunal->agregarDocente($vocal1);
$tribunal->agregarDocente($vocal2);
$tribunal->agregarDocente($vocal1);
$tribunal->agregarDocente($suplente);
$tribunal->agregarDocente(new Docente(NULL, 'Atomica'));

echo "<pre>";
var_dump($tribunal->getDocentes());
echo "</pre>";


$tribunal2 = new Tribunal();

echo " d " . (int)$tribunal2->obtenerDocente(FALSE, 0, NULL);

echo "<pre>";
var_dump($tribunal2->getDocentes());
echo "</pre>";
