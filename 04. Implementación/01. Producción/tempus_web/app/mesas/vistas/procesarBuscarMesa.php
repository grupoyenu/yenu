<?php

require_once './app/principal/modelos/Constantes.php';
require_once './app/principal/modelos/AutoCargador.php';

AutoCargador::cargarModulos();

$controlador = new ControladorMesa();

if (isset($_POST['btnBuscarMesa'])) {
    /* SE COMPLETO EL FORMULARIO Y SE PRESIONO EL BOTON */
    $campo = $_POST['campo'];
    $valor = $_POST['valor'];
    $datos = ($campo == "nombreCarrera") ? "Carrera" : "Asignatura";
    $datos .= ($valor) ? ", '{$valor}'" : ", TODAS";
    $filtro = "Resultado de la búsqueda: " . $datos;
    $mesas = $controlador->buscar($campo, $valor);
    $_SESSION['BUSMES'] = array($campo, $valor, $datos);
} else {
    if (isset($_SESSION['BUSMES'])) {
        /* SE INGRESO AL FORMULARIO Y HAY UNA BUSQUEDA ALMACENADA */
        $parametros = $_SESSION['BUSMES'];
        $campo = $parametros[0];
        $valor = $parametros[1];
        $filtro = "Última búsqueda realizada: " . $parametros[2];
        $mesas = $controlador->buscar($campo, $valor);
        $_SESSION['BUSMES'] = NULL;
    } else {
        /* SE INGRESA POR PRIMERA VEZ */
        $mesas = $controlador->listarUltimasCreadas();
        $filtro = "Últimas mesas de examen creadas";
        $_SESSION['BUSMES'] = NULL;
    }
}

$html = "";
if (gettype($mesas) == "object") {
    $filas = "";
    while ($mesa = $mesas->fetch_assoc()) {
        $filas .= "
            <tr>
                <td class='align-middle'>{$mesa['nombreCarrera']}</td>
                <td class='align-middle'>{$mesa['nombreAsignatura']}</td>
                <td class='align-middle'>{$mesa['nombrePresidente']}</td>
                <td class='align-middle'>{$mesa['nombreVocalPri']}</td>
                <td class='align-middle'>{$mesa['nombreVocalSeg']}</td>
                <td class='align-middle'>{$mesa['nombreSuplente']}</td>
                <td class='text-center'>
                    <div class='btn-group btn-group-sm'>
                        <button class='btn btn-outline-info detalle' 
                            name='{$mesa['idmesa']}' title='Ver detalle'><i class='fas fa-eye'></i>
                        </button>
                        <button class='btn btn-outline-warning editar' 
                                name='{$mesa['idmesa']}' title='Editar'><i class='far fa-edit'></i>
                        </button>
                        <button class='btn btn-outline-danger baja' 
                                name='{$mesa['idmesa']}' title='Dar de baja'><i class='fas fa-trash'></i>
                        </button>
                    </div>
                </td>
            </tr>";
    }
    $html = '
        <div class="table-responsive mt-4">
            <table id="tablaBuscarMesas" class="table table-bordered table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th>Carrera</th>
                        <th>Asignatura</th>
                        <th>Presidente</th>
                        <th>Vocal 1</th>
                        <th>Vocal 2</th>
                        <th>Suplente</th>
                        <th class="text-center">Operaciones</th>
                    </tr>
                </thead>
                <tbody>' . $filas . '</tbody>
            </table>
        </div>';
} else {
    $html = ControladorHTML::mostrarAlertaResultadoBusqueda($mesas, $controlador->getDescripcion());
}

echo ControladorHTML::mostrarCardResultadoBusqueda($filtro, $html);
