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

    
    $mesas = new Mesas();
    $llamados = $mesas->cantidadLlamados();
?>
<html>
	<?php include_once '../estructura/encabezado.php'; ?>
	<script type="text/javascript" src="../../js/mesa_modificar.js"></script>
	<section id="main-content">
		<article>
			<div id="content" class="content">
            	<h2>MODIFICAR MESA DE EXAMEN</h2>
            	<form action="../../Controladores/ManejadorMesa.php" id="formModificarMesa" name="formModificarMesa" method="post">
                	
                	<?php
                		  $resultado = $_SESSION['resultado'];
                		  if (isset($resultado)) {
                		      
                		      if (isset($resultado['datos'])) {
                		          
                		          /* Recupera la informacion de la mesa de examen */
                		          
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
                		          
                		          $horario = '';
                		          $primero = "";
                		          $segundo = "";
                		          if($mesa->getPrimero()) {
                		              $primero = $mesa->getPrimero()->getFecha();
                		              $primero = str_replace('/', '-', $primero);
                		              $primero = date('Y-m-d', strtotime($primero));
                		              
                		              if (!$mesa->getSegundo()) {
                		                  $horario = $mesa->getPrimero()->getHora();
                		                  
                		                  if ($mesa->getPrimero()->getAula()) {
                		                      $sector = $mesa->getPrimero()->getAula()->getSector();
                		                      $nombreaula = $mesa->getPrimero()->getAula()->getNombre();
                		                  }
                		              }
                		          }
                		          
                		          if($mesa->getSegundo()) {
                		              $segundo = $mesa->getSegundo()->getFecha();
                		              $segundo = str_replace('/', '-', $segundo);
                		              $segundo = date('Y-m-d', strtotime($segundo));
                		              $horario = $mesa->getSegundo()->getHora();
                		              
                		              if ($mesa->getSegundo()->getAula()) {
                		                  $sector = $mesa->getSegundo()->getAula()->getSector();
                		                  $nombreaula = $mesa->getSegundo()->getAula()->getNombre();
                		              }
                		          }
                		          
                		          ?>
                		          <fieldset>
                    		          <legend><?= $asignatura->getNombre(); ?> - <?= $carrera->getNombre(); ?></legend>
                    		          
                    		          <fieldset>
                        		          <legend>Tribunal</legend>
                        		          <label for="txtNombrePresidente">* Presidente:</label>
                        		          <input type="text" name="txtNombrePresidente" id="txtNombrePresidente" value="<?= $presidente;?>" pattern="[A-Za-záéíóúÁÉÍÓÚñÑ. ]{10,255}" required>
                        		          
                        		          <label for="txtNombreVocal1">* Vocal 1:</label>
                        		          <input type="text" name="txtNombreVocal1" id="txtNombreVocal1" value="<?= $vocal1;?>" pattern="[A-Za-záéíóúÁÉÍÓÚñÑ0123456789,. ]{5,255}" required>
                        		          
                        		          <br>
                        		          
                        		          <label for="txtNombreVocal2">Vocal 2:</label>
                        		          <input type="text" name="txtNombreVocal2" id="txtNombreVocal2" value="<?= $vocal2;?>" pattern="[A-Za-záéíóúñüÁÉÍÓÚÜÑ,. ]{4,255}">
                        		          
                        		          <label for="txtNombreSuplente">Suplente:</label>
                        		          <input type="text" name="txtNombreSuplente" id="txtNombreSuplente" value="<?= $suplente;?>" pattern="[A-Za-záéíóúñüÁÉÍÓÚÜÑ,. ]{4,255}">
                    		          </fieldset>
                    		          <fieldset>
                        		          <legend>Llamados</legend>
                        		          
                        		          <label for="datePrimerLlamado">Primer Llamado:</label>
                        		          <input type="date"  name="datePrimerLlamado" id="datePrimerLlamado" value="<?= $primero;?>">
                        		          <?php
                        		              if ($llamados && $llamados > 0) {
                            		          ?>
                            		          	 <label for="dateSegundoLlamado">Segundo Llamado:</label>
                        		         		 <input type="date" name="dateSegundoLlamado" id="dateSegundoLlamado" value="<?= $segundo;?>">
                            		          <?php
                            		          }
                        		          ?>
                    		          </fieldset>
                    		          
                    		          <?php
                    		          
                    		          if ($sector && $nombreaula) {
                    		              
                    		              ?>
                    		              <fieldset>
                            		          <legend>Lugar</legend>
                            		          <label for="txtSector">* Sector</label>
                            		          <input type="text" name="txtSector" id="txtSector" value="<?= $sector; ?>" pattern="[A-Z]" maxlength="1" required>
                            		        	
                            		          <label for="txtNombreAula">* Nombre aula:</label>
                            		          <input type="text" name="txtNombreAula" id="txtNombreAula" value="<?= $nombreaula; ?>" pattern="[A-Za-záéíóúñüÁÉÍÓÚÜÑ0123456789 ]{1,255}" required>
        		        		
        		        					  <br>
        		        					  
                            		          <label for="selectHora">* Hora</label>
                            		          <select  name="selectHora" id="selectHora">
                        		          		<?php
                            		                for ($hora = 10; $hora < 23; ++$hora) {
                            		                    $hora2 = $hora.':00';
                            		                    if($hora2 == $horario) {
                            		                        echo "<option value='{$hora2}' selected>{$hora2} hs</option>";
                            		                    } else {
                            		                        echo "<option value='{$hora2}'>{$hora2} hs</option>";
                            		                    }
                                					}
                                				?>
                        		          	</select>
                        		          </fieldset>
                    		              <?php 
                    		              
                    		          } else {
                    		              ?>
                    		              <fieldset>
                            		          <legend>Horario</legend>
                            		          <label for="selectHora">* Hora</label>
                            		          <select  name="selectHora" id="selectHora">
                        		          		<?php
                            		                for ($hora = 10; $hora < 23; ++$hora) {
                            		                    $hora2 = $hora.':00';
                            		                    if($hora2 == $horario) {
                            		                        echo "<option value='{$hora2}' selected>{$hora2} hs</option>";
                            		                    } else {
                            		                        echo "<option value='{$hora2}'>{$hora2} hs</option>";
                            		                    }
                                					}
                                				?>
                        		          	</select>
                        		          </fieldset>
                    		              <?php  
                    		          }
                		         	  ?>
                		          </fieldset>
                		          <input type="hidden" id="idmesa" name="idmesa" value="<?= $mesa->getIdmesa(); ?>">
                		          <input type="hidden" id="accion" name="accion" value="modificacion">
                		          <input class="botonVerde" type="submit" name="btnModificarMesa" id="btnModificarMesa" value="Modificar">
                		          
                		      <?php  
                		      } else {
                		          /* No se han obtenido los datos */
                		          echo "<fieldset>";
                		          echo "<legend>Resultado</legend>";
                		          echo "<h6 class='letraRoja letraCentrada'>No se ha obtenido la información de la mesa de examen a modificar</h6>";
                		          echo "</fieldset>";
                		      }
                		      
                		  } else {
                		      /* No se ha definido resultado o es nulo (isset) */
                		      echo "<fieldset>
                                        <legend>Resultado</legend>
                                        <h6 class='letraRoja letraCentrada'>No se ha obtenido la información de la mesa de examen a modificar</h6>
                                    </fieldset>";
                		  }
                		  
                    ?>
            	</form>
            </div>
		</article>
	</section>
	<?php include_once '../estructura/pie.php'; ?>
</html>