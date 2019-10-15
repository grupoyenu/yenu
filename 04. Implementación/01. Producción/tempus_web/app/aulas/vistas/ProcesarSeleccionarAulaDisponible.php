<?php

require_once '../../principal/modelos/Constantes.php';
require_once '../../principal/modelos/AutoCargador.php';

AutoCargador::cargarModulos();

$html = "";
if (isset($_POST['dia']) && isset($_POST['desde']) && isset($_POST['hasta'])) {
    $controlador = new ControladorAula();
    $aulas = $controlador->listarAulasDisponibles($_POST['dia'], $_POST['desde'], $_POST['hasta']);
    if (gettype($aulas) == "object") {
        $filas = "";
        while ($aula = $aulas->fetch_assoc()) {
            $filas .= "
            <tr>
                <td class='align-middle text-center'>
                    <button class='btn btn-sm btn-outline-success elegirAula' 
                            name='{$aula['idaula']}' value='{$_POST['dia']}' 
                            title='Seleccionar'><i class='far fa-check-square'></i>
                    </button>
                </td>
                <td class='align-middle'>" . utf8_encode($aula['sector']) . "</td> 
                <td class='align-middle'>" . utf8_encode($aula['nombre']) . "</td> 
            </tr>";
        }
        $html = '
        <div class="table-responsive">
            <table id="tablaSeleccionarAula" class="table table-bordered table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th></th>
                        <th>Sector</th>
                        <th>Nombre</th>
                    </tr>
                </thead>
                <tbody>' . $filas . '</tbody>
            </table>
        </div>';
    } else {
        $html = ControladorHTML::mostrarAlertaResultadoBusqueda($aulas, $controlador->getDescripcion());
    }
} else {
    $html = '<div class="alert alert-danger text-center" role="alert"> 
                    <i class="fas fa-exclamation-triangle"></i> 
                    <strong>No se obtuvo la información desde el formulario</strong>
                </div>';
}

echo $html;


