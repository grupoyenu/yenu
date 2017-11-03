<?php 
    include_once '../../lib/conf/PermisosSistema.php';
    include_once '../../lib/conf/ControlAcceso.php'; 

    ControlAcceso::requierePermiso(PermisosSistema::CURSADAS);
?>
<html>
	<?php include_once '../estructura/encabezado.php'; ?>
	<section id="main-content">
		<article>
			<div class="content">
			
            	<h2>BUSCAR HORARIO DE CURSADA</h2>
            	<form action="../../controladores/ManejadorCursada.php" id="formBuscarCursada" name="formBuscarCursada" method="post" >
            	
            		<fieldset>
            			<legend>Asignatura</legend>
            			<label for="txtAsignatura" class="centrado">Nombre:</label>
            			<input type="text" id="txtAsignatura" name="txtAsignatura" title="Ingrese el nombre de asignatura">
            		</fieldset>
            		<input type="hidden" id="accion" name="accion" value="buscar">
            		<input class="botonVerde" type="submit" id="btnBuscarCursada" name="btnBuscarCursada" value="Buscar">
            		
            	</form>
            	
            </div>
		</article>
	</section>
	<?php include_once '../estructura/pie.php'; ?>
</html>