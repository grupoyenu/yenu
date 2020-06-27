<?php

include_once '../../app/principal/modelo/Constantes.php';
include_once '../../app/principal/modelo/AutoCargador.php';

use app\aula\modelo\Aula as Aula;
use app\docente\modelo\Docente as Docente;
use app\mesa\modelo\Llamado as Llamado;
use app\mesa\modelo\Tribunal as Tribunal;
use app\mesa\modelo\MesaExamen as MesaExamen;
use app\principal\modelo\AutoCargador as Cargador;

Cargador::cargarModulos();

$aula = new Aula(NULL, '11', 'A');
$primero = new Llamado(NULL, $aula, 'Activo', '2020-10-09', '10:00');
$segundo = new Llamado(NULL, $aula, 'Activo', '2020-10-11', '11:00');

$presidente = new Docente(NULL, 'Cecilia Carro');
$voca11 = new Docente(NULL, 'Andrea Salazar');
$tribunal = new Tribunal();
$tribunal->agregarDocente($presidente);
$tribunal->agregarDocente($voca11);

$mesa = new MesaExamen(NULL, null, $segundo, $tribunal);
$resultado = $mesa->crear();

echo "<br>RESULTADO {$resultado[0]} : {$resultado[1]}";
if ($resultado[0] == 2) {
    echo "<br> ID: " . $mesa->getId();
    echo "<br> Observacion: " . $mesa->getObservacion();
}
