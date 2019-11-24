<?php
require_once './app/principal/modelos/Constantes.php';
require_once './app/principal/modelos/AutoCargador.php';

AutoCargador::cargarModulos();

$controlador = new ControladorRoles();
$roles = $controlador->listar();
$boton = "";
if (gettype($roles) == "object") {
    $filas = "";
    while ($rol = $roles->fetch_assoc()) {
        $filas .= "<option value='{$rol['idrol']}'>" . utf8_encode($rol['nombre']) . "</td></option>";
    }
    $cuerpo = '
        <div class="form-row">
            <label for="nombre" class="col-sm-2 col-form-label">* Nombre completo:</label>
            <div class="col">
                <input type="text" class="form-control mb-2" 
                       name="nombre" id="nombre" maxlength="50" minlength="8" pattern="[A-Za-zÁÉÍÓÚÑáéíóúñ ]{8, 50}"
                       title="Nombre: Acepta caracteres alfabéticos con una longitud minima de 8 y máxima de 50"
                       placeholder="Nombre del usuario" required>
            </div>
            <label for="correo" class="col-sm-2 col-form-label">* E-mail:</label>
            <div class="col">
                <input type="text" class="form-control mb-2" 
                       name="correo" id="correo" maxlength="35" minlength="12" 
                       placeholder="E-mail" required>
            </div>
        </div>
        <div class="form-row">
            <label for="rol" class="col-sm-2 col-form-label">* Rol:</label>
            <div class="col">
                <select class="form-control mb-2" id="rol" name="rol">' . $filas . '</select>
            </div>
            <label for="estado" class="col-sm-2 col-form-label">* Estado:</label>
            <div class="col">
                <select class="form-control mb-2" id="estado" name="estado">
                    <option value="Activo">Activo</option>
                    <option value="Inactivo">Inactivo</option>
                </select>
            </div>
        </div>
        <div class="form-row">
            <label for="metodo" class="col-sm-2 col-form-label">* Método:</label>
            <div class="col">
                <select class="form-control mb-2" id="metodo" name="metodo">
                    <option value="Google">Google</option>
                    <option value="Manual">Manual</option>
                </select>
            </div>
            <label for="clave" class="col-sm-2 col-form-label">* Clave:</label>
            <div class="col">
                <input type="password" class="form-control mb-2" 
                       name="clave" id="clave" maxlength="12" minlength="8" pattern="[A-Za-zÁÉÍÓÚÑáéíóúñ0-9 ]"
                       title="Clave: Acepta caracteres alfanúmericos con una longitud minima de 8 y máxima de 12"
                       placeholder="Clave" disabled required>
            </div>
        </div>';
    $boton = '
        <button type="submit" class="btn btn-success" 
                id="btnCrearPermiso" title="Guardar datos">
            <i class="far fa-save"></i> GUARDAR
        </button>';
} else {
    $cuerpo = ControladorHTML::mostrarAlertaResultadoOperacion($roles, $controlador->getDescripcion());
}
?>
<div class="container-fluid" id="contenido">
    <div class="container">
        <div class="form-row mt-4 mb-4">
            <div class="col text-left"><h4><i class="fas fa-user-alt"></i> CREAR USUARIO</h4></div>
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
            <form id="formCrearUsuario" name="formCrearUsuario" method="POST">
                <div class="card border-dark">
                    <div class="card-header bg-dark text-white">Complete el formulario y presione GUARDAR</div>
                    <div class="card-body"> <?= $cuerpo; ?> </div>
                </div>
                <div class="form-row mt-2 mb-4">
                    <div class="col text-right"> 
                        <?= $boton; ?> 
                        <a href="usuario_buscarUsuario">
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
<script type="text/javascript" src="./app/usuarios/js/CrearUsuario.js"></script>
