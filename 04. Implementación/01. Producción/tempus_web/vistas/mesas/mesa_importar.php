<?php  
    header('Content-Type: text/html; charset=ISO-8859-1'); 
    include_once '../../lib/conf/Utilidades.php';
    
    /* Controla que solo se acceda de la pagina donde se importa el archivo */
    $ubicacion = $_SERVER["PHP_SELF"];
    if($ubicacion != '/tempus/vistas/mesas/mesa_importar.php') {
        header("Location: " . Constantes::HOMEURL);
    }
    
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
                                        $estilo = " style='background-color: #c50000; color: white;' ";
                                        if ($columnas == 10) {
                                            
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
                                                $segundo = (string) $fila[8];
                                                $hora = (string) $fila[9];
                                                
                                                echo "<tr>";
                                                $mensaje = Utilidades::formatoCodigoCarrera($codigo);
                                                if($codigo == 0) {
                                                    $mensaje = $estilo." title='{$mensaje}'";
                                                    $codigo = $fila[0];
                                                    $agregar = FALSE;
                                                }
                                                echo "<td ".$mensaje.">$codigo</td>";
                                                
                                                $mensaje = Utilidades::formatoNombreCarrera($carrera);
                                                if ($mensaje) {
                                                    $mensaje = $estilo." title='{$mensaje}'";
                                                    $agregar = FALSE;
                                                }
                                                echo "<td ".$mensaje.">$carrera</td>";
                                                
                                                $mensaje = Utilidades::formatoNombreAsignatura($asignatura);
                                                if($mensaje) {
                                                    $mensaje = $estilo." title='{$mensaje}'";
                                                    $agregar = FALSE;
                                                }
                                                echo "<td ".$mensaje.">$asignatura</td>";
                                                
                                                $mensaje = "";
                                                if(!$presidente) {
                                                    /* El presidente es obligatorio */
                                                    $mensaje = $estilo." title='No se ha designado un presidente de tribunal'";
                                                    $agregar = FALSE;
                                                } else {
                                                    /* Se controla el formato del docente agregado */
                                                    $mensaje = Utilidades::formatoNombreDocente($presidente);
                                                    if ($mensaje) {
                                                        $mensaje = $estilo." title='{$mensaje}'";
                                                        $agregar = FALSE;
                                                    }
                                                }
                                                echo "<td ".$mensaje.">$presidente</td>";
                                                
                                                $mensaje = "";
                                                if(!$vocal1) {
                                                    /* El vocal 1 es obligatorio */
                                                    $mensaje = $estilo." title='No se ha designado un vocal primero de tribunal'";
                                                    $agregar = FALSE;
                                                } else {
                                                    /* Se controla el formato del docente agregado */
                                                    $mensaje = Utilidades::formatoNombreDocente($vocal1);
                                                    if ($mensaje) {
                                                        $mensaje = $estilo." title='{$mensaje}'";
                                                        $agregar = FALSE;
                                                    }
                                                }
                                                echo "<td ".$mensaje.">$vocal1</td>";
                                                
                                                $mensaje = "";
                                                if ($vocal2) {
                                                    /* Solo en caso que se agregue alguna cadena se verifica porque el vocal 2 no es obligatorio */
                                                    $mensaje = Utilidades::formatoNombreDocente($vocal2);
                                                    if ($mensaje) {
                                                        $mensaje = $estilo." title='{$mensaje}'";
                                                        $agregar = FALSE;
                                                    }
                                                    echo "<td ".$mensaje.">$vocal2</td>";
                                                    $mensaje = "";
                                                    if ($suplente) {
                                                        $mensaje = Utilidades::formatoNombreDocente($suplente);
                                                        if ($mensaje) {
                                                            $mensaje = $estilo." title='{$mensaje}'";
                                                            $agregar = FALSE;
                                                        }
                                                    }
                                                    echo "<td ".$mensaje.">$suplente</td>";
                                                } else {
                                                    /* Como no hay vocal suplente no deberia haber suplente */
                                                    echo "<td ".$mensaje.">$vocal2</td>";
                                                    $mensaje = "";
                                                    if ($suplente) {
                                                        $mensaje = $estilo." title='El suplente debe ocupar el lugar de vocal 2'";
                                                        $agregar = FALSE;
                                                    }
                                                    echo "<td ".$mensaje.">$suplente</td>";
                                                }
                                                
                                                if ($primero && $segundo) {
                                                    $mensaje = Utilidades::formatoFecha($primero);
                                                    if ($mensaje) {
                                                        $mensaje = $estilo." title='{$mensaje}'";
                                                        $agregar = FALSE;
                                                    }
                                                    echo "<td ".$mensaje.">$primero</td>";
                                                    
                                                    $mensaje = Utilidades::formatoFecha($segundo);
                                                    if ($mensaje) {
                                                        $mensaje = $estilo." title='{$mensaje}'";
                                                        $agregar = FALSE;
                                                    }
                                                    echo "<td ".$mensaje.">$segundo</td>";
                                                } else {
                                                    $mensaje = $estilo." title='Ambos llamados se han omitido'";
                                                    echo "<td ".$mensaje.">$primero</td>";
                                                    echo "<td ".$mensaje.">$segundo</td>";
                                                }
                                                
                                                $mensaje = Utilidades::formatoHora($hora);
                                                if($mensaje) {
                                                    $mensaje = $estilo." title='{$mensaje}'";
                                                    $agregar = FALSE;
                                                }
                                                echo "<td ".$mensaje.">$hora</td>";
                                                echo "</tr>";
                                                
                                                if($agregar) {
                                                    /* agrega la fila al array que se almacena en la sesion. */
                                                    $sesionmesas [] = array($codigo, $carrera, $asignatura, $presidente, $vocal1, $vocal2, $suplente, $primero, $segundo, $hora);
                                                }
                                            }
                                            
                                        } else {
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
                                                $hora = (string) $fila[8];
                                                
                                                echo "<tr>";
                                                $mensaje = Utilidades::formatoCodigoCarrera($codigo);
                                                if($codigo == 0) {
                                                    $mensaje = $estilo." title='{$mensaje}'";
                                                    $codigo = $fila[0];
                                                    $agregar = FALSE;
                                                }
                                                echo "<td ".$mensaje.">$codigo</td>";
                                                
                                                $mensaje = Utilidades::formatoNombreCarrera($carrera);
                                                if ($mensaje) {
                                                    $mensaje = $estilo." title='{$mensaje}'";
                                                    $agregar = FALSE;
                                                }
                                                echo "<td ".$mensaje.">$carrera</td>";
                                                
                                                $mensaje = Utilidades::formatoNombreAsignatura($asignatura);
                                                if($mensaje) {
                                                    $mensaje = $estilo." title='{$mensaje}'";
                                                    $agregar = FALSE;
                                                }
                                                echo "<td ".$mensaje.">$asignatura</td>";
                                                
                                                $mensaje = "";
                                                if(!$presidente) {
                                                    /* El presidente es obligatorio */
                                                    $mensaje = $estilo." title='No se ha designado un presidente de tribunal'";
                                                    $agregar = FALSE;
                                                } else {
                                                    /* Se controla el formato del docente agregado */
                                                    $mensaje = Utilidades::formatoNombreDocente($presidente);
                                                    if ($mensaje) {
                                                        $mensaje = $estilo." title='{$mensaje}'";
                                                        $agregar = FALSE;
                                                    }
                                                }
                                                echo "<td ".$mensaje.">$presidente</td>";
                                                
                                                $mensaje = "";
                                                if(!$vocal1) {
                                                    /* El vocal 1 es obligatorio */
                                                    $mensaje = $estilo." title='No se ha designado un vocal primero de tribunal'";
                                                    $agregar = FALSE;
                                                } else {
                                                    /* Se controla el formato del docente agregado */
                                                    $mensaje = Utilidades::formatoNombreDocente($vocal1);
                                                    if ($mensaje) {
                                                        $mensaje = $estilo." title='{$mensaje}'";
                                                        $agregar = FALSE;
                                                    }
                                                }
                                                echo "<td ".$mensaje.">$vocal1</td>";
                                                
                                                $mensaje = "";
                                                if ($vocal2) {
                                                    /* Solo en caso que se agregue alguna cadena se verifica porque el vocal 2 no es obligatorio */
                                                    $mensaje = Utilidades::formatoNombreDocente($vocal2);
                                                    if ($mensaje) {
                                                        $mensaje = $estilo." title='{$mensaje}'";
                                                        $agregar = FALSE;
                                                    }
                                                    echo "<td ".$mensaje.">$vocal2</td>";
                                                    $mensaje = "";
                                                    if ($suplente) {
                                                        $mensaje = Utilidades::formatoNombreDocente($suplente);
                                                        if ($mensaje) {
                                                            $mensaje = $estilo." title='{$mensaje}'";
                                                            $agregar = FALSE;
                                                        }
                                                    }
                                                    echo "<td ".$mensaje.">$suplente</td>";
                                                } else {
                                                    /* Como no hay vocal suplente no deberia haber suplente */
                                                    echo "<td ".$mensaje.">$vocal2</td>";
                                                    $mensaje = "";
                                                    if ($suplente) {
                                                        $mensaje = $estilo." title='El suplente debe ocupar el lugar de vocal 2'";
                                                        $agregar = FALSE;
                                                    }
                                                    echo "<td ".$mensaje.">$suplente</td>";
                                                }
                                                
                                                $mensaje = Utilidades::formatoFecha($primero);
                                                if ($mensaje) {
                                                    $mensaje = $estilo." title='{$mensaje}'";
                                                    $agregar = FALSE;
                                                }
                                                echo "<td ".$mensaje.">$primero</td>";
                                                
                                                $mensaje = Utilidades::formatoHora($hora);
                                                if($mensaje) {
                                                    $mensaje = $estilo." title='{$mensaje}'";
                                                    $agregar = FALSE;
                                                }
                                                echo "<td ".$mensaje.">$hora</td>";
                                                echo "</tr>";
                                                
                                                if($agregar) {
                                                    /* agrega la fila al array que se almacena en la sesion. */
                                                    $sesionmesas [] = array($codigo, $carrera, $asignatura, $presidente, $vocal1, $vocal2, $suplente, $primero, $hora);
                                                }
                                            }
                                        }
                                            
                                        $_SESSION['mesas'] = $sesionmesas;
                                    ?>
                                    </tbody>
                    		  	</table>
                    		</fieldset>
                    		<?php
                    		  if (count($sesionmesas) > 0) {
                    		?>  
                    		      <input type="hidden" id="accion" name="accion" value="importar">
                    		      <input class="botonVerde" type="submit" id="btnCargarMesas" name="btnCargarMesas" value="Cargar">
                    		<?php 
                    		  }
                    }
                ?>            	
            	</form>
            </div>
		</article>
	</section>
	<?php include_once '../estructura/pie.php'; ?>
</html>
