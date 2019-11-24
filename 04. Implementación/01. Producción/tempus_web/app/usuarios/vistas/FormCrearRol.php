<?php
require_once './app/principal/modelos/Constantes.php';
require_once './app/principal/modelos/AutoCargador.php';

AutoCargador::cargarModulos();

$controlador = new ControladorPermisos();
$permisos = $controlador->listar();
$boton = "";
if (gettype($permisos) == "object") {
    $filas = "";
    while ($permiso = $permisos->fetch_assoc()) {
        $filas .= "
            <tr>
                <td class='text-center align-middle'><input type='checkbox' name='permisos[]' id='permisos' value='{$permiso['idpermiso']}'></td>
                <td>" . utf8_encode($permiso['nombre']) . "</td>
            </tr>";
    }
    $cuerpo = '
        <div class="form-row">
            <label for="nombre" class="col-sm-2 col-form-label">* Nombre:</label>
            <div class="col">
                <input type="text" class="form-control mb-2" 
                       name="nombre" id="nombre" maxlength="30" minlength="5" pattern="[A-Za-z ]{5,30}"
                       title="Nombre: Acepta caracteres alfabéticos con una longitud minima de 5 y máxima de 30"
                       placeholder="Nombre del rol" required>
            </div>
        </div>
        <div class="form-row">
            <label for="rol" class="col-sm-2 col-form-label">* Permisos:</label>
            <div class="col">
                <table class="table table-bordered table-hover" border="1">
                    <thead>
                        <tr>
                            <th class="text-center align-middle">
                                <input type="checkbox" name="cbTodosPermisos" id="cbTodosPermisos"
                                       title="Seleccionar todos los permisos">
                            </th>
                            <th>Nombre</th>
                        </tr>
                    </thead>
                    <tbody>' . $filas . '</tbody>
                </table>
            </div>
        </div>';
    $boton = ' <button type="submit" class="btn btn-success" 
                    id="btnCrearPermiso" title="Guardar datos">
                <i class="far fa-save"></i> GUARDAR
            </button>';
} else {
    $cuerpo = ControladorHTML::mostrarAlertaResultadoOperacion($permisos, $controlador->getDescripcion());
}
?>
<div class="container-fluid" id="contenido">
    <div class="container">
        <div class="form-row mt-4 mb-4">
            <div class="col text-left"><h4><i class="fas fa-user-friends"></i> CREAR ROL</h4></div>
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
            <form id="formCrearRol" name="formCrearRol" method="POST">
                <div class="card border-dark">
                    <div class="card-header bg-dark text-white">Complete el formulario y presione GUARDAR</div>
                    <div class="card-body"> <?= $cuerpo; ?> </div>
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
</div>
<script type="text/javascript" src="./app/usuarios/js/CrearRol.js"></script>