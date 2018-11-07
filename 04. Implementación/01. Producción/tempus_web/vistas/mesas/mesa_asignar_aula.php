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
include_once '../../modelos/aulas/Aulas.php';
include_once '../../lib/conf/ControlAcceso.php';
include_once '../../lib/conf/PermisosSistema.php';
include_once '../../lib/conf/Utilidades.php';
?>
<html>
<?php include_once '../estructura/encabezado.php'; ?>
<script type='text/javascript' src='../../js/mesa_asignar_aula.js'></script>
<section id='main-content'>
<article>
<div id='content' class='content'>
<h2>ASIGNAR AULA</h2>
<form action='' id='' name='' method='post'>
    <?php 
    $mesas =  $_SESSION['mesasSinAsignar'];
    $indice = $_POST['radMesa'];
    $aulas = new Aulas();
    if(isset($mesas)) {
        $fecha_actual = strtotime(date("d-m-Y",time()));
        $mesa = $mesas[$indice];
        $carrera = $mesa->getPlan()->getCarrera()->getNombre();
        $asignatura = $mesa->getPlan()->getAsignatura()->getNombre();
        $dia = "";
        $llamado = "";
        $fecha = "";
        $hora = "";
        if($mesa->getPrimero()) {
            $fechaprimero = $mesa->getPrimero()->getFecha();
            $fechaprimero = str_replace("/", "-", $fechaprimero);
            $fechaprimero =  strtotime($fechaprimero);
            if($fechaprimero = $fecha_actual) {
                $llamado = "Primer llamado: ";
                $dia = Utilidades::nombreDeDia(date("N", $fechaprimero))." ";
                $fecha = $mesa->getPrimero()->getFecha()." ";
                $hora = $mesa->getPrimero()->getHora()." hs";
            }
        } else {
            $fechasegundo = $mesa->getSegundo()->getFecha();
            $fechasegundo = str_replace("/", "-", $fechasegundo);
            $fechaprimero =  strtotime($fechasegundo);
            $llamado = "Segundo llamado: ";
            $dia = Utilidades::nombreDeDia(date("N", $fechasegundo))." ";
            $fecha = $mesa->getSegundo()->getFecha()." ";
            $hora = $mesa->getSegundo()->getHora()." hs";
        }
        
        
        echo "<fieldset>";
        echo "<legend>{$carrera} - {$asignatura}</legend>";
        echo "<label>{$llamado}</label>";
        echo "<label>{$dia} {$fecha} {$hora}</label><br>";
        echo "<fieldset>";
        echo "<legend><input type='radio' id='radTipoAsignacion' name='radTipoAsignacion' value='0' checked> Seleccionar aula libre </legend>";
        echo "<div id='divDisponible'>";
        
        echo "<label>Observacion:</label>";
        echo "<label>Esta opción permite seleccionar un aula disponible en una franja horaria de 3 hs a partir de la hora de inicio</label><br>";
        echo "</div>";
        echo "</fieldset>";
       
        echo "<fieldset title='Esta opción permite seleccionar un aula aunque este ocupada por una clase'>";
        echo "<legend><input type='radio' id='radTipoAsignacion' name='radTipoAsignacion' value='1'> Seleccionar aula ocupada </legend>";
        echo "<div id='divOcupada' style='display:none;'>";
        if($aulas->getAulas()) {
            echo "<label>Aula:</label>";
            echo "<select>";
            foreach ($aulas->getAulas() as $aula) {
                echo "<option value='{$aula->getIdaula()}'>{$aula->getSector()} - {$aula->getNombre()}</option>";
            }
            echo "</select>";
            echo "<input type='image' src='../../img/abm_confirmar.png' title='Asignar aula a mesa de examen'/>";
        } else {
            
        }
        echo "</div>";
        echo "</fieldset>";
        
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
