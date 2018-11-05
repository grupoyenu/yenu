<?php

header('Content-Type: text/html; charset=ISO-8859-1');
include_once '../../lib/conf/ControlAcceso.php';
include_once '../../lib/conf/PermisosSistema.php';
require_once '../../modelos/carreras/Plan.php';
require_once '../../modelos/mesas/Tribunal.php';
require_once '../../modelos/mesas/Llamado.php';
require_once '../../modelos/mesas/MesaExamen.php';
require_once '../../modelos/mesas/Mesas.php';
$mesas = new Mesas();
$mesas->obtenerMesasDeHoy();

?>
<html>
<?php include_once '../estructura/encabezado.php'; ?>
<script type='text/javascript' src='../../js/aula_buscar.js'></script>
<section id='main-content'>
<article>
<div id='content' class='content'>
<h2>ASIGNAR AULA</h2>
<form action='' id='' name='' method='post'>
	<fieldset>
	<legend>Mesas de examen sin asignar aula</legend>
	<table>
	<thead>
    <tr><th>Carrera<th><th>Asignatura<th><th>Asignar<th></tr>
    </thead>
    <tbody></tbody>
    </table>
	</fieldset>
	<fieldset>
	<legend>Mesas de examen con aula asignada</legend>
	</fieldset>
    <?php 
    
    ?>
</form>
</div>
</article>
</section>
<?php include_once '../estructura/pie.php'; ?>
</html>