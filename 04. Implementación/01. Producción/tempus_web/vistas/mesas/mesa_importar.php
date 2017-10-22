
<?php  header('Content-Type: text/html; charset=ISO-8859-1'); ?>

<html>

	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.16/datatables.min.css"/>
	<?php include_once '../estructura/encabezado.php'; ?>
	<script type="text/javascript" src="../../js/mesa_importar.js"></script>
	<section id="main-content">
		<article>
			<div class="content">
			
            	<h2>IMPORTAR MESAS DE EXAMEN</h2>
            	<form action="../../Controladores/ManejadorMesa.php" id="formCargarMesas" name="formCargarMesas" method="post" enctype="multipart/form-data">
            	<?php
            	   
                    $tamanio = $_FILES['fileMesas']['size'];
                    $fichero_subido = $_FILES['fileMesas']['name'];
                    
            		if ($tamanio > 0) {
            		    
            		    /* EL ARCHIVO TIENE FILAS PARA PROCESAR */
            		    
            		    $fichero_temporal = $_FILES['fileMesas']['tmp_name'];
            		    
            		    if (move_uploaded_file($fichero_temporal, $fichero_subido)) {
            		        
            		        $mesas = fopen($fichero_subido,"r");
            		        
            		        if($mesas) {
            		            
            		        /* EL ARCHIVO SE PUDO ABRIR */
            		            
            		        ?><fieldset>
                    		  		<legend><?= $fichero_subido ?></legend>
                        		  	<table id="tablaImportarMesas" class="display">
                            			<thead>
                                            <tr>
                                            	<th>Codigo</th>
                                                <th>Carrera</th>
                                                <th>Asignatura</th>
                                                <th>Presidente</th>
                                                <th>Vocal1</th>
                                                <th>Vocal2</th>
                                                <th>Suplente</th>
                                                <th>Primer llamado</th>
                                                <th>Segundo llamado</th>
                                                <th>Hora</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php while (($data = fgetcsv($mesas, 1000, ";")) !== FALSE) { ?>
                                            	<tr>
                                            		<td><?= $data[0] ?></td>
                                            		<td><?= $data[1] ?></td>
                                            		<td><?= $data[2] ?></td>
                                            		<td><?= $data[3] ?></td>
                                            		<td><?= $data[4] ?></td>
                                            		<td><?= $data[5] ?></td>
                                            		<td><?= $data[6] ?></td>
                                            		<td><?= $data[7] ?></td>
                                            		<td><?= $data[8] ?></td>
                                            		<td><?= $data[9] ?></td>
                                            	</tr>
                                        <?php } ?>
                            			</tbody>
                            		</table> 
                            	</fieldset>
                		
                    			<input type="hidden" id="accion" name="accion" value="importar">
                    			<input class="botonVerde" type="submit" id="btnCargarMesas" name="btnCargarMesas" value="Cargar">  
                			<?php } else { ?> 
                			
                    			<fieldset>
                    				<legend><?= $fichero_subido ?></legend>
                    				<h3>El archivo seleccionado no se pudo procesar.</h3>
                    			</fieldset>
                    			
            					<?php }
                		    
                		  } else { ?>
                			
                    			<fieldset>
                    				<legend><?= $fichero_subido ?></legend>
                    				<h3>El archivo seleccionado no se pudo mover.</h3>
                    			</fieldset>
                    			
            			<?php }
            		} else { ?> 
            		
            			<fieldset>
            				<legend><?= $fichero_subido ?></legend>
            				<h3>El archivo seleccionado se encuentra vacío.</h3>
            			</fieldset>
            		
            		<?php } ?>
            	</form>
            	
            </div>
		</article>
	</section>
	
	<?php include_once '../estructura/pie.php'; ?>

</html>
