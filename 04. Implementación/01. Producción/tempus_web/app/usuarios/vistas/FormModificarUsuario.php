<?php
require_once '../../principal/modelos/Constantes.php';
require_once '../../principal/modelos/AutoCargador.php';

AutoCargador::cargarModulos();

$boton = "";
if (isset($_POST['idUsuario']) && isset($_POST['metodo'])) {
    $idUsuario = $_POST['idUsuario'];
    $metodo = $_POST['metodo'];
    $usuario = ($metodo == "Manual") ? new UsuarioManual($idUsuario) : new Usuario($idUsuario);
    $obtener = $usuario->obtener();
    if ($obtener == 2) {
        $controlador = new ControladorRoles();
        $roles = $controlador->listar();
        if (gettype($roles) == "object") {
            $estado = $usuario->getEstado();
            $filas = "";
            while ($rol = $roles->fetch_assoc()) {
                $selected = ($usuario->getRol() == $rol['idrol']) ? "selected" : "";
                $filas .= "<option value='{$rol['idrol']}' {$selected}>" . utf8_encode($rol['nombre']) . "</td></option>";
            }

            $opcionesEstado = ($estado == "Activo") ? '<option value="Activo" selected>Activo</option>' : '<option value="Activo">Activo</option>';
            $opcionesEstado .= ($estado == "Inactivo") ? '<option value="Inactivo" selected>Inactivo</option>' : '<option value="Inactivo">Inactivo</option>';

            $cuerpo = '
                <input type="hidden" name="idUsuario" id="idUsuario" value="' . $usuario->getIdUsuario() . '">
                <input type="hidden" name="metodo" id="metodo" value="' . $metodo . '">
                <div class="form-row">
                    <label for="nombre" class="col-sm-2 col-form-label">* Nombre:</label>
                    <div class="col">
                        <input type="text" class="form-control mb-2" 
                               name="nombre" id="nombre"
                               value="' . $usuario->getNombre() . '"
                               placeholder="Nombre del usuario" required>
                    </div>
                    <label for="correo" class="col-sm-2 col-form-label">* E-mail:</label>
                    <div class="col">
                        <input type="text" class="form-control mb-2" 
                               name="correo" id="correo"
                               value="' . $usuario->getEmail() . '"
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
                        <select class="form-control mb-2" id="estado" name="estado">' . $opcionesEstado . '</select>
                    </div>
                </div>';
            if ($metodo == "Manual") {
                $cuerpo .= '
                    <div class="form-row">
                        <label for="clave" class="col-sm-2 col-form-label">* Clave:</label>
                        <div class="col">
                            <input type="password" class="form-control mb-2" 
                                   name="clave" id="clave"
                                   value="' . $usuario->getClave() . '"
                                   placeholder="Clave" required>
                        </div>
                        <label class="col-sm-2 col-form-label"></label>
                        <div class="col"></div>
                    </div>';
            }
            $boton = '<button type="submit" class="btn btn-success" 
                            id="btnModificarUsuario" title="Guardar datos" disabled>
                        <i class="far fa-save"></i> GUARDAR
                  </button>';
        } else {
            $cuerpo = ControladorHTML::mostrarAlertaResultadoOperacion($roles, $controlador->getDescripcion());
        }
    } else {
        $cuerpo = ControladorHTML::mostrarAlertaResultadoOperacion($obtener, $usuario->getDescripcion());
    }
} else {
    $mensaje = "No se obtuvo la información desde el formulario";
    $cuerpo = ControladorHTML::mostrarAlertaResultadoOperacion(0, $mensaje);
}
?>
<div class="container">
    <div class="form-row mt-4 mb-4">
        <div class="col text-left"><h4><i class="fas fa-user-alt"></i> MODIFICAR USUARIO</h4></div>
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
        <form id="formModificarUsuario" name="formModificarUsuario" method="POST">
            <div class="card border-dark">
                <div class="card-header bg-dark text-white">Modifique el formulario y presione GUARDAR</div>
                <div class="card-body"><?= $cuerpo; ?></div>
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
<script type="text/javascript" src="./app/usuarios/js/ModificarUsuario.js"></script>

