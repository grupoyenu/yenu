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
use app\mesa\controlador\ControladorMesa;
use app\principal\controlador\ControladorHTML;
use app\principal\modelo\AutoCargador;
use app\principal\modelo\Log;

AutoCargador::cargarModulos();

/* INICIALIZA LA SESION PARA GUARDAR LOG */

session_start();

$exito = false;
if ($_POST['idMesaExamen']) {
    $idMesaExamen = $_POST['idMesaExamen'];
    $modificarTribunal = $_POST['tribunalModificado'];
    $modificarLlamadoUno = $_POST['llamadoUnoModificado'];
    $modificarLlamadoDos = isset($_POST['llamadoDosModificado']) ? $_POST['llamadoDosModificado'] : "NO";
    $mesaExamen = new MesaExamen($idMesaExamen);
    if ($modificarTribunal == "SI") {
        $idTribunal = $_POST['idTribunal'];
        $tribunal = new Tribunal($idTribunal);
        $presidente = new Docente($_POST['presidente']);
        $vocal1 = new Docente($_POST['vocal1']);
        $vocal2 = (isset($_POST['vocal2']) && $_POST['vocal2']) ? new Docente($_POST['vocal2']) : NULL;
        $suplente = (isset($_POST['suplente']) && $_POST['suplente']) ? new Docente($_POST['suplente']) : NULL;
        $presidente->obtenerPorIdentificador();
        $vocal1->obtenerPorIdentificador();
        ($vocal2 == NULL) ?: $vocal2->obtenerPorIdentificador();
        ($suplente == NULL) ?: $suplente->obtenerPorIdentificador();
        $tribunal->agregarDocente($presidente);
        $tribunal->agregarDocente($vocal1);
        $tribunal->agregarDocente($vocal2);
        $tribunal->agregarDocente($suplente);
        $mesaExamen->setTribunal($tribunal);
    }

    if ($modificarLlamadoUno == "SI") {
        $idLlamado = $_POST['idLlamado1'];
        $fecha = $_POST['fecha1'];
        $hora = $_POST['hora1'];
        $aula = (isset($_POST['aula1']) && $_POST['aula1']) ? new Aula($_POST['aula1']) : NULL;
        $estado = $_POST['estado1'];
        $primerLlamado = new Llamado($idLlamado, $aula, $estado, $fecha, $hora);
        $mesaExamen->setPrimerLlamado($primerLlamado);
    }

    if ($modificarLlamadoDos == "SI") {
        $idLlamado = $_POST['idLlamado2'];
        $fecha = $_POST['fecha2'];
        $hora = $_POST['hora2'];
        $aula = (isset($_POST['aula2']) && $_POST['aula2']) ? new Aula($_POST['aula2']) : NULL;
        $estado = $_POST['estado2'];
        $segundoLlamado = new Llamado($idLlamado, $aula, $estado, $fecha, $hora);
        $mesaExamen->setSegundoLlamado($segundoLlamado);
    }
    $observacion = $_POST['observacion'];
    $mesaExamen->setObservacion($observacion);
    $controlador = new ControladorMesa();
    $edicion = $controlador->modificar($mesaExamen);
    $codigo = $edicion[0];
    $mensaje = "{$edicion[1]}";
    $exito = ($codigo == 2) ? TRUE : FALSE;
    $resultado = ControladorHTML::mostrarAlertaResultadoOperacion($codigo, $mensaje);
} else {
    /* NO SE RECIBE LA INFORMACION DESDE EL FORMULARIO  */
    $mensaje = "No se obtuvo la información desde el formulario";
    $resultado = ControladorHTML::mostrarAlertaResultadoOperacion(0, $mensaje);
}

/* RETORNA EL ARREGLO JSON PARA MOSTRAR LA INFORMACION SEGUN CORRESPONDA */

$json[] = array('exito' => $exito, 'resultado' => $resultado);
echo json_encode($json);
