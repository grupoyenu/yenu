<?php

require_once '../../principal/modelos/Constantes.php';
require_once '../../principal/modelos/AutoCargador.php';

AutoCargador::cargarModulos();

$resultado = Conexion::getInstancia()->consultar("SELECT * FROM aula where idaula=52");


echo "RESULTADO: " . gettype($resultado) . " ";
