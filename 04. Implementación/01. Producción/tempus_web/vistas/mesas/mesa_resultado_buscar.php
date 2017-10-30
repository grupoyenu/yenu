<?php  
    header('Content-Type: text/html; charset=ISO-8859-1'); 
    require_once '../../modelos/mesas/MesaExamen.php';
    
    session_start();
    
    $resultado = $_SESSION['resultado'];
    
    /* Se elimina la variable de sesion */
    session_unset($_SESSION['resultado']);
?>
<html>
	<?php include_once '../estructura/encabezado.php'; ?>
	<script type="text/javascript" src="../../js/mesa_importar.js"></script>
	<section id="main-content">
		<article>
			<div class="content">
            	<h2>BUSCAR MESAS DE EXAMEN</h2>
            	<form action="../../Controladores/ManejadorMesa.php" id="formBuscarMesas" name="formBuscarMesas" method="post">
                	
                	<fieldset>
                		<legend>Resultado de la búsqueda</legend>
                		
                		<h3><?=  $resultado['mensaje']; ?> </h3>
                		<?php  
                		
                		  $mesas = $resultado['datos'];
                		  
                		  if($mesas) {
                		?>
                		     <table id="tablaBuscarMesas" class="display">
                		     	<thead>
                    		     	<tr>
                        		    	<th>Codigo</th>
                            		    <th>Carrera</th>
                            		    <th>Asignatura</th>
                            		    <th>Presidente</th>
                            		    <th>Vocal1</th>
                            		    <th>Vocal2</th>
                            		    <th>Suplente</th>
                            		    <th>1er llamado</th>
                            		    <th>2do llamado</th>
                                        <th>Hora</th>
                                        <th>Lugar</th>
                                 	</tr>
                             	</thead>
                             	<tbody>
                             	<?php  
                             	
                             	 foreach ($mesas as $mesa) {
                             	     
                             	     echo "<tr>";
                             	     echo "<td>".$mesa->getPlan()->getCarrera()->getCodigo()."</td>";
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
                             	     $segundo = "";
                             	     if ($mesa->getSegundo()) {
                             	         $segundo = $mesa->getSegundo()->getFecha();
                             	     }
                             	     echo "<td>".$segundo."</td>";
                             	     echo "<td>campus</td>";
                             	     echo "</tr>";
                             	 }
                             	?>
                             	</tbody>
                             </table>
                		<?php  
                		  }
                		?>
                		
                	</fieldset>
            	</form>
            </div>
		</article>
	</section>
	<?php include_once '../estructura/pie.php'; ?>
</html>

