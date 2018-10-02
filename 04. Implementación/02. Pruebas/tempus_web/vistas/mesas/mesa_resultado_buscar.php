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
    
?>
<html>
	<?php include_once '../estructura/encabezado.php'; ?>
	<script type="text/javascript" src="../../js/mesa_resultado_buscar.js"></script>
	<section id="main-content">
		<article>
			<div id="content" class="content">
            	<h2>BUSCAR MESAS DE EXAMEN</h2>
            	<form action="../../Controladores/ManejadorMesa.php" id="formBuscarMesas" name="formBuscarMesas" method="post">
                	
                	<fieldset>
                		<legend>Resultado de la búsqueda</legend>
                		<?php  
                		
                		  $resultado = $_SESSION['resultado'];
                		  if ($resultado['resultado']) {
                		      /* Se ha realizado la operacion */
                		      
                		      $mesas = $resultado['datos'];
                		      
                		      if ($mesas) {
                		          
                		          $Mesas = new Mesas();
                		          
                		          if ($Mesas->cantidadLlamados() > 0) {
                		              /* Se muestra la tabla con dos llamados */
                		              ?>
                    		          <table id="tablaBuscarMesas" class="display">
                        		          <thead>
                            		          <tr>
                                		          <th></th>
                                		          <th>Carrera</th>
                                		          <th>Asignatura</th>
                                		          <th>Presidente</th>
                                		          <th>Vocal1</th>
                                		          <th>Vocal2</th>
                                		          <th>Suplente</th>
                                		          <th>Llamado 1</th>
                                		          <th>Llamado 2</th>
                                		          <th>Hora</th>
                                		          <th>Lugar</th>
                            		          </tr>
                        		          </thead>
                    		          	<tbody>
                    		            <?php
                    		            $tamanio = count($mesas);
                    		            for ($indice=0; $indice<$tamanio; ++$indice) {
                    		                $mesa = $mesas [$indice];
                    		                echo "<tr>";
                    		                echo "<td><input type='radio' name='radioMesas' value='".$indice."'></td>";
                    		                echo "<td>".$mesa->getPlan()->getCarrera()->getNombre()."</td>";
                    		                echo "<td>".$mesa->getPlan()->getAsignatura()->getNombre()."</td>";
                    		                echo "<td>".$mesa->getTribunal()->getPresidente()->getNombre()."</td>";
                    		                echo "<td>".$mesa->getTribunal()->getVocal1()->getNombre()."</td>";
                    		                $vocal2 = "";
                    		                $suplente = "";
                    		                if ($mesa->getTribunal()->getVocal2()) {
                    		                    $vocal2 = $mesa->getTribunal()->getVocal2()->getNombre();
                    		                    if ($mesa->getTribunal()->getSuplente()) {
                    		                        $suplente = $mesa->getTribunal()->getSuplente()->getNombre();
                    		                    }
                    		                }
                    		                echo "<td>".$vocal2."</td>";
                    		                echo "<td>".$suplente."</td>";
                    		                echo "<td>".$mesa->getPrimero()->getFecha()."</td>";
                    		                
                    		                if ($mesa->getSegundo()) {
                    		                    echo "<td>".$mesa->getSegundo()->getFecha()."</td>";
                    		                } else {
                    		                    echo "<td></td>";
                    		                }
                    		               
                    		                echo "<td>".$mesa->getPrimero()->getHora()."</td>";
                    		                echo "<td>campus</td>";
                    		                echo "</tr>";
                    		            }
                        		        ?>
                                     	</tbody>
                                     </table>
                    		     <?php    
                    		      } else {
                    		          /* Se muestra la tabla con un llamado */
                    		          ?>
                    		          <table id="tablaBuscarMesas" class="display">
                        		          <thead>
                            		          <tr>
                                		          <th></th>
                                		          <th>Carrera</th>
                                		          <th>Asignatura</th>
                                		          <th>Presidente</th>
                                		          <th>Vocal1</th>
                                		          <th>Vocal2</th>
                                		          <th>Suplente</th>
                                		          <th>Llamado 1</th>
                                		          <th>Hora</th>
                                		          <th>Lugar</th>
                            		          </tr>
                        		          </thead>
                    		          	<tbody>
                    		            <?php
                        		          $tamanio = count($mesas);
                        		          for ($indice=0; $indice<$tamanio; ++$indice) {
                        		              $mesa = $mesas [$indice];
                        		              echo "<tr>";
                        		              echo "<td><input type='radio' name='radioMesas' value='".$indice."'></td>";
                        		              echo "<td>".$mesa->getPlan()->getCarrera()->getNombre()."</td>";
                        		              echo "<td>".$mesa->getPlan()->getAsignatura()->getNombre()."</td>";
                        		              echo "<td>".$mesa->getTribunal()->getPresidente()->getNombre()."</td>";
                        		              echo "<td>".$mesa->getTribunal()->getVocal1()->getNombre()."</td>";
                        		              $vocal2 = "";
                        		              $suplente = "";
                        		              if ($mesa->getTribunal()->getVocal2()) {
                        		                  $vocal2 = $mesa->getTribunal()->getVocal2()->getNombre();
                        		                  if ($mesa->getTribunal()->getSuplente()) {
                        		                      $suplente = $mesa->getTribunal()->getSuplente()->getNombre();
                        		                  }
                        		              }
                        		              echo "<td>".$vocal2."</td>";
                        		              echo "<td>".$suplente."</td>";
                        		              echo "<td>".$mesa->getPrimero()->getFecha()."</td>";
                        		              echo "<td>".$mesa->getPrimero()->getHora()."</td>";
                        		              
                        		              if ($mesa->getPrimero()->getAula()) {
                        		                  $lugar = $mesa->getPrimero()->getAula()->getSector();
                        		                  $lugar = $lugar." ".$mesa->getPrimero()->getAula()->getNombre();
                        		                  echo "<td>{$lugar}</td>";
                        		              } else {
                        		                  echo "<td>campus</td>";
                        		              }
                        		              echo "</tr>";
                        		          }
                        		        ?>
                                     	</tbody>
                                     </table>
                    		       <?php    
                    		      }
                    		  } else {
                    		      /* No se han encontrado resultados */
                    		      $mensaje = $resultado['mensaje'];
                    		      echo "<h6 class='letraVerde letraCentrada'>{$mensaje}</h6>";
                    		  }
                		  } else {
                		      /* El resultado es falso */
                		      echo "<h6 class='letraRoja letraCentrada'>No se ha obtenido la información sobre mesas de examen para la búsqueda ingresada</h6>";
                		  }
                		?>
                	</fieldset>
                	<?php  if ($mesas) { ?>
                	    	<input class="botonRojo" type="submit" id="btnBorrarMesa" name="btnBorrarMesa" value="Borrar">
                        	<input class="botonVerde" type="submit" id="btnModificarMesa" name="btnModificarMesa" value="Modificar">
                	    	<input type="hidden" id="accion" name="accion" value="">
                	<?php } ?>
            	</form>
            </div>
		</article>
	</section>
	<?php include_once '../estructura/pie.php'; ?>
</html>

