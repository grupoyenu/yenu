<?php

require_once '../../principal/modelos/Constantes.php';
require_once '../../principal/modelos/AutoCargador.php';

AutoCargador::cargarModulos();

$mesas[] = array(85, "Maestria en mesas", "Asignatura 1", "Luis Rodriguez", "Emanuel Marquez", "", "", "2019-12-05", "15:00");
$mesas[] = array(85, "Maestria en mesas", "Asignatura 2", "Marquez Jose", "Hector Bracamonte", "", "", "2019-12-08", "16:00");
$mesas[] = array(85, "Maestria en mesas", "Asignatura 3", "Daniel Lopez", "Diego Veron", "Sebastian Gomez", "", "2019-12-09", "15:00");
$mesas[] = array(86, "Maestria en cursadas", "Asignatura 4", "Emanuel Marquez", "Daniel Lopez", "Diego Veron", "Luis Rodriguez", "2019-12-07", "18:00");
$mesas[] = array(86, "Maestria en cursadas", "Asignatura 5", "Juan Carlos Maradona", "Marcelo Villafañe", "", "", "2019-12-03", "19:00");
$mesas[] = array(86, "Maestria en cursadas", "Asignatura 6", "Mariano Diaz", "Marianela Monzon", "", "", "2019-12-04", "10:00");


/*
  $mesasExamen = new MesasExamen();
  $errores = $mesasExamen->importarUnLlamado($mesas);
  echo "<pre>";
  var_dump($errores);
  echo "</pre>";
 */

$mesasExamen = new MesasExamen();
$mesasExamen->importar($mesas, 1);
echo "<pre>";
var_dump($errores);
echo "</pre>";
echo $mesasExamen->getDescripcion();
/*
foreach ($mesas as $datos) {
    $carrera = new Carrera($datos[0], $datos[1]);
    if ($carrera->crear() == 2) {
        $asignatura = new Asignatura(NULL, $datos[2]);
        if ($asignatura->crear() == 2) {
            $idAsignatura = $asignatura->getIdAsignatura();
            $agregar = $carrera->agregarAsignatura($idAsignatura, 1);
            echo "Agregar: " . $agregar;
        } else {
            $errores[] = "No se creo " . $datos[2];
        }
    } else {
        $errores[] = "No se creo " . $datos[0] . " " . $datos[1] . " " . $datos[2];
    }
}

echo "<BR>";
var_dump($errores);
*/