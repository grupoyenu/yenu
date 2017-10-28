<?php

    header('Content-Type: text/html; charset=ISO-8859-1');
    session_start();
    
?>
<html>
	<?php include_once '../estructura/encabezado.php'; ?>
	<script type="text/javascript" src="../../js/cursada_importar.js"></script>
	<section id="main-content">
		<article>
			<div class="content">
            	<h2>IMPORTAR HORARIOS DE CURSADA</h2>
            	<form action="../../Controladores/ManejadorCursada.php" id="formCargarCursadas" name="formCargarCursadas" method="post" enctype="multipart/form-data">
                
                <?php 
                    $tamanio = $_FILES['fileCursadas']['size'];
                    $nombre = $_FILES['fileCursadas']['name'];
                    $nombre_temporal = $_FILES['fileCursadas']['tmp_name'];
                    $mensaje = null;
                    
                    if ($tamanio > 0) {
                        /* El archivo contiene información. Se abre. */
                        $cursadas = fopen($nombre_temporal,"r");
                        if ($cursadas) {
                            /* Se pudo abrir el archivo. Evalua las columnas */
                            $fila = fgetcsv($cursadas, 2000, ";");
                            $columnas = count($fila);
                            if ($columnas != 28) {
                                $mensaje = "El archivo seleccionado tiene una cantidad de columnas inválidas (".$columnas." columnas).";
                            }
                        } else {
                            $mensaje = "El archivo seleccionado no se pudo abrir.";
                        }
                    } else {
                        $mensaje = "El archivo seleccionado está vacío.";
                    }
                    
                    if ($mensaje) {
                        /* El archivo no ha pasado las validaciones. Se muestra el mensaje. */
                        echo "<fieldset>";
                        echo "<legend>".$nombre."</legend>";
                        echo "<h3>".$mensaje."</h3>";
                        echo "</fieldset>";
                    } else {
                        /* El archivo ha pasado las validaciones. Se puede cargar la tabla. */
                        
                    ?>
                		<fieldset>
                    		<legend><?= $nombre ?></legend>
                        	<table id="tablaImportarCursadas" class="display">
                        		<thead>
                        			<tr>
                        				<th>Código</th>
                        				<th>Carrera</th>
                        				<th>Asignatura</th>
                        				<th>Año</th>
                        				<th>Lunes</th>
                        				<th>Martes</th>
                        				<th>Miercoles</th>
                        				<th>Jueves</th>
                        				<th>Viernes</th>
                        				<th>Sábado</th>
                        			</tr>
                        		</thead>
                        		<tbody>
                        		<?php
                        		    /* $sesioncursadas = array que se almacena en la sesion */
                        		    $sesioncursadas = array();
                        		    while (($fila = fgetcsv($cursadas, 2000, ";")) !== FALSE) {
                        		        /* Para saber si agregar la fila al array en sesion */
                        		        $agregar = TRUE;
                        		        
                        		        $codigo = (int) $fila[0];
                        		        $carrera = (string) $fila[1];
                        		        $asignatura = (string) $fila[2];
                        		        $anio = (string) $fila[3];
                        		        
                        		        /* Informacion de 1 = Lunes */
                        		        $desde1 = (string) $fila[4];
                        		        $hasta1 = (string) $fila[5];
                        		        $sector1 = (string) $fila[6];
                        		        $aula1 = (string) $fila[7];
                        		        
                        		        /* Informacion de 2 = Martes */
                        		        $desde2 = (string) $fila[8];
                        		        $hasta2 = (string) $fila[9];
                        		        $sector2 = (string) $fila[10];
                        		        $aula2 = (string) $fila[11];
                        		        
                        		        /* Informacion de 3 = Miercoles */
                        		        $desde3 = (string) $fila[12];
                        		        $hasta3 = (string) $fila[13];
                        		        $sector3 = (string) $fila[14];
                        		        $aula3 = (string) $fila[15];
                        		        
                        		        /* Informacion de 4 = Jueves */
                        		        $desde4 = (string) $fila[16];
                        		        $hasta4 = (string) $fila[17];
                        		        $sector4 = (string) $fila[18];
                        		        $aula4 = (string) $fila[19];
                        		        
                        		        /* Informacion de 5 = Viernes */
                        		        $desde5 = (string) $fila[20];
                        		        $hasta5 = (string) $fila[21];
                        		        $sector5 = (string) $fila[22];
                        		        $aula5 = (string) $fila[23];
                        		        
                        		        /* Informacion de 6 = Sabado */
                        		        $desde6 = (string) $fila[24];
                        		        $hasta6 = (string) $fila[25];
                        		        $sector6 = (string) $fila[26];
                        		        $aula6 = (string) $fila[27];
                        		        
                        		        echo "<tr>";
                        		        echo "<td>$codigo</td>";
                        		        echo "<td>$carrera</td>";
                        		        echo "<td>$asignatura</td>";
                        		        echo "<td>$anio</td>";
                        		        
                        		        $lunes = "";
                        		        if ($desde1 && $hasta1 && $sector1 && $aula1) {
                        		            $lunes = $desde1." a ".$hasta1." en ".$sector1." - ".$aula1;
                        		        }
                        		        echo "<td>".$lunes."</td>";
                        		        
                        		        $martes = "";
                        		        if ($desde2 && $hasta2 && $sector2 && $aula2) {
                        		            $martes = $desde2." a ".$hasta2." en ".$sector2." - ".$aula2;
                        		        }
                        		        echo "<td>".$martes."</td>";
                        		        
                        		        $miercoles = "";
                        		        if ($desde3 && $hasta3 && $sector3 && $aula3) {
                        		            $miercoles = $desde3." a ".$hasta3." en ".$sector3." - ".$aula3;
                        		        }
                        		        echo "<td>".$miercoles."</td>";
                        		        
                        		        $jueves = "";
                        		        if ($desde4 && $hasta4 && $sector4 && $aula4) {
                        		            $jueves = $desde4." a ".$hasta4." en ".$sector4." - ".$aula4;
                        		        }
                        		        echo "<td>".$jueves."</td>";
                        		        
                        		        $viernes = "";
                        		        if ($desde5 && $hasta5 && $sector5 && $aula5) {
                        		            $viernes = $desde5." a ".$hasta5." en ".$sector5." - ".$aula5;
                        		        }
                        		        echo "<td>".$viernes."</td>";
                        		        
                        		        $sabado = "";
                        		        if ($desde6 && $hasta6 && $sector6 && $aula6) {
                        		            $sabado = $desde6." a ".$hasta6." en ".$sector6." - ".$aula6;
                        		        }
                        		        echo "<td>".$sabado."</td>";
                        		        
                        		        echo "</tr>";
                        		    }
                        		?>
                        		</tbody>
                        	</table>  
                        </fieldset>        	
                        <input type="hidden" id="accion" name="accion" value="importar">
                    	<input class="botonVerde" type="submit" id="btnCargarCursadas" name="btnCargarCursadas" value="Cargar">
                <?php 
                    }
                ?>
            	</form>
            </div>
		</article>
	</section>
	<?php include_once '../estructura/pie.php'; ?>
</html>
