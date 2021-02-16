<?php

header("Access-Control-Allow-Origin: *");

include_once '../config/inc_config.php';
include_once '../app/modelo/Encriptador.php';
include_once './MySQL.php';

$idCarrera = strip_tags($_REQUEST['idCarrera']);
if ($idCarrera) {
    $instancia = MySQL::getInstancia();
    $query = "SELECT DISTINCT a.id, a.nombreCorto, a.nombreLargo "
            . " FROM plan p "
            . " INNER JOIN asignatura a ON a.id = p.idAsignatura "
            . " WHERE p.idMesaExamen IS NOT NULL AND p.idCarrera = {$idCarrera} "
            . " ORDER BY a.nombreLargo";
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
} else {
    $response = array('estado' => 'BAD', 'datos' => 'No se indicó una carrera');
}

echo json_encode($response);




