<?php 
    include_once '../../modelos/carreras/Plan.php'; 
    include_once '../../modelos/aulas/Aula.php'; 
    include_once '../../modelos/cursadas/Clase.php'; 
    include_once '../../modelos/cursadas/Cursada.php'; 
    include_once '../../lib/conf/ControlAcceso.php'; 

?>

<html>
	<?php include_once '../estructura/encabezado.php'; ?>
	<script type="text/javascript" src="../../js/cursada_resultado_buscar.js"></script>
	<section id="main-content">
		<article>
			<div id="content" class="content">
            	<h2>BUSCAR HORARIO DE CURSADA</h2>
            	<form action="" id="formBuscarCursadas" name="formBuscarCursadas" method="post">
                	
                	<fieldset>
                		<legend>Resultado de la búsqueda</legend>
                		<?php
                		    /* Se obtiene el resultado y se elimina de la sesion. */
                    		$resultado = $_SESSION['resultado'];
                    		
                    		if ($resultado['resultado']) {
                    		    
                    		    $cursadas = $resultado['datos'];
                    		    
                    		    /* Se elimina la variable de sesion */
                    		    if ($cursadas) {
                    		        ?>
                    			<br>
                    			<table id="tablaBuscarCursadas" class="display">
                    				<thead>
                    					<tr>	
                    						<th></th>
                    						<th>Carrera</th>
                    						<th>Asignatura</th>
                    						<th>Lunes</th>
                    						<th>Martes</th>
                    						<th>Miercoles</th>
                    						<th>Jueves</th>
                    						<th>Viernes</th>
                    						<th>Sabado</th>
                    					</tr>
                    				</thead>
                    				<tbody>
                    				<?php
                    		        
                    				foreach ($cursadas as $cursada) {
                    				    
                    				    $plan = $cursada->getPlan();
                    				    $asignatura = $plan->getAsignatura();
                    				    $carrera = $plan->getCarrera();
                    				    $clases = $cursada->getClases();
                    				    
                    				    echo "<tr>";
                    				    echo "<td><input type='radio' id='radioCursadas' name='radioCursadas'></td>";
                    				    echo "<td>{$carrera->getNombre()}</td>";
                    				    echo "<td>{$asignatura->getNombre()}</td>";
                    				    
                    				    $cantidad = count($clases);
                    				    
                    				    for ($i=1; $i<7; $i++) {
                    				        
                    				        if (isset($clases[$i])) {
                    				            
                    				            $aula = $clases[$i]->getAula();
                    				            
                    				            $dia = $clases[$i]->getDesde()." a ".$clases[$i]->getHasta()." ".$aula->getSector()." ".$aula->getNombre();
                    				            
                    				            echo "<td>{$dia}</td>";
                    				        } else {
                    				            echo "<td></td>";
                    				        }
                    				    }
                    				    
                    				    echo "</tr>";
                    				}
                                    ?>
                    				</tbody>
                    			</table>
                        		<?php
                        		} else {
                        		    /* No se han encontrado resultados */
                        		    $mensaje = $resultado['mensaje'];
                        		    echo "<h6 class='letraVerde letraCentrada'>{$mensaje}</h6>";
                        		}
                    		    
                    		} else {
                    		    /* El resultado es falso */
                    		    echo "<h6 class='letraRoja letraCentrada'>No se ha obtenido la información sobre cursadas para la búsqueda ingresada</h6>";
                    		}
                        ?>
                	</fieldset>
                	<?php
                    	if($cursadas) {
                    ?>
                       		<input class="botonRojo" type="submit" id="btnBorrarCursada" name="btnBorrarCursada" value="Borrar">
                        	<input class="botonVerde" type="submit" id="btnModificarCursada" name="btnModificarCursada" value="Modificar">
                        	<input type="hidden" id="accion" name="accion" value="">
                    <?php
                    	}
                    ?>
            	</form>
            </div>
		</article>
	</section>
	<?php include_once '../estructura/pie.php'; ?>
</html>
