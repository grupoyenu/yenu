<html>
	<?php include_once '../estructura/encabezado.php'; ?>
	<section id="main-content">
		<article>
			<div class="content">
			
            	<h2>IMPORTAR HORARIOS DE CURSADA</h2>
            	<form action="cursada_importar.php" enctype="multipart/form-data" id="formSeleccionarCursadas" name="formSeleccionarCursadas" method="post" >
            	
            		<fieldset>
            			<legend>Selección de archivo</legend>
            			
            			<label for="fileCursadas">Archivo:</label>
           				<input type="file" id="fileCursadas" name="fileCursadas" accept=".csv">
            			
            		</fieldset>
            		<input class="botonVerde" type="submit" id="btnImportarCursadas" name="btnImportarCursadas" value="Importar">
            	</form>
            	
            </div>
		</article>
	</section>
	<?php include_once '../estructura/pie.php'; ?>
</html>
