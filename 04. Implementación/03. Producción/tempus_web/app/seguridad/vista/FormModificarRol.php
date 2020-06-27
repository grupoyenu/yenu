<?php
/* SE INCLUYE EL ARCHIVO DE CONSTANTES Y EL AUTOLOAD */

require_once '../../principal/modelo/Constantes.php';
require_once '../../principal/modelo/AutoCargador.php';

/* SE REFERENCIAN LOS NAMESPACE */

use app\seguridad\modelo\Rol;
use app\seguridad\controlador\ControladorPermiso;
use app\principal\controlador\ControladorHTML;
use app\principal\modelo\AutoCargador;

AutoCargador::cargarModulos();

/* INICIALIZA LA SESION PARA GUARDAR EL LOG */

session_start();

/* INICIO DEL CODIGO PROPIO DEL ARCHIVO */

$cuerpo = $boton = "";
if (isset($_POST['idRol'])) {
    $idRol = $_POST['idRol'];
    $rol = new Rol($idRol);
    $obtener = $rol->obtenerPorIdentificador();
    if ($obtener[0] == 2) {
        $controlador = new ControladorPermiso();
        $resultado = $controlador->listarPermisos();
        if ($resultado[0] == 2) {
            $permisos = $resultado[1];
            $arreglo = array_column($rol->getPermisos(), 'id');
            $filas = "";
            foreach ($permisos as $permiso) {
                $check = (array_search($permiso['id'], $arreglo) !== false) ? "checked" : "";
                $filas .= "
                    <tr>
                        <td class='text-center align-middle'>
                            <input type='checkbox' name='permisos[]' id='permisos' 
                                   {$check} value='{$permiso['id']}'>
                        </td>
                        <td>" . utf8_encode($permiso['nombre']) . "</td>
                    </tr>";
            }
            $cuerpo = '
                <input type="hidden" name="idRol" id="idRol" value="' . $rol->getId() . '">
                <div class="form-row">
                    <label for="nombre" class="col-sm-2 col-form-label"
                           title="Campo obligatorio">* Nombre:</label>
                    <div class="col">
                        <input type="text" class="form-control mb-2" 
                               name="nombre" id="nombre"
                               minlength="5"  maxlength="30" pattern="[A-Za-z ]{5,30}"
                               title="Escriba el nombre del rol a crear. Longitud mínima: 5. Longitud máxima: 30"
                               value="' . $rol->getNombre() . '"
                               placeholder="Nombre del rol" required>
                    </div>
                </div>
                <div class="form-row">
                    <label for="rol" class="col-sm-2 col-form-label"
                           title="Campo obligatorio">* Permisos:</label>
                    <div class="col">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover" border="1">
                                <thead>
                                    <tr>
                                        <th class="text-center align-middle" title="Seleccionador de permiso">
                                            <input type="checkbox" name="cbTodosPermisos" id="cbTodosPermisos"
                                                   title="Seleccionar todos los permisos">
                                        </th>
                                        <th title="Nombre del permiso">Nombre</th>
                                    </tr>
                                </thead>
                                <tbody>' . $filas . '</tbody>
                            </table>
                        </div>
                    </div>
                </div>';
            $boton = '
                <button type="submit" class="btn btn-success" 
                        id="btnModificarRol" title="Guardar datos" disabled>
                        <i class="far fa-save"></i> GUARDAR
                </button>';
        } else {
            $codigo = $resultado[0];
            $mensaje = $resultado[1];
            $cuerpo = ControladorHTML::mostrarAlertaResultadoOperacion($codigo, $mensaje);
        }
    } else {
        $codigo = $obtener[0];
        $mensaje = $obtener[1];
        $cuerpo = ControladorHTML::mostrarAlertaResultadoOperacion($codigo, $mensaje);
    }
} else {
    $mensaje = "No se obtuvo la información desde el formulario";
    $cuerpo = ControladorHTML::mostrarAlertaResultadoOperacion(0, $mensaje);
}
?>
<div class="container">
    <div class="form-row mt-4 mb-4">
        <div class="col text-left">
            <h4><i class="fas fa-user-friends"></i> MODIFICAR ROL</h4>
        </div>
        <div class="col text-right">
            <a href="../../principal/vista/home.php">
                <button class="btn btn-sm btn-outline-secondary"> 
                    <i class="fas fa-times"></i> CERRAR
                </button>
            </a>
        </div>
    </div>
    <div id="seccionResultado"></div>
    <div id="seccionFormulario">
        <form id="formModificarRol" name="formModificarRol" method="POST">
            <div class="card border-dark">
                <div class="card-header bg-dark text-white"
                     title="Formulario de modificación">Modifique la información y presione GUARDAR</div>
                <div class="card-body"><?= $cuerpo; ?></div>
            </div>
            <div class="form-row mt-2 mb-4">
                <div class="col text-right">
                    <?= $boton; ?>
                    <a href="FormBuscarRol.php" title="Ir al formulario de búsqueda">
                        <button type="button" class="btn btn-outline-info">
                            <i class="fas fa-search"></i> BUSCAR
                        </button>
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>

<script type="text/javascript" src="../js/ModificarRol.js"></script>


