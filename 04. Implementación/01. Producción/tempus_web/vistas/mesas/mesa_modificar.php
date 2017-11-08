<?php
   
    header('Content-Type: text/html; charset=ISO-8859-1');
    include_once '../../modelos/mesas/Mesas.php';
    include_once '../../modelos/carreras/Carrera.php';
    include_once '../../modelos/carreras/Asignatura.php';
    include_once '../../modelos/carreras/Plan.php';
    include_once '../../modelos/mesas/Tribunal.php';
    include_once '../../modelos/mesas/MesaExamen.php';
    include_once '../../modelos/mesas/Llamado.php';
    include_once '../../lib/conf/ControlAcceso.php';

?>
<html>
	<?php include_once '../estructura/encabezado.php'; ?>
	<section id="main-content">
		<article>
			<div class="content">
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
                		              }
                		          }
                		          
                		          if($mesa->getSegundo()) {
                		              $segundo = $mesa->getSegundo()->getFecha();
                		              $segundo = str_replace('/', '-', $segundo);
                		              $segundo = date('Y-m-d', strtotime($segundo));
                		              
                		              $horario = $mesa->getSegundo()->getHora();
                		          }
                		          
                		          ?>
                		          <fieldset>
                    		          <legend><?= $asignatura->getNombre(); ?> - <?= $carrera->getNombre(); ?></legend>
                    		          
                    		          <fieldset>
                        		          <legend>Tribunal</legend>
                        		          <label for="txtNombrePresidente">* Presidente:</label>
                        		          <input type="text" name="txtNombrePresidente" id="txtNombrePresidente" value="<?= $presidente;?>" required>
                        		          
                        		          <label for="txtNombreVocal1">* Vocal 1:</label>
                        		          <input type="text" name="txtNombreVocal1" id="txtNombreVocal1" value="<?= $vocal1;?>" required>
                        		          
                        		          <br>
                        		          
                        		          <label for="txtNombreVocal2">Vocal 2:</label>
                        		          <input type="text" name="txtNombreVocal2" id="txtNombreVocal2" value="<?= $vocal2;?>">
                        		          
                        		          <label for="txtNombreSuplente">Suplente:</label>
                        		          <input type="text" name="txtNombreSuplente" id="txtNombreSuplente" value="<?= $suplente;?>">
                    		          </fieldset>
                    		          <fieldset>
                        		          <legend>Llamados</legend>
                        		          
                        		          <label for="datePrimerLlamado">Primer Llamado:</label>
                        		          <input type="date"  name="datePrimerLlamado" id="datePrimerLlamado" value="<?= $primero;?>">
                        		          
                        		          <label for="dateSegundoLlamado">Segundo Llamado:</label>
                        		          <input type="date" name="dateSegundoLlamado" id="dateSegundoLlamado" value="<?= $segundo;?>">
                        		          
                    		          </fieldset>
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
                		          
                		          </fieldset>
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
                		      echo "<fieldset>";
                		      echo "<legend>Resultado</legend>";
                		      echo "<h6 class='letraRoja letraCentrada'>No se ha obtenido la información de la mesa de examen a modificar</h6>";
                		      echo "</fieldset>";
                		  }
                		  
                    ?>
            	</form>
            </div>
		</article>
	</section>
	<?php include_once '../estructura/pie.php'; ?>
</html>