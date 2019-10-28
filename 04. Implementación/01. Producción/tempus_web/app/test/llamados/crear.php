<?php

require_once '../../principal/modelos/Constantes.php';
require_once '../../principal/modelos/AutoCargador.php';


AutoCargador::cargarModulos();

$parametros = array(NULL, "23/10/2019", "10:30", 1, "25/10/2018");

$llamado = new Llamado($parametros);

echo "<br>ID:" . $llamado->getIdLlamado();
echo "<br>FECHA:" . $llamado->getFecha();
echo "<br>HORA:" . $llamado->getHora();
echo "<br>AULA:" . $llamado->getAula();
echo "<br>FECHA MOD:" . $llamado->getFechamod();

$creacion = $llamado->crear();

echo "<br> CREACION: " . $creacion . " " . $llamado->getDescripcion();

$llamado->setIdLlamado(4);
$llamadoa = $llamado->obtener();
var_dump($llamadoa);
