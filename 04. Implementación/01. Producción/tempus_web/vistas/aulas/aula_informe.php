<?php
include_once '../../modelos/aulas/Aula.php';
include_once '../../modelos/aulas/Aulas.php';
include_once '../../lib/conf/ControlAcceso.php';
include_once '../../lib/conf/ObjetoDatos.php';

?>
<html>
<?php include_once '../estructura/encabezado.php'; ?>
<script type='text/javascript' src='../../js/aula_informe.js'></script>
<section id='main-content'>
<article>
<div id='content' class='content'>
<h2>INFORME DE AULA</h2>
<form>
	<fieldset>
	<?php
	$informe = $_SESSION['aulaInformeResultado']; // Resultado enviado por el manejador aula
	if($informe['resultado']) {
	    $horarios = $informe['datos'];
	    $aula = new Aula();
	    $aula = $horarios[0]; // Recupera el objeto aula
	    echo "<legend>{$aula->getSector()} - {$aula->getNombre()}</legend>";
	    /* Se determina que dia tiene mas clases para armar la tabla */
	    $mayor = 0;
	    for($i=1 ; $i<6; $i++) {
	        if($horarios[$i]) {
	            $actual = count($horarios[$i]);
	            if($actual > $mayor) {
	                $mayor = $actual;
	            }
	        }
	    }
	    echo "<table id='tablaInformeAula'>
        <thead>
        <tr> <th>Lunes</th> <th>Martes</th> <th>Miercoles</th> <th>Jueves</th> <th>Viernes</th> </tr>
        </thead>
        <tbody>";
	    for($fila=0 ; $fila<$mayor; $fila++) {
	        echo "<tr>";
	        for($dia=1 ; $dia<6; $dia++) {
	            if($horarios[$dia] && isset($horarios[$dia][$fila])) {
	                echo "<td> {$horarios[$dia][$fila]['nombre']}  {$horarios[$dia][$fila]['inicio']} {$horarios[$dia][$fila]['fin']}</td>";
	            } else {
	                echo "<td></td>";
	            }
	        }
	        echo "</tr>";
	    }
	    echo "</tbody>
	    </table>";
	    
	} else {
	    /* No hay resultado. Debe haber mensaje para mostrar*/
	}
    ?>
    </fieldset>
</form>
</div>
</article>
</section>
<?php include_once '../estructura/pie.php'; ?>
</html>