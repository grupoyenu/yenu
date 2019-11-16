<?php
require_once '../../principal/modelos/Constantes.php';
require_once '../../principal/modelos/AutoCargador.php';

AutoCargador::cargarModulos();

$cuerpo = $boton = "";
if (isset($_POST['idRol'])) {
    $idRol = $_POST['idRol'];
    $rol = new Rol($idRol);
    $obtener = $rol->obtener();
    if ($obtener == 2) {
        $controlador = new ControladorPermisos();
        $permisos = $controlador->listar();
        if (gettype($permisos) == "object") {
            $arreglo = array_column(mysqli_fetch_all($rol->getPermisos(), MYSQLI_ASSOC), 'idpermiso');
            $filas = "";
            while ($permiso = $permisos->fetch_assoc()) {
                $check = (array_search($permiso['idpermiso'], $arreglo)) ? "checked" : "";
                $filas .= "
                    <tr>
                        <td class='text-center align-middle'>
                            <input type='checkbox' name='permisos[]' id='permisos' {$check} value='{$permiso['idpermiso']}'>
                        </td>
                        <td>" . utf8_encode($permiso['nombre']) . " {$check}</td>
                    </tr>";
            }
            $cuerpo = '
                <input type="hidden" name="idRol" id="idRol" value="' . $rol->getIdRol() . '">
                <div class="form-row">
                    <label for="nombre" class="col-sm-2 col-form-label">* Nombre:</label>
                    <div class="col">
                        <input type="text" class="form-control mb-2" 
                               name="nombre" id="nombre"
                               value="' . $rol->getNombre() . '"
                               placeholder="Nombre del rol" required>
                    </div>
                </div>
                <div class="form-row">
                    <label for="rol" class="col-sm-2 col-form-label">* Permisos:</label>
                    <div class="col">
                        <table class="table table-bordered table-hover" border="1">
                            <thead>
                                <tr>
                                    <th class="text-center align-middle"><input type="checkbox" name="cbTodosPermisos" id="cbTodosPermisos"></th>
                                    <th>Nombre</th>
                                </tr>
                            </thead>
                            <tbody>' . $filas . '</tbody>
                        </table>
                    </div>
                </div>';
            $boton = '<button type="submit" class="btn btn-success" 
                            id="btnModificarRol" title="Guardar datos" disabled>
                        <i class="far fa-save"></i> GUARDAR
                  </button>';
        } else {
            $cuerpo = ControladorHTML::mostrarAlertaResultadoOperacion($permisos, $controlador->getDescripcion());
        }
    } else {
        $cuerpo = ControladorHTML::mostrarAlertaResultadoOperacion($obtener, $rol->getDescripcion());
    }
} else {
    $mensaje = "No se obtuvo la información desde el formulario";
    $cuerpo = ControladorHTML::mostrarAlertaResultadoOperacion(0, $mensaje);
}
?>
<div class="container">
    <div class="form-row mt-4 mb-4">
        <div class="col text-left"><h4><i class="fas fa-user-friends"></i> MODIFICAR ROL</h4></div>
        <div class="col text-right">
            <a href="principal_home">
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
                <div class="card-header bg-dark text-white">Modifique el formulario y presione GUARDAR</div>
                <div class="card-body"><?= $cuerpo; ?></div>
            </div>
            <div class="form-row mt-2 mb-4">
                <div class="col text-right">
                    <?= $boton; ?>
                    <a href="usuario_buscarRol">
                        <button type="button" class="btn btn-outline-info">
                            <i class="fas fa-search"></i> BUSCAR
                        </button>
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>

<script type="text/javascript" src="./app/usuarios/js/ModificarRol.js"></script>


