
<?php 

    header('Content-Type: text/html; charset=ISO-8859-1'); 
    include_once '../../lib/conf/ControlAcceso.php';
    include_once '../../lib/conf/PermisosSistema.php';
    
    /*
    ControlAcceso::requierePermiso(PermisosSistema::MESAS);
    */
?>

<html>
	<?php include_once '../estructura/encabezado.php'; ?>
	<section id="main-content">
		<article>
			<div class="content">
			
            	<h2>BUSCAR MESAS DE EXAMEN</h2>
            	<form action="../../controladores/ManejadorMesa.php" id="formBuscarMesas" name="formBuscarMesas" method="post" >
            	
            		<fieldset>
            			<legend>Asignatura</legend>
            			
            			<label for="txtAsignatura" class="centrado">Nombre:</label>
            			<input type="text" id="txtAsignatura" name="txtAsignatura" title="Ingrese el nombre de la asignatura">
           				
            		</fieldset>
            		<input type="hidden" id="accion" name="accion" value="buscar">
            		<input class="botonVerde" type="submit" id="btnBuscarMesas" name="btnBuscarMesas" value="Buscar">
            	</form>
            	
            </div>
		</article>
	</section>
	<?php include_once '../estructura/pie.php'; ?>
</html>
