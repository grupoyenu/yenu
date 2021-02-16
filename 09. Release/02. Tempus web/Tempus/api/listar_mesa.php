<?php

header("Access-Control-Allow-Origin: *");

include_once '../config/inc_config.php';
include_once '../app/modelo/Encriptador.php';
include_once './MySQL.php';

$idCarrera = strip_tags($_REQUEST['idCarrera']);
$idAsignatura = strip_tags($_REQUEST['idAsignatura']);
$docente = strip_tags($_REQUEST['docente']);

if ($idCarrera && ($idAsignatura || $docente)) {
    $instancia = MySQL::getInstancia();
    $query = "SELECT idPlan,"
            . " nombreLargoAsignatura,"
            . " nombrePresidente,"
            . " nombreVocalPrimero,"
            . " nombreVocalSegundo,"
            . " nombreSuplente,"
            . " DATE_FORMAT(fechaPrimerLlamado, '%d/%m/%Y') fechaPrimerLlamado,"
            . " (CASE WHEN sectorAulaPrimerLlamado IS NULL THEN 'Sin asignar' ELSE CONCAT(sectorAulaPrimerLlamado,' ',nombreAulaPrimerLlamado) END) aulaPrimerLlamado,"
            . " estadoPrimerLlamado,"
            . " DATE_FORMAT(fechaSegundoLlamado, '%d/%m/%Y') fechaSegundoLlamado,"
            . " (CASE WHEN sectorAulaSegundoLlamado IS NULL THEN 'Sin asignar' ELSE CONCAT(sectorAulaSegundoLlamado,' ',nombreAulaSegundoLlamado) END) aulaSegundoLlamado,"
            . " estadoSegundoLlamado"
            . " FROM vw_mesa_examen "
            . " WHERE codigoCarrera = {$idCarrera} AND ";
    $query .= ($idAsignatura) ? " idAsignatura = {$idAsignatura} " : " (nombrePresidente LIKE '%{$docente}%' OR nombreVocalPrimero LIKE '%{$docente}%' OR nombreVocalSegundo LIKE '%{$docente}%' OR nombreSuplente LIKE '%{$docente}%') ";
    $query .= " ORDER BY nombreLargoAsignatura ";
    $resultado = $instancia->query($query);
    if ($resultado) {
        if ($resultado->num_rows > 0) {
            $carreras = $resultado->fetch_all(MYSQLI_ASSOC);
            $response = array('estado' => 'OK', 'datos' => $carreras);
        } else {
            $response = array('estado' => 'BAD', 'datos' => 'No se encontraron cursadas cargadas');
        }
    } else {
        $response = array('estado' => 'BAD', 'datos' => 'Error al consultar mesas de examen');
    }
} else {
    $response = array('estado' => 'BAD', 'datos' => 'No se indicó alguno de los datos obligatorios');
}

echo json_encode($response);



