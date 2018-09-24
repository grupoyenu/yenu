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

echo "<html>";
include_once '../estructura/encabezado.php';
echo "<script type='text/javascript' src='../../js/mesa_modificar.js'></script>";
echo "<section id='main-content'>";
echo "<article>";
echo "<div id='content' class='content'>";
echo "<h2>MODIFICAR MESA DE EXAMEN</h2>";
echo "<form action='../../Controladores/ManejadorMesa.php' id='formModificarMesa' name='formModificarMesa' method='post'>";

$resultado = $_SESSION['resultado'];
if (isset($resultado) && isset($resultado['datos'])) {
    
    if($resultado['resultado']) {
        $mensaje = $resultado['mensaje'];
        echo "<h3 id='mensaje' class='letraVerde letraCentrada'>$mensaje</h3>";
    } else {
        $mensaje = $resultado['mensaje'];
        echo "<h3 id='mensaje' class='letraRoja letraCentrada'>$mensaje</h3>";
    }
    
    /* RECUPERA LA INFORMACION DE LA MESA DE EXAMEN */
    $mesas = new Mesas();
    $llamados = $mesas->cantidadLlamados();
    $fecha_actual = strtotime(date("d-m-Y",time()));
    
    $mesa = $resultado['datos'];
    $plan = $mesa->getPlan();
    $asignatura = $plan->getAsignatura();
    $carrera =  $plan->getCarrera();
    $tribunal = $mesa->getTribunal();
    $presidente = $tribunal->getPresidente()->getNombre();
    $vocal1 = $tribunal->getVocal1()->getNombre();
    $vocal2 = "";
    $suplente = "";
    if ($tribunal->getVocal2()) {
        $vocal2 = $tribunal->getVocal2()->getNombre();
        if ($tribunal->getSuplente()) {
            $suplente =  $tribunal->getSuplente()->getNombre();
        }
    }   
    $horario = "";
    $primero = "";
    $segundo = "";
    $sector = "";
    $nombreaula = "";
    echo "<fieldset>";
    echo "<legend>".$carrera->getCodigo()." - ".$carrera->getNombre()." - ".$asignatura->getNombre()."</legend>";
    echo "<fieldset title='La modificaci�n del tribunal no genera notificaciones'>";
    echo "<legend>Tribunal</legend>";
    echo "<label for='txtNombrePresidente'>* Presidente:</label>";
    echo "<input type='text' name='txtNombrePresidente' id='txtNombrePresidente' value='".$presidente."' pattern='[A-Za-z������������. ]{10,255}' required>";
    echo "<label for='txtNombreVocal1'>* Vocal 1:</label>";
    echo "<input type='text' name='txtNombreVocal1' id='txtNombreVocal1' value='".$vocal1."' pattern='[A-Za-z������������0123456789,. ]{5,255}' required>";
    echo "<br>";
    echo "<label for='txtNombreVocal2'>Vocal 2:</label>";
    echo "<input type='text' name='txtNombreVocal2' id='txtNombreVocal2' value='".$vocal2."' pattern='[A-Za-z��������������,. ]{4,255}'>";
    echo "<label for='txtNombreSuplente'>Suplente:</label>";
    echo "<input type='text' name='txtNombreSuplente' id='txtNombreSuplente' value='".$suplente."' pattern='[A-Za-z��������������,. ]{4,255}'>";
    echo "<p class='centrado'><input class='botonVerde' type='submit' name='btnModificarMesa' id='btnModificarMesa' value='Modificar'></p>";
    echo "</fieldset>";
    if ($llamados && $llamados > 0) {
        /* HAY DOS LLAMADOS */
        $hora_disabled = "false";
        echo "<fieldset title='La modificaci�n del primer llamado genera notificaciones'>";
        echo "<legend>Primer llamado</legend>";
        if($mesa->getPrimero()) {
            $disabled = "";
            $primero = $mesa->getPrimero()->getFecha();
            $horario = $mesa->getPrimero()->getHora();
            $primero = str_replace("/", "-", $primero);
            $fecha_entrada =  strtotime($primero);
            $primero = date("Y-m-d", $fecha_entrada);
            if ($fecha_entrada < $fecha_actual) {
                $disabled = "disabled";
                echo "<label class='letraNaranja'>Observaci�n:</label>";
                echo "<label class='letraNaranja'>La fecha para modificar este llamado ya ha pasado</label>";
                echo "<br>";
            }
            echo "<label for='datePrimerLlamado'>Fecha:</label>";
            echo "<input type='date' name='datePrimerLlamado' id='datePrimerLlamado' value='{$primero}' {$disabled}>";
            echo "<input type='image' src='../../img/abm_editar.png' id='imgPrimerLlamado' name='imgPrimerLlamado' title='Modificar fecha' {$disabled}/>";
            echo "<br>";
            if ($mesa->getPrimero()->getAula()) {
                $sector = $mesa->getPrimero()->getAula()->getSector();
                $nombreaula = $mesa->getPrimero()->getAula()->getNombre();
                echo "<label for='txtSector'>* Sector</label>";
                echo "<input type='text' name='txtSector' id='txtSector' value='".$sector."' pattern='[A-Z]' maxlength='1' {$disabled} required>";
                echo "<label for='txtNombreAula'>* Nombre aula:</label>";
                echo "<input type='text' name='txtNombreAula' id='txtNombreAula' value='".$nombreaula."' pattern='[A-Za-z��������������0123456789 ]{1,255}' {$disabled} required>";
            } else {
                echo "<label>Lugar:</label>";
                echo "<label>Campus</label>";
            }
            echo "<br>";
            echo "<label>Modidicaci�n:</label>";
            if ($mesa->getPrimero()->getFechamod()) {
                $fechamod = $mesa->getPrimero()->getFechamod();
                echo "<label>{$fechamod}</label>";
            } else {
                echo "<label>No registra</label>";
            }
            
        } else {
            echo "<label class='letraNaranja'>Observaci�n:</label>";
            echo "<label class='letraNaranja'>No se pudo cargar la informaci�n del primer llamado para esta mesa de examen</label>";
        }
        echo "</fieldset>";
        echo "<fieldset title='La modificaci�n del segundo llamado genera notificaciones'>";
        echo "<legend>Segundo llamado</legend>";
        if($mesa->getSegundo()) {
            $disabled = "";
            $segundo = $mesa->getSegundo()->getFecha();
            $horario = $mesa->getSegundo()->getHora();
            $segundo = str_replace("/", "-", $segundo);
            $fecha_entrada =  strtotime($segundo);
            $segundo = date("Y-m-d", $fecha_entrada);
            if ($fecha_entrada < $fecha_actual) {
                $hora_disabled = "disabled";
                $disabled = "disabled";
                echo "<label class='letraNaranja'>Observaci�n:</label>";
                echo "<label class='letraNaranja'>La fecha para modificar este llamado ya ha pasado</label>";
                echo "<br>";
            }
            echo "<label for='dateSegundoLlamado'>Segundo Llamado:</label>";
            echo "<input type='date' name='dateSegundoLlamado' id='dateSegundoLlamado' value='{$segundo}' {$disabled}>";
            echo "<input type='image' src='../../img/abm_editar.png' id='imgSegundoLlamado' name='imgSegundoLlamado' title='Modificar fecha' {$disabled}/>";
            echo "<br>";
            if ($mesa->getSegundo() && $mesa->getSegundo()->getAula()) {
                $sector = $mesa->getSegundo()->getAula()->getSector();
                $nombreaula = $mesa->getSegundo()->getAula()->getNombre();
                echo "<label for='txtSector'>* Sector</label>";
                echo "<input type='text' name='txtSector' id='txtSector' value='{$sector}' pattern='[A-Z]' maxlength='1' {$disabled} required>";
                echo "<label for='txtNombreAula'>* Nombre aula:</label>";
                echo "<input type='text' name='txtNombreAula' id='txtNombreAula' value='{$nombreaula}' pattern='[A-Za-z��������������0123456789 ]{1,255}' {$disabled} required>";
            } else {
                echo "<label>Lugar:</label>";
                echo "<label>Campus</label>";
            }
        } else {
            echo "<label class='letraNaranja'>Observaci�n:</label>";
            echo "<label class='letraNaranja'>No se pudo cargar la informaci�n del primer llamado para esta mesa de examen</label>";
        }
        echo "</fieldset>";
        echo "<fieldset title='La modificaci�n del horario para ambos llamados genera notificaciones'>";
        echo "<legend>Horario</legend>";
        echo "<label for='selectHora'>Hora:</label>";
        echo "<select  name='selectHora' id='selectHora' disabled='{$hora_disabled}'>";
        for ($hora = 10; $hora < 23; ++$hora) {
            if($hora.':00' == $horario) {
                echo "<option value='{$hora}:00' selected>{$hora}:00 hs</option>";
            } else {
                echo "<option value='{$hora}:00'>{$hora}:00 hs</option>";
            }
        }
        echo "</select>";
        echo "<input type='image' src='../../img/abm_editar.png' id='imgModificarHora' name='imgModificarHora' title='Modificar horario' disabled='{$hora_disabled}'/>";
        echo "<label>La modificaci�n del horario es aplicado para ambos llamados</label>";
        echo "</fieldset>";
    } else {
        /* HAY UN SOLO LLAMADO - MUESTRA LLAMADO Y HORA EN UN SOLO FIELDSET */
        echo "<fieldset title='La modificaci�n del primer llamado genera notificaciones'>";
        echo "<legend>Primer llamado</legend>";
        if($mesa->getPrimero()) {
            $disabled = "";
            $primero = $mesa->getPrimero()->getFecha();
            $horario = $mesa->getPrimero()->getHora();
            $primero = str_replace("/", "-", $primero);
            $fecha_entrada =  strtotime($primero);
            $primero = date("Y-m-d", $fecha_entrada);
            if ($fecha_entrada < $fecha_actual) {
                $disabled = "disabled";
                echo "<label class='letraNaranja'>Observaci�n:</label>";
                echo "<label class='letraNaranja'>La fecha para modificar este llamado ya ha pasado</label>";
                echo "<br>";
            }
            echo "<label for='datePrimerLlamado'>Fecha:</label>";
            echo "<input type='date' name='datePrimerLlamado' id='datePrimerLlamado' value='{$primero}' {$disabled}>";
            echo "<input type='image' src='../../img/abm_editar.png' id='imgPrimerLlamado' name='imgPrimerLlamado' title='Modificar fecha' {$disabled}/>";
            echo "<br>";
            echo "<label for='selectHora'>Hora:</label>";
            echo "<select  name='selectHora' id='selectHora' {$disabled}>";
            for ($hora = 10; $hora < 23; ++$hora) {
                if($hora.':00' == $horario) {
                    echo "<option value='{$hora}:00' selected>{$hora}:00 hs</option>";
                } else {
                    echo "<option value='{$hora}:00'>{$hora}:00 hs</option>";
                }
            }
            echo "</select>";
            echo "<input type='image' src='../../img/abm_editar.png' id='imgModificarHora' name='imgModificarHora' title='Modificar horario' {$disabled}/>";
            if ($mesa->getPrimero()->getAula()) {
                $sector = $mesa->getPrimero()->getAula()->getSector();
                $nombreaula = $mesa->getPrimero()->getAula()->getNombre();
                echo "<label for='txtSector'>* Sector</label>";
                echo "<input type='text' name='txtSector' id='txtSector' value='".$sector."' pattern='[A-Z]' maxlength='1' {$disabled} required>";
                echo "<label for='txtNombreAula'>* Nombre aula:</label>";
                echo "<input type='text' name='txtNombreAula' id='txtNombreAula' value='".$nombreaula."' pattern='[A-Za-z��������������0123456789 ]{1,255}' {$disabled} required>";
                
            } else {
                echo "<br>";
                echo "<label>Lugar:</label>";
                echo "<label>Campus</label>";
            }
        } else {
            echo "<label class='letraNaranja'>Observaci�n:</label>";
            echo "<label class='letraNaranja'>No se pudo cargar la informaci�n del primer llamado para esta mesa de examen</label>";
        }
        echo "</fieldset>";
    }
    echo "</fieldset>";
    echo "<input type='hidden' id='idmesa' name='idmesa' value='".$mesa->getIdmesa()."'>";
    echo "<input type='hidden' id='accion' name='accion' value='modificacion'>";
} else {
    echo "<fieldset>";
    echo "<legend>Resultado</legend>";
    echo "<h6 class='letraRoja letraCentrada'>No se ha obtenido la informaci�n de la mesa de examen a modificar</h6>";
    echo "</fieldset>";
}
echo "</form>";
echo "</div>";
echo "</article>";
echo "</section>";
include_once '../estructura/pie.php';
echo "</html>";
?>