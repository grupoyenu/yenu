<?php

header("Access-Control-Allow-Origin: *");

include_once '../config/inc_config.php';
include_once '../app/principal/modelo/Encriptador.php';
include_once './MySQL.php';

$instancia = MySQL::getInstancia();

$query = 'SELECT DISTINCT c.id codigo, c.nombreCorto, c.nombreLargo '
        . ' FROM plan p '
        . ' INNER JOIN carrera c ON c.id = p.idCarrera '
        . ' WHERE p.id IN (SELECT DISTINCT idPlan FROM clase)';
$resultado = $instancia->query($query);
if ($resultado) {
    if ($resultado->num_rows > 0) {
        $carreras = $resultado->fetch_all(MYSQLI_ASSOC);
        $response = array('estado' => 'OK', 'datos' => $carreras);
    } else {
        $response = array('estado' => 'BAD', 'datos' => 'No se encontraron carreras cargadas');
    }
} else {
    $response = array('estado' => 'BAD', 'datos' => 'Error al consultar carreras');
}

echo json_encode($response);




