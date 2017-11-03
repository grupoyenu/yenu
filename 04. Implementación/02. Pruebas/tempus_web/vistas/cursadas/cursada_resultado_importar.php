<?php

    include_once '../../lib/conf/ControlAcceso.php';
    
    
?>

<html>
	<?php include_once '../estructura/encabezado.php'; ?>
	<section id="main-content">
		<article>
			<div class="content">
            	<h2>IMPORTAR HORARIOS DE CURSADA</h2>
            	<form>
                	<fieldset>
                		<legend>Resultado</legend>
                		<?php 
                		
                    		$resultado = $_SESSION['resultado'];
                    		
                    		echo '<pre>'; print_r($resultado); echo '</pre>';
		    
                    		session_unset($_SESSION['resultado']);
                		    
                    		if ($resultado['resultado']) {
                    		    
                    		    echo "<h3>{$resultado['mensaje']}</h3>";
                    		    
                    		    if ($resultado['datos']) {
                    		        echo '<pre>'; print_r($resultado['datos']); echo '</pre>';
                    		    }
                    		} else {
                    		    /* No se ha realizado la operación */
                    		    
                    		    echo "<h4 class='letraRoja'>{$resultado['mensaje']}</h4>";
                    		}
                    		
                		?>
                	</fieldset>
            	</form>
            </div>
		</article>
	</section>
	<?php include_once '../estructura/pie.php'; ?>
</html>