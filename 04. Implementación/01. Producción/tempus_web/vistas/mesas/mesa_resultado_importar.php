<?php


    include_once '../../lib/conf/ControlAcceso.php'; 
    

   
    
?>

<html>
	<?php include_once '../estructura/encabezado.php'; ?>
	<section id="main-content">
		<article>
			<div class="content">
            	<h2>IMPORTAR MESAS DE EXAMEN</h2>
            	<form>
                	<fieldset>
                		<legend>Resultado</legend>
                		<?php 
                    		$resultado = $_SESSION['resultado'];
                    		
                    		/* Se elimina la variable de sesion */
                    		session_unset($_SESSION['resultado']);
                		    
                    		foreach ($resultado as $valor) {
                    		    echo "Valor: $valor<br />\n";
                    		}
                		?>
                	</fieldset>
            	</form>
            </div>
		</article>
	</section>
	<?php include_once '../estructura/pie.php'; ?>
</html>