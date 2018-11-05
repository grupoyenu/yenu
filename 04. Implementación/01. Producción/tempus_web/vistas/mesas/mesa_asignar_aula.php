<?php
header('Content-Type: text/html; charset=ISO-8859-1');
include_once '../../modelos/mesas/Mesas.php';
include_once '../../modelos/carreras/Carrera.php';
include_once '../../modelos/carreras/Asignatura.php';
include_once '../../modelos/carreras/Plan.php';
include_once '../../modelos/mesas/Tribunal.php';
include_once '../../modelos/mesas/MesaExamen.php';
include_once '../../modelos/mesas/Llamado.php';
include_once '../../modelos/aulas/Aula.php';
include_once '../../lib/conf/ControlAcceso.php';
include_once '../../lib/conf/PermisosSistema.php';
include_once '../../lib/conf/Utilidades.php';
?>
<html>
<?php include_once '../estructura/encabezado.php'; ?>
<script type='text/javascript' src='../../js/aula_buscar.js'></script>
<section id='main-content'>
<article>
<div id='content' class='content'>
<h2>ASIGNAR AULA</h2>
<form action='' id='' name='' method='post'>
    <?php 
    $resultado =  $_SESSION['mesaBuscarResultado'];
    $indice = $_POST['radioMesas'];
    $fecha_actual = strtotime(date("d-m-Y",time()));
    if(isset($resultado) && isset($resultado['datos'])) {
        $mesas = $resultado['datos'];
        $mesa = $mesas[$indice];
        echo "<fieldset>";
        echo "<legend>{$mesa->getPlan()->getCarrera()->getNombre()} - {$mesa->getPlan()->getAsignatura()->getNombre()}</legend>";
        if($mesa->getPrimero()) {
            echo "<fieldset>";
            echo "<legend>Primer llamado</legend>";
            $primero = $mesa->getPrimero()->getFecha();
            $fecha_primero =  strtotime($primero);
            if ($fecha_primero >= $fecha_actual) {
                
            } else {
                $dia = str_replace("/", "-", $primero);
                $dia = Utilidades::nombreDeDia(date("N",strtotime($dia)));
                echo "<label>Observacion:</label>";
                echo "<label>El primer llamado de esta mesa se dictó el día {$dia} {$primero}. Ya no se puede asignar un aula.</label>";
            }
            echo "</fieldset>";
        }
        
        if($mesa->getSegundo()) {
            echo "<fieldset>";
            echo "<legend>Segundo llamado</legend>";
            $segundo = $mesa->getSegundo()->getFecha();
            $fecha_segundo =  strtotime($segundo);
            if ($fecha_segundo >= $fecha_actual) {
                
            } else {
                $dia = str_replace("/", "-", $segundo);
                $dia = Utilidades::nombreDeDia(date("N",strtotime($dia)));
                echo "<label>Observacion:</label>";
                echo "<label>El segundo llamado de esta mesa se dictó el día {$dia} {$segundo}. Ya no se puede asignar un aula.</label>";
            }
            echo "</fieldset>";
        }
        echo "</fieldset>";
    } else {
        echo "<fieldset>";
        echo "<legend></legend>";
        
        echo "</fieldset>";
    }
    ?>
    
</form>
</div>
</article>
</section>
<?php include_once '../estructura/pie.php'; ?>
</html>
