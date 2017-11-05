<?php 
    include_once '../../lib/conf/ControlAcceso.php'; 
    include_once '../../lib/conf/PermisosSistema.php';
    
    ControlAcceso::requierePermiso(PermisosSistema::CURSADAS);
?>
<html>
	<?php include_once '../estructura/encabezado.php'; ?>
	<script type="text/javascript" src="../../js/cursada_crear.js"></script>
	<section id="main-content">
		<article>
			<div class="content">
			
            	<h2>CREAR HORARIO DE CURSADA</h2>
            	<form action="../../controladores/ManejadorCursada.php" id="formCrearCursada" name="formCrearCursada" method="post" >
            	
            		<fieldset>
            			<legend>Horario</legend>
            			
            			<fieldset>
            				<legend>Información de Carrera y Asignatura</legend>
            				
            				<label for="">* Código de carrera:</label>
            				<input type="number">
            				<label for="">* Nombre de Carrera:</label>
            				<input type="text">
            				<br>
            				<label for="">* Nombre de Asignatura:</label>
            				<input type="text">
            				<label for="">* Año:</label>
            			</fieldset>
            			<fieldset>
            				<legend>Información de clases</legend>
            				<table>
            					<thead>
            						<tr>
            							<th></th>
            							<th>Día</th>
            							<th>Hora de inicio</th>
            							<th>Hora de fin</th>
            							<th>Nombre de sector</th>
            							<th>Nombre de aula</th>
            						</tr>	
            					</thead>
            					<tbody>
            					<?php
            						for ($i = 1; $i < 7; ++$i) {
            						    echo "<tr>";
            						    echo "<td><input type='checkbox' value='{$i}' name='cbDiasClase' id='cbDiasClase'></td>";
            						    $dia = $i;
            						    switch ($i) {
            						        case 1:
            						            $dia = 'Lunes';
            						            break;
            						        case 2:
            						            $dia = 'Martes';
            						            break;
            						        case 3:
            						            $dia = 'Miercoles';
            						            break;
            						        case 4:
            						            $dia = 'Jueves';
            						            break;
            						        case 5:
            						            $dia = 'Viernes';
            						            break;
            						        case 6:
            						            $dia = 'Sábado';
            						            break;
            						    }
            						    
            						    echo "<td>{$dia}</td>";
            						    echo "<td><select name='selectHoraInicio{$i}' id='selectHoraInicio{$i}' disabled='disabled'>";
            						    for ($horainicio = 10; $horainicio < 23; ++$horainicio) {
            						        echo "<option value='{$horainicio}:00'>{$horainicio}:00 hs</option>";
            						    }
            						    echo "</select></td>";
            						    echo "<td><select name='selectHoraFin{$i}' id='selectHoraFin{$i}' disabled='disabled'>";
            						    for ($horafin = 10; $horafin < 23; ++$horafin) {
            						        echo "<option value='{$horafin}:00'>{$horafin}:00 hs</option>";
            						    }
            						    echo "</select></td>";
            						    echo "<td><input type='text' disabled='disabled'></td>";
            						    echo "<td><input type='text' disabled='disabled'></td>";
            						    echo "</tr>";
            						}
            					?>
            					</tbody>
            				</table>
            			</fieldset>
            			
            		</fieldset>
            		<input class="botonVerde" type="submit" id="btnCrearCursada" name="btnCrearCursada" value="Crear">
            	</form>
            	
            </div>
		</article>
	</section>
	<?php include_once '../estructura/pie.php'; ?>
</html>