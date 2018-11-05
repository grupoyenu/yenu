<?php

header('Content-Type: text/html; charset=ISO-8859-1');
include_once '../../lib/conf/ControlAcceso.php';
include_once '../../lib/conf/PermisosSistema.php';
include_once '../../modelos/mesas/Llamados.php';
include_once '../../modelos/aulas/Aula.php';
include_once '../../modelos/aulas/Aulas.php';

if (isset($_SESSION['resultado'])) {
    $resultado = $_SESSION['resultado'];
}
$llamados = new Llamados();
$aulas = new Aulas();
$llamados->fechasPrimerLlamado();
$llamados->fechasSegundoLlamado();
$primero = $llamados->getPrimero();
$segundo = $llamados->getSegundo();
$horarios = $llamados->obtenerHorarios();

echo "<html>";
include_once '../estructura/encabezado.php';
echo "<script type='text/javascript' src='../../js/mesa_modificar.js'></script>";
echo "<script type='text/javascript' src='../../js/jquery-confirm-master/js/jquery-confirm.js'></script>";
echo "<section id='main-content'>";
echo "<article>";
echo "<div id='content' class='content'>";
echo "<h2>INFORME MESA DE EXAMEN</h2>";
echo "<form action='../../Controladores/ManejadorMesa.php' id='formInformeMesa' name='formInformeMesa' method='post'>";

echo "<fieldset>";
echo "<legend>Información básica</legend>";
echo "<label>Fecha:</label>";
echo "<select>";
    if($primero) {
        foreach ($primero as $fecha) {
            echo "<option>{$fecha}</option>";
        }
    }
    if ($segundo) {
        foreach ($segundo as $fecha) {
            echo "<option>{$fecha}</option>";
        }
    }
    
echo "</select>";
echo "<label>Hora:</label>";
echo "<select>";
    if($horarios) {
        foreach ($horarios as $hora) {
            echo "<option>{$hora}</option>";
        }
    }
echo "</select>";
echo "<label>Sector:</label>";
echo "<select>";
    echo "<option value=''>Sin asignar</option>";
    foreach ($aulas->getAulas() as $aula) {
        $actual = $aula->getSector();
        if($actual != $previo) {
            echo "<option value=''>{$aula->getSector()}</option>";
        }
        $previo = $actual;
    }
echo "</select>";
echo "</fieldset>";
echo "<input type='hidden' id='accion' name='accion' value='buscar'>";
echo "<input class='botonVerde' type='submit' id='btnInformeMesa' name='btnInformeMesa' value='Buscar'>";
echo "</form>";

if (isset($resultado) && isset($resultado['resultado']) && isset($resultado['mensaje']) && isset($resultado['datos'])) {
    echo "<fieldset>";
    echo "<legend>Resultado</legend>";
    echo "</fieldset>";
}

$_SESSION['resultado'] = null;

echo "</div>";
echo "</article>";
echo "</section>";
include_once '../estructura/pie.php';
echo "</html>";
?>