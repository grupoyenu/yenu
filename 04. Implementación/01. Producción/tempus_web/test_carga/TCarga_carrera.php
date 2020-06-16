<?php

include_once '../app/principal/modelo/Constantes.php';
include_once '../app/principal/modelo/AutoCargador.php';

use app\principal\modelo\Constantes;
use app\principal\modelo\AutoCargador as Cargador;
use app\carrera\modelo\Carrera;

Cargador::cargarModulos();

$carreras = array();
$carreras[] = new Carrera('001', 'Licenciatura en administracion', 'Licenciatura en administracion');
$carreras[] = new Carrera('002', 'Tecnicatura universitaria en gestion de las organizaciones', 'Tecnicatura universitaria en gestion de las organizaciones');
$carreras[] = new Carrera('003', 'Profesorado en economia y gestion de organizaciones', 'Profesorado en economia y gestion de organizaciones');
$carreras[] = new Carrera('004', 'Profesorado en matemática', 'Profesorado en matemática');
$carreras[] = new Carrera('005', 'Licenciatura en comunicacion social', 'Licenciatura en comunicacion social');
$carreras[] = new Carrera('006', 'Licenciatura en comunicacion audiovisual', 'Licenciatura en comunicacion audiovisual');
$carreras[] = new Carrera('007', 'Profesorado para la educacion inicial', 'Profesorado para la educacion inicial');
$carreras[] = new Carrera('008', 'Profesorado en ciencias de la educacion', 'Profesorado en ciencias de la educacion');
$carreras[] = new Carrera('009', 'Profesorado para la educacion primaria', 'Profesorado para la educacion primaria');
$carreras[] = new Carrera('010', 'Licenciatura en enfermeria', 'Licenciatura en enfermeria');
$carreras[] = new Carrera('011', 'Tecnicatura universitaria en acompañamiento terapeutico', 'Tecnicatura universitaria en acompañamiento terapeutico');
$carreras[] = new Carrera('012', 'Enfermeria universitaria', 'Enfermeria universitaria');
$carreras[] = new Carrera('013', 'Licenciatura en geografia. Ciclo de Licenciatura', 'Licenciatura en geografia. Ciclo de Licenciatura');
$carreras[] = new Carrera('014', 'Licenciatura en geografia', 'Licenciatura en geografia');
$carreras[] = new Carrera('015', 'Profesorado en geografia', 'Profesorado en geografia');
$carreras[] = new Carrera('016', 'Profesorado en historia', 'Profesorado en historia');
$carreras[] = new Carrera('017', 'Tecnicatura universitaria en seguridad e higiene en el trabajo', 'Tecnicatura universitaria en seguridad e higiene en el trabajo');
$carreras[] = new Carrera('018', 'Tecnicatura universitaria en petróleo', 'Tecnicatura universitaria en petróleo');
$carreras[] = new Carrera('019', 'Licenciatura en higiene y seguridad en el trabajo', 'Licenciatura en higiene y seguridad en el trabajo');
$carreras[] = new Carrera('020', 'Ingeniria electromecánica', 'Ingeniria electromecánica');
$carreras[] = new Carrera('021', 'Tecnicatura universitaria en energia', 'Tecnicatura universitaria en energia');
$carreras[] = new Carrera('022', 'Tecnicatura universitaria en minas', 'Tecnicatura universitaria en minas');
$carreras[] = new Carrera('023', 'Ingeniería química', 'Ingeniería química');
$carreras[] = new Carrera('024', 'Licenciatura en letras', 'Licenciatura en letras');
$carreras[] = new Carrera('025', 'Profesorado en letras', 'Profesorado en letras');
$carreras[] = new Carrera('026', 'Licenciatura en psicopedagogía', 'Licenciatura en psicopedagogía');
$carreras[] = new Carrera('027', 'Ingeniería en recursos naturales renovables', 'Ingeniería en recursos naturales renovables');
$carreras[] = new Carrera('028', 'Tecnicatura universitaria en recursos naturales renovables. Producción Agropecuaria', 'Tecnicatura universitaria en recursos naturales renovables. Producción Agropecuaria');
$carreras[] = new Carrera('029', 'Tecnicatura universitaria en recursos naturales renovables. Producción Frutihortícola', 'Tecnicatura universitaria en recursos naturales renovables. Producción Frutihortícola');
$carreras[] = new Carrera('030', 'Tecnicatura universitaria en recursos naturales renovables. Producción Acuícola', 'Tecnicatura universitaria en recursos naturales renovables. Producción Acuícola');
$carreras[] = new Carrera('031', 'Analista de sistemas', 'Analista de sistemas');
$carreras[] = new Carrera('032', 'Tecnicatura Universitaria en desarrollo web', 'Tecnicatura Universitaria en desarrollo web');
$carreras[] = new Carrera('033', 'Tecnicatura universitaria en redes de computadoras', 'Tecnicatura universitaria en redes de computadoras');
$carreras[] = new Carrera('034', 'Ingeniería en sistemas', 'Ingeniería en sistemas');
$carreras[] = new Carrera('035', 'Licenciatura en sistemas', 'Licenciatura en sistemas');
$carreras[] = new Carrera('036', 'Licenciatura en trabajo social', 'Licenciatura en trabajo social');
$carreras[] = new Carrera('037', 'Tecnicatura universitaria en turismo', 'Tecnicatura universitaria en turismo');
$carreras[] = new Carrera('038', 'Licenciatura en turismo', 'Licenciatura en turismo');
$carreras[] = new Carrera('039', ' Profesorado en educacion especial', 'Profesorado en educacion especial');

// $careras[]= new Carrera('', '', '');

$url = Constantes::ROOT . "\\test_carga\\" . date("Ymd") . "_TCCarrera.txt";
if (file_exists($url)) {
    unlink($url);
}
$file = fopen($url, 'w');
$cantidad = COUNT($carreras);
$linea01 = "== TEST DE CARGA PARA LA TABLA DE CARRERAS." . PHP_EOL;
$linea02 = "== Grupo de desarrollo: YENÚ." . PHP_EOL;
$linea03 = "== Proyecto: Tempus." . PHP_EOL;
$linea04 = "== Fecha: " . date("Y/m/d") . "." . PHP_EOL;
$linea05 = "== Total de carreras: {$cantidad}." . PHP_EOL;
fwrite($file, $linea01);
fwrite($file, $linea02);
fwrite($file, $linea03);
fwrite($file, $linea04);
fwrite($file, $linea05);
fwrite($file, PHP_EOL);

$creados = 0;
for ($pos = 0; $pos < $cantidad; $pos++) {
    $carrera = $carreras[$pos];
    $id = $carrera->getId();
    $nombreCorto = $carrera->getNombreCorto();
    $nombreLargo = $carrera->getNombreLargo();
    $indice = str_pad($pos, 3, "0", STR_PAD_LEFT);
    $resultado = $carrera->crear();
    $codigo = (int) $resultado[0];
    $mensaje = $resultado[1];
    $estado = ($codigo == 2) ? "OK" : "NO";
    $creados = ($codigo == 2) ? ($creados + 1) : $creados;
    $linea = "[$indice][$estado][$id][$nombreCorto][$nombreLargo] -- [$codigo][$mensaje]" . PHP_EOL;
    fwrite($file, $linea);
}

fwrite($file, PHP_EOL);
fwrite($file, "== Total de registros creados o existentes: $creados." . PHP_EOL);
fwrite($file, "== Total de registros no creados: " . ($cantidad - $creados) . "." . PHP_EOL);


echo "<BR> PROCESO FINALIZADO";
