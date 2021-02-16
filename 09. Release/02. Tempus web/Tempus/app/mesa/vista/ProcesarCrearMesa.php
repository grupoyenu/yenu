<?php

/* SE INCLUYE EL ARCHIVO DE CONSTANTES Y EL AUTOLOAD */

require_once '../../principal/modelo/Constantes.php';
require_once '../../principal/modelo/AutoCargador.php';

/* SE REFERENCIAN LOS NAMESPACE */

use app\aula\modelo\Aula;
use app\docente\modelo\Docente;
use app\mesa\modelo\Tribunal;
use app\mesa\modelo\Llamado;
use app\mesa\modelo\MesaExamen;
use app\plan\modelo\Plan;
use app\plan\controlador\ControladorPlan;
use app\principal\controlador\ControladorHTML;
use app\principal\modelo\AutoCargador;

AutoCargador::cargarModulos();

/* INICIALIZA LA SESION PARA GUARDAR LOG */

session_start();

$exito = false;
if (isset($_POST['plan']) && ($_POST['hayPrimerLlamado'] || $_POST['haySegundoLlamado'])) {

    $idPlan = $_POST['plan'];
    $plan = new Plan($idPlan);
    $datos = $plan->obtenerPorIdentificador();
    if ($datos[0] == 2) {

        /* INICIA LA CONSTRUCCION DEL TRIBUNAL PARA LA MESA */

        $tribunal = new Tribunal();
        $presidente = new Docente($_POST['presidente']);
        $vocal1 = new Docente($_POST['vocal1']);
        $vocal2 = isset($_POST['vocal2']) ? new Docente($_POST['vocal2']) : NULL;
        $suplente = isset($_POST['suplente']) ? new Docente($_POST['suplente']) : NULL;
        $presidente->obtenerPorIdentificador();
        $vocal1->obtenerPorIdentificador();
        ($vocal2 == NULL) ?: $vocal2->obtenerPorIdentificador();
        ($suplente == NULL) ?: $suplente->obtenerPorIdentificador();
        $tribunal->agregarDocente($presidente);
        $tribunal->agregarDocente($vocal1);
        $tribunal->agregarDocente($vocal2);
        $tribunal->agregarDocente($suplente);

        /* INICIA LA CONSTRUCCION DE LOS LLAMADOS */

        $hayPrimerLlamado = (isset($_POST['hayPrimerLlamado']) && $_POST['hayPrimerLlamado'] == "TRUE") ? TRUE : FALSE;
        $haySegundoLlamado = (isset($_POST['haySegundoLlamado']) && $_POST['haySegundoLlamado'] == "TRUE") ? TRUE : FALSE;
        $primerLlamado = $segundoLlamado = NULL;
        if ($hayPrimerLlamado) {
            $fecha1 = $_POST['fecha1'];
            $hora1 = $_POST['hora1'];
            $aula1 = isset($_POST['aula1']) ? new Aula($_POST['aula1']) : NULL;
            $primerLlamado = new Llamado(NULL, $aula1, NULL, $fecha1, $hora1);
        }
        if ($haySegundoLlamado) {
            $fecha2 = $_POST['fecha2'];
            $hora2 = $_POST['hora2'];
            $aula2 = isset($_POST['aula2']) ? new Aula($_POST['aula2']) : NULL;
            $segundoLlamado = new Llamado(NULL, $aula2, NULL, $fecha2, $hora2);
        }
        $observacion = $_POST['observacion'];
        $mesa = new MesaExamen(NULL, $primerLlamado, $segundoLlamado, $tribunal, NULL, $observacion);
        $controlador = new ControladorPlan();
        $asignatura = $plan->getAsignatura();
        $creacion = $controlador->crearMesaExamen($plan, $mesa);
        $codigo = $creacion[0];
        $mensaje = "{$asignatura->getNombreLargo()}: {$creacion[1]}";
        $exito = ($codigo == 2) ? TRUE : FALSE;
        $resultado = ControladorHTML::mostrarAlertaResultadoOperacion($codigo, $mensaje);
    } else {
        $codigo = $datos[0];
        $mensaje = $datos[1];
        $resultado = ControladorHTML::mostrarAlertaResultadoOperacion($codigo, $mensaje);
    }
} else {
    /* NO SE RECIBE LA INFORMACION DESDE EL FORMULARIO  */
    $mensaje = "No se obtuvo la información desde el formulario";
    $resultado = ControladorHTML::mostrarAlertaResultadoOperacion(0, $mensaje);
}

/* RETORNA EL ARREGLO JSON PARA MOSTRAR LA INFORMACION SEGUN CORRESPONDA */

$json[] = array('exito' => $exito, 'resultado' => $resultado);
echo json_encode($json);
