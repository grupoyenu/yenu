<?php

require_once '../controladores/Autoload.php';
$autoload = new Autoload();
$autoload->autoloadProcesa();

$exito = false;
if (!empty($_POST['codigoCarrera']) && !empty($_POST['idAsignatura'])) {

    $codigo = $_POST['codigoCarrera'];
    $idasignatura = $_POST['idAsignatura'];

    if (isset($_POST['cbClases'])) {
        $dias = $_POST['cbClases'];
        $cantidad = count($dias);
        $contador = 0;
        $correcto = true;
        $clases = array();
        $mensaje = "";
        while (($contador < $cantidad) && $correcto) {
            $dia = $dias[$contador];
            if (!empty($_POST['idaula' . $dia])) {
                $inicio = $_POST['inicio' . $dia];
                $fin = $_POST['fin' . $dia];
                $idaula = $_POST['idaula' . $dia];
                $aula = new Aula($idaula);
                $disponible = $aula->verificarDisponibilidadFranja($dia, $inicio, $fin);
                if ($disponible == 1) {
                    $clase = new Clase();
                    if ($clase->constructor($dia, $inicio, $fin, $aula)) {
                        $clases[] = $clase;
                    } else {
                        $mensaje = $clase->getDescripcion();
                        $correcto = false;
                    }
                } else {
                    $nombre = Utilidades::nombreDeDia($dia);
                    $mensaje = "El {$disponible} aula especificada para el día {$nombre} se encuentra ocupada entre las {$inicio} hs y {$fin} hs";
                    $correcto = false;
                }
            } else {
                $nombre = Utilidades::nombreDeDia($dia);
                $mensaje = "No se ha especificado un aula para el " . $nombre;
                $correcto = false;
            }
            $contador ++;
        }

        if ($correcto) {
            $controladorCursada = new ControladorCursada();
            $plan = new Plan($idasignatura, $codigo);
            if ($plan->getEstado()) {
                $creacion = $controladorCursada->crear($plan, $clases);
                switch ($creacion) {
                    case 0:
                        $class = 'class="alert alert-warning text-center"';
                        break;
                    case 1:
                        $class = 'class="alert alert-danger text-center"';
                        break;
                    case 2:
                        $exito = true;
                        $class = 'class="alert alert-success text-center"';
                        break;
                    default:
                        $class = 'class="alert alert-info text-center"';
                        break;
                }
                $div = '<div ' . $class . ' role="alert">' . $controladorCursada->getDescripcion() . '</div>';
            } else {
                $div = '<div class="alert alert-warning text-center" role="alert">No se pudo obtener la información del plan</div>';
            }
        } else {
            $div = '<div class="alert alert-warning text-center" role="alert">' . $mensaje . '</div>';
        }
    } else {
        $mensaje = "No se obtuvieron los datos de clases que son necesarios para la creación de la cursada";
        $div = '<div class="alert alert-danger text-center" role="alert">' . $mensaje . '</div>';
    }
} else {
    $mensaje = "No se obtuvieron los datos del plan que son necesarios para la creación de la cursada";
    $div = '<div class="alert alert-danger text-center" role="alert">' . $mensaje . '</div>';
}

$json[] = array('exito' => $exito, 'div' => $div);
echo json_encode($json);
