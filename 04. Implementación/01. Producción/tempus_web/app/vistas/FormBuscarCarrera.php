<?php

$controlador = new ControladorPlan();
$rows = $controlador->buscarCarreras();

echo '
<div class="container">
    <h4 class="text-center p-4">BUSCAR CARRERAS</h4>';
if (is_null($rows)) {
    echo '<div class="alert alert-danger text-center" role="alert">No se pudo realizar la consulta de carreras</div>';
} else {
    if (empty($rows)) {
        echo '<div class="alert alert-warning text-center" role="alert">No se obtuvieron resultados</div>';
    } else {
        echo '
        <table id="tablaBuscarCarreras" class="table table-bordered table-hover">
            <thead class="thead-dark">
                <tr>
                    <th>Código</th>
                    <th>Nombre</th>
                    <th>Cantidad de asignaturas</th>
                </tr>
            </thead>
            <tbody>';
        foreach ($rows as $carrera) {
            echo '
                <tr>
                    <td>' . $carrera['codigo'] . '</td>
                    <td>' . $carrera['nombre'] . '</td>
                    <td></td>
                </tr>';
        }
        echo '
            </tbody>
        </table>';
    }
}
echo '</div> 
      <script type="text/javascript" src="./app/js/BuscarCarrera.js"></script>';