<?php

header("Access-Control-Allow-Origin: *");

include_once '../config/inc_config.php';
include_once '../app/principal/modelo/Encriptador.php';
include_once './MySQL.php';

$idCarrera = strip_tags($_REQUEST['idCarrera']);
$idAsignatura = strip_tags($_REQUEST['idAsignatura']);
$anio = strip_tags($_REQUEST['anio']);

if ($idCarrera && ($idAsignatura || $anio)) {
    $instancia = MySQL::getInstancia();
    $query = "SELECT idPlan, "
			. " nombreLargoAsignatura, "
            . " CONCAT(SUBSTRING(horaInicioLunes, 1, 5), ' a ', SUBSTRING(horaFinLunes, 1, 5)) horaLunes, "
			. " CONCAT(sectorAulaLunes, ' ', nombreAulaLunes) aulaLunes, "
			. " CONCAT(SUBSTRING(horaInicioMartes, 1, 5), ' a ', SUBSTRING(horaFinMartes, 1, 5)) horaMartes, "
			. " CONCAT(sectorAulaMartes, ' ', nombreAulaMartes) aulaMartes, "
			. " CONCAT(SUBSTRING(horaInicioMiercoles, 1, 5), ' a ', SUBSTRING(horaFinMiercoles, 1, 5)) horaMiercoles, "
			. " CONCAT(sectorAulaMiercoles, ' ', nombreAulaMiercoles) aulaMiercoles, "
			. " CONCAT(SUBSTRING(horaInicioJueves, 1, 5), ' a ', SUBSTRING(horaFinJueves, 1, 5)) horaJueves, "
			. " CONCAT(sectorAulaJueves, ' ', nombreAulaJueves) aulaJueves, "
			. " CONCAT(SUBSTRING(horaInicioViernes, 1, 5), ' a ', SUBSTRING(horaFinViernes, 1, 5)) horaViernes, "
			. " CONCAT(sectorAulaViernes, ' ', nombreAulaViernes) aulaViernes, "
			. " CONCAT(SUBSTRING(horaInicioSabado, 1, 5), ' a ', SUBSTRING(horaFinSabado, 1, 5)) horaSabado, "
			. " CONCAT(sectorAulaSabado, ' ', nombreAulaSabado) aulaSabado, "
			. " false favorito "
            . " FROM vw_cursada "
            . " WHERE codigoCarrera = {$idCarrera} AND ";
    $query .= ($idAsignatura) ? " idAsignatura = {$idAsignatura} " : " anio = {$anio} ";
    $resultado = $instancia->query($query);
    if ($resultado) {
        if ($resultado->num_rows > 0) {
            $carreras = $resultado->fetch_all(MYSQLI_ASSOC);
            $response = array('estado' => 'OK', 'datos' => $carreras);
        } else {
            $response = array('estado' => 'BAD', 'datos' => 'No se encontraron cursadas cargadas');
        }
    } else {
        $response = array('estado' => 'BAD', 'datos' => 'Error al consultar cursadas');
    }
} else {
    $response = array('estado' => 'BAD', 'datos' => 'No se indicó alguno de los datos obligatorios');
}

echo json_encode($response);



