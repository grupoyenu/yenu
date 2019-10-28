<?php

require_once './app/principal/modelos/Constantes.php';
require_once './app/principal/modelos/AutoCargador.php';

AutoCargador::cargarModulos();

$controlador = new ControladorCarreras();

if (isset($_POST['btnBuscarCarrera'])) {
    /* SE COMPLETO EL FORMULARIO Y SE PRESIONO EL BOTON */
    $nombre = $_POST['nombre'];
    $datos = ($nombre) ? "'{$nombre}'" : "TODAS";
    $filtro = "Resultado de la búsqueda: " . $datos;
    $carreras = $controlador->buscar($nombre);
    $_SESSION['BUSCAR'] = array($nombre, $datos);
} else {
    if (isset($_SESSION['BUSCAR'])) {
        /* SE INGRESO AL FORMULARIO Y HAY UNA BUSQUEDA ALMACENADA */
        $parametros = $_SESSION['BUSCAR'];
        $nombre = $parametros[0];
        $filtro = "Última búsqueda realizada: " . $parametros[1];
        $carreras = $controlador->buscar($nombre);
        $_SESSION['BUSCAR'] = NULL;
    } else {
        /* SE INGRESA POR PRIMERA VEZ */
        $carreras = $controlador->listarUltimasCreadas();
        $filtro = "Últimas carreras creadas";
        $_SESSION['BUSCAR'] = NULL;
    }
}
$html = "";
if (gettype($carreras) == "object") {
    $filas = "";
    while ($carrera = $carreras->fetch_assoc()) {
        $filas .= " 
            <tr> 
                <td class='align-middle'>" . str_pad($carrera['codigo'], 3, "0", STR_PAD_LEFT) . "</td> 
                <td class='align-middle'>" . utf8_encode($carrera['nombre']) . "</td> 
                <td class='align-middle'>{$carrera['cantidad']}</td>
                <td class='text-center'>
                    <div class='btn-group btn-group-sm'>
                        <button class='btn btn-outline-info detalle' 
                            name='{$carrera['codigo']}' title='Ver detalle'><i class='fas fa-eye'></i>
                        </button>
                        <button class='btn btn-outline-success agregar' 
                            name='{$carrera['codigo']}' title='Agregar a carrera'><i class='fas fa-plus-circle'></i>
                        </button>
                    </div>
                </td>   
            </tr>";
    }
    $html = '
        <div class="table-responsive">
            <table id="tablaBuscarCarreras" class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>Código</th>
                        <th>Nombre</th>
                        <th>Asignaturas</th>
                        <th class="text-center">Operaciones</th>
                    </tr>
                </thead>
                <tbody>' . $filas . '</tbody>
            </table>
        </div>';
} else {
    $html = ControladorHTML::mostrarAlertaResultadoBusqueda($carreras, $controlador->getDescripcion());
}

echo ControladorHTML::mostrarCardResultadoBusqueda($filtro, $html);
