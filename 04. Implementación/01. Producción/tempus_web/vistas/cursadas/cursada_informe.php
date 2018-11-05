<?php

header('Content-Type: text/html; charset=ISO-8859-1');
include_once '../../lib/conf/ControlAcceso.php';
include_once '../../lib/conf/PermisosSistema.php';

if (isset($_SESSION['resultado'])) {
    $resultado = $_SESSION['resultado'];
}

echo "<html>";
include_once '../estructura/encabezado.php';
echo "<script type='text/javascript' src='../../js/mesa_modificar.js'></script>";
echo "<script type='text/javascript' src='../../js/jquery-confirm-master/js/jquery-confirm.js'></script>";
echo "<section id='main-content'>";
echo "<article>";
echo "<div id='content' class='content'>";
echo "<h2>INFORME MESA DE EXAMEN</h2>";
echo "<form action='../../Controladores/ManejadorMesa.php' id='formInformeCursada' name='formInformeCursada' method='post'>";

echo "<fieldset>";
echo "<legend>Información básica</legend>";

echo "</fieldset>";
echo "<input type='hidden' id='accion' name='accion' value='buscar'>";
echo "<input class='botonVerde' type='submit' id='btnInformeCursada' name='btnInformeCursada' value='Buscar'>";
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
