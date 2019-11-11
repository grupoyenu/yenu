<?php

require_once './app/principal/modelos/Constantes.php';
require_once './app/principal/modelos/AutoCargador.php';

AutoCargador::cargarModulos();
$controlador = new ControladorAsignaturas();

if (isset($_POST['btnBuscarAsignatura'])) {
    /* SE COMPLETO EL FORMULARIO Y SE PRESIONO EL BOTON */
    $nombre = $_POST['nombre'];
    $datos = ($nombre) ? "'{$nombre}'" : "TODAS";
    $filtro = "Resultado de la búsqueda: " . $datos;
    $asignaturas = $controlador->buscarPorNombre($nombre);
    $_SESSION['BUSASI'] = array($nombre, $datos);
} else {
    if (isset($_SESSION['BUSASI'])) {
        /* SE INGRESO AL FORMULARIO Y HAY UNA BUSQUEDA ALMACENADA */
        $parametros = $_SESSION['BUSASI'];
        $nombre = $parametros[0];
        $filtro = "Última búsqueda realizada: " . $parametros[1];
        $asignaturas = $controlador->buscarPorNombre($nombre);
        $_SESSION['BUSASI'] = NULL;
    } else {
        /* SE INGRESA POR PRIMERA VEZ */
        $asignaturas = $controlador->listarUltimasCreadas();
        $filtro = "Últimas asignaturas creadas";
        $_SESSION['BUSASI'] = NULL;
    }
}
$html = "";
if (gettype($asignaturas) == "object") {
    $filas = "";
    while ($asignatura = $asignaturas->fetch_assoc()) {
        $filas .= "
            <tr>
                <td class='align-middle'>" . utf8_encode($asignatura['nombre']) . "</td> 
                <td class='align-middle'>{$asignatura['cantidad']}</td> 
                <td class='text-center'>
                    <div class='btn-group btn-group-sm'>
                        <button class='btn btn-outline-info detalle' 
                            name='{$asignatura['idasignatura']}' title='Ver detalle'><i class='fas fa-eye'></i>
                        </button>
                    </div>
                </td> 
            </tr>";
    }
    $html = '
        <div class="table-responsive">
            <table id="tablaBuscarAsignaturas" class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Carreras</th>
                        <th class="text-center">Operaciones</th>
                    </tr>
                </thead>
                <tbody>' . $filas . '</tbody>
            </table>
        </div>';
} else {
    $html = ControladorHTML::mostrarAlertaResultadoBusqueda($asignaturas, $controlador->getDescripcion());
}

echo ControladorHTML::mostrarCardResultadoBusqueda($filtro, $html);
