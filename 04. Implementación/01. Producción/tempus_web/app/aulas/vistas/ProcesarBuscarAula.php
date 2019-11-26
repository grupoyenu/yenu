<?php

require_once './app/principal/modelos/Constantes.php';
require_once './app/principal/modelos/AutoCargador.php';

AutoCargador::cargarModulos();
$controlador = new ControladorAula();

if (isset($_POST['btnBuscarAula'])) {
    /* SE COMPLETO EL FORMULARIO Y SE PRESIONO EL BOTON */
    $campo = $_POST['campo'];
    $valor = $_POST['valor'];
    $datos = ($valor) ? $campo . ", '{$valor}'" : $campo . ", TODAS";
    $filtro = "Resultado de la búsqueda: " . $datos;
    $aulas = $controlador->buscar($campo, $valor);
    $_SESSION['BUSAUL'] = array($campo, $valor, $datos);
} else {
    if (isset($_SESSION['BUSAUL'])) {
        /* SE INGRESO AL FORMULARIO Y HAY UNA BUSQUEDA ALMACENADA */
        $parametros = $_SESSION['BUSAUL'];
        $campo = $parametros[0];
        $valor = $parametros[1];
        $filtro = "Última búsqueda realizada: " . $parametros[2];
        $aulas = $controlador->buscar($campo, $valor);
        $_SESSION['BUSAUL'] = NULL;
    } else {
        /* SE INGRESA POR PRIMERA VEZ */
        $aulas = $controlador->listarUltimasCreadas();
        $filtro = "Últimas aulas creadas";
        $_SESSION['BUSAUL'] = NULL;
    }
}
$html = "";
if (gettype($aulas) == "object") {
    $filas = "";
    while ($aula = $aulas->fetch_assoc()) {
        if ($aula['clases'] == 0 && $aula['llamados'] == 0) {
            $operaciones = " <button class='btn btn-outline-danger borrar' 
                                name='{$aula['idaula']}' title='Borrar'><i class='fas fa-trash'></i>
                            </button>";
        } else {
            $operaciones = "<button class='btn btn-outline-info detalle' 
                            name='{$aula['idaula']}' title='Ver detalle'><i class='fas fa-eye'></i>
                        </button>
                        <button class='btn btn-outline-warning editar' 
                                name='{$aula['idaula']}' title='Editar'><i class='far fa-edit'></i>
                        </button>";
        }
        $filas .= "
            <tr>
                <td class='align-middle'>{$aula['sector']}</td>
                <td class='align-middle'>" . utf8_encode($aula['nombre']) . "</td>
                <td class='align-middle'>{$aula['clases']}</td>
                <td class='align-middle'>{$aula['llamados']}</td>   
                <td class='text-center'>
                    <div class='btn-group btn-group-sm'>{$operaciones}</div>
                </td>
            </tr>";
    }
    $html = '
        <div class="table-responsive mt-4">
            <table id="tablaBuscarAulas" class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th title="Nombre del sector">Sector</th>
                        <th title="Nombre del aula">Nombre</th>
                        <th title="Cantidad de clases asociadas">Clases</th>
                        <th title="Cantidad de llamados asociados">Llamados</th>
                        <th title="Operaciones disponibles" class="text-center">Operaciones</th>
                    </tr>
                </thead>
                <tbody>' . $filas . '</tbody>
            </table>
        </div>';
} else {
    $html = ControladorHTML::mostrarAlertaResultadoBusqueda($aulas, $controlador->getDescripcion());
}

echo ControladorHTML::mostrarCardResultadoBusqueda($filtro, $html);
