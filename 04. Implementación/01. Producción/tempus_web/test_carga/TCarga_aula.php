<?php

include_once '../app/principal/modelo/Constantes.php';
include_once '../app/principal/modelo/AutoCargador.php';

use app\principal\modelo\Constantes;
use app\principal\modelo\AutoCargador as Cargador;
use app\aula\modelo\Aula;

Cargador::cargarModulos();

$aulas = array();
$aulas[] = new Aula(NULL, '01', 'A');
$aulas[] = new Aula(NULL, '02', 'A');
$aulas[] = new Aula(NULL, '03', 'A');
$aulas[] = new Aula(NULL, '04', 'A');
$aulas[] = new Aula(NULL, '05', 'A');
$aulas[] = new Aula(NULL, '06', 'A');
$aulas[] = new Aula(NULL, '07', 'A');
$aulas[] = new Aula(NULL, '08', 'A');
$aulas[] = new Aula(NULL, '09', 'A');
$aulas[] = new Aula(NULL, '10', 'A');
$aulas[] = new Aula(NULL, 'Laboratorio de hardware', 'A');
$aulas[] = new Aula(NULL, 'Laboratorio de software', 'A');
$aulas[] = new Aula(NULL, '01', 'B');
$aulas[] = new Aula(NULL, '02', 'B');
$aulas[] = new Aula(NULL, '03', 'B');
$aulas[] = new Aula(NULL, '04', 'B');
$aulas[] = new Aula(NULL, '05', 'B');
$aulas[] = new Aula(NULL, '06', 'B');
$aulas[] = new Aula(NULL, '07', 'B');
$aulas[] = new Aula(NULL, '08', 'B');
$aulas[] = new Aula(NULL, '09', 'B');
$aulas[] = new Aula(NULL, '10', 'B');
$aulas[] = new Aula(NULL, 'Sala de reuniones 01', 'B');
$aulas[] = new Aula(NULL, 'Sala de reuniones 02', 'B');
$aulas[] = new Aula(NULL, '01', 'C');
$aulas[] = new Aula(NULL, '02', 'C');
$aulas[] = new Aula(NULL, '03', 'C');
$aulas[] = new Aula(NULL, '04', 'C');
$aulas[] = new Aula(NULL, '05', 'C');
$aulas[] = new Aula(NULL, '06', 'C');
$aulas[] = new Aula(NULL, '07', 'C');
$aulas[] = new Aula(NULL, '08', 'C');
$aulas[] = new Aula(NULL, '09', 'C');
$aulas[] = new Aula(NULL, '10', 'C');
$aulas[] = new Aula(NULL, '01', 'D');
$aulas[] = new Aula(NULL, '02', 'D');
$aulas[] = new Aula(NULL, '03', 'D');
$aulas[] = new Aula(NULL, '04', 'D');
$aulas[] = new Aula(NULL, '05', 'D');
$aulas[] = new Aula(NULL, '06', 'D');
$aulas[] = new Aula(NULL, '07', 'D');
$aulas[] = new Aula(NULL, '08', 'D');
$aulas[] = new Aula(NULL, '09', 'D');
$aulas[] = new Aula(NULL, '10', 'D');
$aulas[] = new Aula(NULL, '01', 'E');
$aulas[] = new Aula(NULL, '02', 'E');
$aulas[] = new Aula(NULL, '03', 'E');
$aulas[] = new Aula(NULL, '04', 'E');
$aulas[] = new Aula(NULL, '05', 'E');
$aulas[] = new Aula(NULL, '06', 'E');
$aulas[] = new Aula(NULL, '07', 'E');
$aulas[] = new Aula(NULL, '08', 'E');
$aulas[] = new Aula(NULL, '09', 'E');
$aulas[] = new Aula(NULL, '10', 'E');
$aulas[] = new Aula(NULL, '01', 'F');
$aulas[] = new Aula(NULL, '02', 'F');
$aulas[] = new Aula(NULL, '03', 'F');
$aulas[] = new Aula(NULL, '04', 'F');
$aulas[] = new Aula(NULL, '05', 'F');
$aulas[] = new Aula(NULL, '06', 'F');
$aulas[] = new Aula(NULL, '07', 'F');
$aulas[] = new Aula(NULL, '08', 'F');
$aulas[] = new Aula(NULL, '09', 'F');
$aulas[] = new Aula(NULL, '10', 'F');
$aulas[] = new Aula(NULL, '01', 'G');
$aulas[] = new Aula(NULL, '02', 'G');
$aulas[] = new Aula(NULL, '03', 'G');
$aulas[] = new Aula(NULL, '04', 'G');
$aulas[] = new Aula(NULL, '05', 'G');
$aulas[] = new Aula(NULL, '06', 'G');
$aulas[] = new Aula(NULL, '07', 'G');
$aulas[] = new Aula(NULL, '08', 'G');
$aulas[] = new Aula(NULL, '09', 'G');
$aulas[] = new Aula(NULL, '10', 'G');
$aulas[] = new Aula(NULL, '01', 'H');
$aulas[] = new Aula(NULL, '02', 'H');
$aulas[] = new Aula(NULL, '03', 'H');
$aulas[] = new Aula(NULL, '04', 'H');
$aulas[] = new Aula(NULL, '05', 'H');
$aulas[] = new Aula(NULL, '06', 'H');
$aulas[] = new Aula(NULL, '07', 'H');
$aulas[] = new Aula(NULL, '08', 'H');
$aulas[] = new Aula(NULL, '09', 'H');
$aulas[] = new Aula(NULL, '10', 'H');
$aulas[] = new Aula(NULL, '01', 'I');
$aulas[] = new Aula(NULL, '02', 'I');
$aulas[] = new Aula(NULL, '03', 'I');
$aulas[] = new Aula(NULL, '04', 'I');
$aulas[] = new Aula(NULL, '05', 'I');
$aulas[] = new Aula(NULL, '06', 'I');
$aulas[] = new Aula(NULL, '07', 'I');
$aulas[] = new Aula(NULL, '08', 'I');
$aulas[] = new Aula(NULL, '09', 'I');
$aulas[] = new Aula(NULL, '10', 'I');
$aulas[] = new Aula(NULL, '01', 'J');
$aulas[] = new Aula(NULL, '02', 'J');
$aulas[] = new Aula(NULL, '03', 'J');
$aulas[] = new Aula(NULL, '04', 'J');
$aulas[] = new Aula(NULL, '05', 'J');
$aulas[] = new Aula(NULL, '06', 'J');
$aulas[] = new Aula(NULL, '07', 'J');
$aulas[] = new Aula(NULL, '08', 'J');
$aulas[] = new Aula(NULL, '09', 'J');
$aulas[] = new Aula(NULL, '10', 'J');
$aulas[] = new Aula(NULL, 'Salon de usos multiples', 'J');

//$aulas[] = new Aula(NULL, '', '');


$url = Constantes::ROOT . "\\test_carga\\" . date("Ymd") . "_TCAula.txt";
if (file_exists($url)) {
    unlink($url);
}
$file = fopen($url, 'w');
$cantidad = COUNT($aulas);
$linea01 = "== TEST DE CARGA PARA LA TABLA DE AULAS." . PHP_EOL;
$linea02 = "== Grupo de desarrollo: YENÚ." . PHP_EOL;
$linea03 = "== Proyecto: Tempus." . PHP_EOL;
$linea04 = "== Fecha: " . date("Y/m/d") . "." . PHP_EOL;
$linea05 = "== Total de aulas: {$cantidad}." . PHP_EOL;
fwrite($file, $linea01);
fwrite($file, $linea02);
fwrite($file, $linea03);
fwrite($file, $linea04);
fwrite($file, $linea05);
fwrite($file, PHP_EOL);

$creados = 0;
for ($pos = 0; $pos < $cantidad; $pos++) {
    $aula = $aulas[$pos];
    $nombre = $aula->getSector();
    $sector = $aula->getNombre();
    $indice = str_pad($pos, 3, "0", STR_PAD_LEFT);
    $resultado = $aula->crear();
    $codigo = (int) $resultado[0];
    $mensaje = $resultado[1];
    $estado = ($codigo == 2) ? "OK" : "NO";
    $creados = ($codigo == 2) ? ($creados + 1) : $creados;
    $linea = "[$indice][$estado][$sector][$nombre] -- [$codigo][$mensaje]" . PHP_EOL;
    fwrite($file, $linea);
}

fwrite($file, PHP_EOL);
fwrite($file, "== Total de registros creados o existentes: $creados." . PHP_EOL);
fwrite($file, "== Total de registros no creados: " . ($cantidad - $creados) . "." . PHP_EOL);

echo "<BR> PROCESO FINALIZADO";
