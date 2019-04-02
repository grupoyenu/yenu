<?php

$controlador = new ControladorPlan();
$rows = $controlador->buscarAsignaturas();

echo '
<div class="container">
    <h4 class="text-center p-4">BUSCAR ASIGNATURAS</h4>';
if (is_null($rows)) {
    echo '<div class="alert alert-danger text-center" role="alert">No se pudo realizar la consulta de asignaturas</div>';
} else {
    if (empty($rows)) {
        echo '<div class="alert alert-warning text-center" role="alert">No se obtuvieron resultados</div>';
    } else {
        echo '
        <table id="tablaBuscarAsignaturas" class="table table-bordered table-hover">
            <thead class="thead-dark">
                <tr>
                    <th>Nombre</th>
                    <th>Cantidad de carreras</th>
                </tr>
            </thead>
            <tbody>';
        foreach ($rows as $asignatura) {
            echo '
                <tr>
                    <td>' . $asignatura['nombre'] . '</td>
                    <td>' . $asignatura['carreras'] . '</td>
                </tr>';
        }
        echo '
            </tbody>
        </table>';
    }
}
echo '</div> 
      <script type="text/javascript" src="./app/js/BuscarAsignatura.js"></script>';