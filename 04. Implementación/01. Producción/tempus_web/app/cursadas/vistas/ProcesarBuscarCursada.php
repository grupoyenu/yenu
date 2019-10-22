<?php

require_once './app/principal/modelos/Constantes.php';
require_once './app/principal/modelos/AutoCargador.php';

AutoCargador::cargarModulos();

$controlador = new ControladorCursada();

if (isset($_POST['btnBuscarCursada'])) {
    /* SE COMPLETO EL FORMULARIO Y SE PRESIONO EL BOTON */
    $campo = $_POST['campo'];
    $valor = $_POST['valor'];
    $datos = ($campo == "nombreCarrera") ? "Carrera" : "Asignatura";
    $datos .= ($valor) ? ", '{$valor}'" : ", TODAS";
    $filtro = "Resultado de la búsqueda: " . $datos;
    $cursadas = $controlador->buscar($campo, $valor);
    $_SESSION['BUSCUR'] = array($campo, $valor, $datos);
} else {
    if (isset($_SESSION['BUSCUR'])) {
        /* SE INGRESO AL FORMULARIO Y HAY UNA BUSQUEDA ALMACENADA */
        $parametros = $_SESSION['BUSCUR'];
        $campo = $parametros[0];
        $valor = $parametros[1];
        $filtro = "Última búsqueda realizada: " . $parametros[2];
        $cursadas = $controlador->buscar($campo, $valor);
        $_SESSION['BUSCUR'] = NULL;
    } else {
        /* SE INGRESA POR PRIMERA VEZ */
        $cursadas = $controlador->listarUltimasCreadas();
        $filtro = "Últimas mesas de examen creadas";
        $_SESSION['BUSCUR'] = NULL;
    }
}

$html = "";
if (gettype($cursadas) == "object") {
    $filas = "";
    while ($cursada = $cursadas->fetch_assoc()) {
        $lunes = ($cursada['idClase1']) ? $cursada['desde1'] . " " . $cursada['hasta1'] . " " . $cursada['sector1'] . " " . $cursada['aula1'] : "";
        $martes = ($cursada['idClase2']) ? $cursada['desde2'] . " " . $cursada['hasta2'] . " " . $cursada['sector2'] . " " . $cursada['aula2'] : "";
        $miercoles = ($cursada['idClase3']) ? $cursada['desde3'] . " " . $cursada['hasta3'] . " " . $cursada['sector3'] . " " . $cursada['aula3'] : "";
        $jueves = ($cursada['idClase4']) ? $cursada['desde4'] . " " . $cursada['hasta4'] . " " . $cursada['sector4'] . " " . $cursada['aula4'] : "";
        $viernes = ($cursada['idClase5']) ? $cursada['desde5'] . " " . $cursada['hasta5'] . " " . $cursada['sector5'] . " " . $cursada['aula5'] : "";
        $sabado = ($cursada['idClase6']) ? $cursada['desde6'] . " " . $cursada['hasta6'] . " " . $cursada['sector6'] . " " . $cursada['aula6'] : "";
        $filas .= "
            <tr>
                <td style='display: none;' class='align-middle'>{$cursada['idCarrera']}</td>
                <td class='align-middle'>" . utf8_encode($cursada['nombreCarrera']) . "</td>
                <td class='align-middle'>" . utf8_encode($cursada['nombreAsignatura']) . "</td>
                <td class='align-middle'>{$lunes}</td>
                <td class='align-middle'>{$martes}</td>
                <td class='align-middle'>{$miercoles}</td>
                <td class='align-middle'>{$jueves}</td>
                <td class='align-middle'>{$viernes}</td>
                <td style='display: none;' class='align-middle'>{$sabado}</td>
                <td class='text-center'>
                    <div class='btn-group btn-group-sm'>
                        <button class='btn btn-outline-info detalle' 
                            name='' title='Ver detalle'><i class='fas fa-eye'></i>
                        </button>
                        <button class='btn btn-outline-warning editar' 
                                name='{$cursada['idCarrera']}' id='{$cursada['idAsignatura']}' title='Editar'><i class='far fa-edit'></i>
                        </button>
                        <button class='btn btn-outline-danger baja' 
                                name='' title='Dar de baja'><i class='fas fa-trash'></i>
                        </button>
                    </div>
                </td>
            </tr>";
    }
    $html = '
        <div class="table-responsive mt-4">
            <table id="tablaBuscarCursadas" class="table table-bordered table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th style="display: none;">Código carrera</th>
                        <th>Nombre carrera</th>
                        <th>Asignatura</th>
                        <th>Lunes</th>
                        <th>Martes</th>
                        <th>Miercoles</th>
                        <th>Jueves</th>
                        <th>Viernes</th>
                        <th style="display: none;">Sábado</th>
                        <th class="text-center">Operaciones</th>
                    </tr>
                </thead>
                <tbody>' . $filas . '</tbody>
            </table>
        </div>';
} else {
    $html = ControladorHTML::mostrarAlertaResultadoBusqueda($cursadas, $controlador->getDescripcion());
}

echo ControladorHTML::mostrarCardResultadoBusqueda($filtro, $html);
