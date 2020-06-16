<?php

include_once '../app/principal/modelo/Constantes.php';
include_once '../app/principal/modelo/AutoCargador.php';

use app\principal\modelo\Constantes;
use app\principal\modelo\AutoCargador as Cargador;
use app\asignatura\modelo\Asignatura;

Cargador::cargarModulos();

$asignaturas = array();
$asignaturas[] = new Asignatura(NULL, 'Algebra', 'Algebra');
$asignaturas[] = new Asignatura(NULL, 'Análisis Matemático 1', 'Análisis Matemático 1');
$asignaturas[] = new Asignatura(NULL, 'Introducción al conocimiento cientifico', 'Introducción al conocimiento cientifico');
$asignaturas[] = new Asignatura(NULL, 'Resolución de problemas y algoritmos', 'Resolución de problemas y algoritmos');
$asignaturas[] = new Asignatura(NULL, 'Matemática discreta', 'Matemática discreta');
$asignaturas[] = new Asignatura(NULL, 'Organizacion de las computadoras', 'Organizacion de las computadoras');
$asignaturas[] = new Asignatura(NULL, 'Programacion orientada a objetos', 'Programacion orientada a objetos');
$asignaturas[] = new Asignatura(NULL, 'Arquitectura de computadoras', 'Arquitectura de computadoras');
$asignaturas[] = new Asignatura(NULL, 'Requerimientos de software', 'Requerimientos de software');
$asignaturas[] = new Asignatura(NULL, 'Aspectos profesionales', 'Aspectos profesionales');
$asignaturas[] = new Asignatura(NULL, 'Ciencia universidad y sociedad', 'Ciencia universidad y sociedad');
$asignaturas[] = new Asignatura(NULL, 'Estructura de datos', 'Estructura de datos');
$asignaturas[] = new Asignatura(NULL, 'Sistemas operativos', 'Sistemas operativos');
$asignaturas[] = new Asignatura(NULL, 'Analisis y diseño del software', 'Analisis y diseño del software');
$asignaturas[] = new Asignatura(NULL, 'Bases de datos', 'Bases de datos');
$asignaturas[] = new Asignatura(NULL, 'Laboratorio de programacion', 'Laboratorio de programacion');
$asignaturas[] = new Asignatura(NULL, 'Redes y telecomunicaciones', 'Redes y telecomunicaciones');
$asignaturas[] = new Asignatura(NULL, 'Fundamentos de ciencias de la computación', 'Fundamentos de ciencias de la computación');
$asignaturas[] = new Asignatura(NULL, 'Validación y verificación del software', 'Validación y verificación del software');
$asignaturas[] = new Asignatura(NULL, 'Gestión de organizaciones', 'Gestión de organizaciones');
$asignaturas[] = new Asignatura(NULL, 'Estadistica 1', 'Estadistica 1');
$asignaturas[] = new Asignatura(NULL, 'Sistemas operativos distribuidos', 'Sistemas operativos distribuidos');
$asignaturas[] = new Asignatura(NULL, 'Gestión de proyectos de software', 'Gestión de proyectos de software');

//$asignaturas[] = new Asignatura(NULL, '', '');

$url = Constantes::ROOT . "\\test_carga\\" . date("Ymd") . "_TCAsignatura.txt";
if (file_exists($url)) {
    unlink($url);
}
$file = fopen($url, 'w');
$cantidad = COUNT($asignaturas);
$linea01 = "== TEST DE CARGA PARA LA TABLA DE ASIGNATURAS." . PHP_EOL;
$linea02 = "== Grupo de desarrollo: YENÚ." . PHP_EOL;
$linea03 = "== Proyecto: Tempus." . PHP_EOL;
$linea04 = "== Fecha: " . date("Y/m/d") . "." . PHP_EOL;
$linea05 = "== Total de asignaturas: {$cantidad}." . PHP_EOL;
fwrite($file, $linea01);
fwrite($file, $linea02);
fwrite($file, $linea03);
fwrite($file, $linea04);
fwrite($file, $linea05);
fwrite($file, PHP_EOL);

$creados = 0;
for ($pos = 0; $pos < $cantidad; $pos++) {
    $asignatura = $asignaturas[$pos];
    $nombreCorto = $asignatura->getNombreCorto();
    $nombreLargo = $asignatura->getNombreLargo();
    $indice = str_pad($pos, 3, "0", STR_PAD_LEFT);
    $resultado = $asignatura->crear();
    $codigo = (int) $resultado[0];
    $mensaje = $resultado[1];
    $estado = ($codigo == 2) ? "OK" : "NO";
    $creados = ($codigo == 2) ? ($creados + 1) : $creados;
    $linea = "[$indice][$estado][$nombreCorto][$nombreLargo] -- [$codigo][$mensaje]" . PHP_EOL;
    fwrite($file, $linea);
}

fwrite($file, PHP_EOL);
fwrite($file, "== Total de registros creados o existentes: $creados." . PHP_EOL);
fwrite($file, "== Total de registros no creados: " . ($cantidad - $creados) . "." . PHP_EOL);

echo "<BR> TEST DE CARGA ASIGNATURA: PROCESO FINALIZADO";
