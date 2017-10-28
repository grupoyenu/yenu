<?php  

    header('Content-Type: text/html; charset=ISO-8859-1'); 
    session_start();
?>
<html>
	<?php include_once '../estructura/encabezado.php'; ?>
	<script type="text/javascript" src="../../js/mesa_importar.js"></script>
	<section id="main-content">
		<article>
			<div class="content">
            	<h2>IMPORTAR MESAS DE EXAMEN</h2>
            	<form action="../../Controladores/ManejadorMesa.php" id="formCargarMesas" name="formCargarMesas" method="post" enctype="multipart/form-data">
                	
                <?php 
                    $tamanio = $_FILES['fileMesas']['size'];
                    $nombre = $_FILES['fileMesas']['name'];
                    $nombre_temporal = $_FILES['fileMesas']['tmp_name'];
                    $mensaje = null;
                    
                    if ($tamanio > 0) {
                        /* El archivo contiene información. Se abre. */
                        $mesas = fopen($nombre_temporal,"r");
                        if ($mesas) {
                            /* Se pudo abrir el archivo. Evalua las columnas */
                            $fila = fgetcsv($mesas, 2000, ";");
                            $columnas = count($fila);
                            if (($columnas<9) || ($columnas > 10)) {
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
                    		  	<table id="tablaImportarMesas">
                    		  		<thead>
                                        <tr>
                                        	<th>Codigo</th>
                                            <th>Carrera</th>
                                            <th>Asignatura</th>
                                            <th>Presidente</th>
                                            <th>Vocal1</th>
                                            <th>Vocal2</th>
                                            <th>Suplente</th>
                                            <th>1er llamado</th>
                                       <?php
                                            if ($columnas == 10) {
                                                echo "<th>2do llamado</th>";
                                            }
                                       ?>
                                            <th>Hora</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                            /* $sesionmesas = array que se almacena en la sesion */
                                            $sesionmesas = array();
                                            while (($fila = fgetcsv($mesas, 2000, ";")) !== FALSE) {
                                                
                                                /* Para saber si agregar la fila al array en sesion */
                                                $agregar = TRUE;
                                                
                                                /* Obtiene cada una de las columnas */
                                                $codigo = (int) $fila[0];
                                                $carrera = (string) $fila[1];
                                                $asignatura = (string) $fila[2];
                                                $presidente = (string) $fila[3];
                                                $vocal1 = (string) $fila[4];
                                                $vocal2 = (string) $fila[5];
                                                $suplente = (string) $fila[6];
                                                $primero = (string) $fila[7];
                                                
                                                /* Controla si tiene uno o dos llamados */
                                                if ($columnas == 10) {
                                                    $segundo = (string) $fila[8];
                                                    $hora = (string) $fila[9];
                                                } else {
                                                    $hora = (string) $fila[8];
                                                }
                                                
                                                echo "<tr>";
                                                $mensaje = "";
                                                if($codigo == 0) {
                                                    $mensaje = "style='background-color: #c50000; color: white;' title='No se ha designado codigo o no es numérico'";
                                                    $codigo = $fila[0];
                                                    $agregar = FALSE;
                                                }
                                                echo "<td ".$mensaje.">$codigo</td>";
                                                
                                                $mensaje = "";
                                                if (!$carrera) {
                                                    $mensaje = "style='background-color: #c50000; color: white;' title='No se ha designado un nombre de carrera'";
                                                    $agregar = FALSE;
                                                } else {
                                                    if (ctype_digit($carrera)) {
                                                        $mensaje = "style='background-color: #c50000; color: white;' title='El nombre de carrera es numérico'";
                                                        $agregar = FALSE;
                                                    }
                                                }
                                                echo "<td ".$mensaje.">$carrera</td>";
                                                
                                                $mensaje = "";
                                                if(!$asignatura) {
                                                    $mensaje = "style='background-color: #c50000; color: white;' title='No se ha designado un nombre de asignatura'";
                                                    $agregar = FALSE;
                                                } else {
                                                    if (ctype_digit($asignatura)) {
                                                        $mensaje = "style='background-color: #c50000; color: white;' title='El nombre de asignatura es numérico'";
                                                        $agregar = FALSE;
                                                    }
                                                }
                                                echo "<td ".$mensaje.">$asignatura</td>";
                                                
                                                $mensaje = "";
                                                if(!$presidente) {
                                                    $mensaje = "style='background-color: #c50000; color: white;' title='No se ha designado un presidente de tribunal'";
                                                    $agregar = FALSE;
                                                } else {
                                                    
                                                }
                                                echo "<td ".$mensaje.">$presidente</td>";
                                                
                                                $mensaje = "";
                                                if(!$vocal1) {
                                                    $mensaje = "style='background-color: #c50000; color: white;' title='No se ha designado un vocal primero de tribunal'";
                                                    $agregar = FALSE;
                                                } else {
                                                    
                                                }
                                                echo "<td ".$mensaje.">$vocal1</td>";
                                                
                                                $mensaje = "";
                                                echo "<td ".$mensaje.">$vocal2</td>";
                                                
                                                $mensaje = "";
                                                echo "<td ".$mensaje.">$suplente</td>";
                                                
                                                $mensaje = "";
                                                echo "<td ".$mensaje.">$primero</td>";
                                                
                                                if ($columnas == 10) {
                                                    /* Hay que agregar la columna del segundo llamado */
                                                    $mensaje = "";
                                                    echo "<td".$mensaje.">$segundo</td>";
                                                }
                                                $mensaje = "";
                                                if(!$hora) {
                                                    $mensaje = "style='background-color: #c50000; color: white;' title='No se ha designado horario'";
                                                    $agregar = FALSE;
                                                } else {
                                                    
                                                }
                                                echo "<td ".$mensaje.">$hora</td>";
                                                echo "</tr>";
                                                
                                                if($agregar) {
                                                    if ($columnas == 10) {
                                                        $sesionmesas [] = array($codigo, $carrera, $asignatura, $presidente, $vocal1, $vocal2, $suplente, $primero, $segundo, $hora);
                                                    } else {
                                                        $sesionmesas [] = array($codigo, $carrera, $asignatura, $presidente, $vocal1, $vocal2, $suplente, $primero, $hora);
                                                    }
                                                }
                                            }
                                            $_SESSION['mesas'] = $sesionmesas;
                                    ?>
                                    </tbody>
                    		  	</table>
                    		</fieldset>
                    		<input type="hidden" id="accion" name="accion" value="importar">
                    		<input class="botonVerde" type="submit" id="btnCargarMesas" name="btnCargarMesas" value="Cargar">
                        <?php 
                    }
                ?>            	
            	</form>
            </div>
		</article>
	</section>
	<?php include_once '../estructura/pie.php'; ?>
</html>
