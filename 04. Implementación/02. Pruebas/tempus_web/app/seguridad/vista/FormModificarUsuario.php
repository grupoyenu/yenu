<?php
/* SE INCLUYE EL ARCHIVO DE CONSTANTES Y EL AUTOLOAD */

require_once '../../principal/modelo/Constantes.php';
require_once '../../principal/modelo/AutoCargador.php';

/* SE REFERENCIAN LOS NAMESPACE */

use app\seguridad\modelo\Usuario;
use app\principal\controlador\ControladorHTML;
use app\principal\modelo\AutoCargador;

AutoCargador::cargarModulos();

/* INICIALIZA LA SESION PARA GUARDAR EL LOG */

session_start();

/* INICIO DEL CODIGO PROPIO DEL ARCHIVO */

$boton = "";
if (isset($_POST['idUsuario'])) {
    $idUsuario = $_POST['idUsuario'];
    $usuario = new Usuario($idUsuario);
    $resultado = $usuario->obtenerPorIdentificador();
    if ($resultado[0] == 2) {

        $nombre = $usuario->getNombre();
        $email = $usuario->getEmail();
        $estado = $usuario->getEstado();
        $metodo = $usuario->getMetodo();
        $rol = $usuario->getRol();
        $idRol = $rol->getId();
        $nombreRol = $rol->getNombre();

        if ($estado == "Activo") {
            $opcionesEstado = '<option value="Activo" selected>Activo</option>
                               <option value="Inactivo">Inactivo</option>';
        } else {
            $opcionesEstado = '<option value="Activo">Activo</option>
                               <option value="Inactivo" selected>Inactivo</option>';
        }

        if ($metodo == "Google") {
            $opcionesMetodo = '<option value="Google" selected>Google</option>
                               <option value="Manual">Manual</option>';
        } else {
            $opcionesMetodo = '<option value="Google">Google</option>
                               <option value="Manual" selected>Manual</option>';
        }

        $cuerpo = '
            <input type="hidden" name="idUsuario" id="idUsuario" value="' . $idUsuario . '">
            <div class="form-row">
                <label for="nombre" class="col-sm-2 col-form-label"
                       title="Caracter obligatorio">* Nombre completo:</label>
                <div class="col">
                    <input type="text" class="form-control mb-2" 
                           name="nombre" id="nombre" 
                           value = "' . $nombre . '"
                           maxlength="50" minlength="8" 
                           pattern="[A-Za-zÁÉÍÓÚÑáéíóúñ, ]{8,50}"
                           title="Escriba el nombre del usuario a crear. Longitud mínima: 8. Longitud máxima: 50"
                           placeholder="Apellido y nombre" required>
                </div>
                <label for="correo" class="col-sm-2 col-form-label"
                       title="Caracter obligatorio">* E-mail:</label>
                <div class="col">
                    <input type="email" class="form-control mb-2" 
                           name="correo" id="correo" 
                           value = "' . $email . '"
                           maxlength="35" minlength="12"
                           title="Escriba el correo electrónico del usuario a crear. Longitud mínima: 12. Longitud máxima: 35"
                           placeholder="E-mail" required>
                </div>
            </div>
            <div class="form-row">
                <label for="rol" class="col-sm-2 col-form-label"
                       title="Caracter obligatorio">* Rol:</label>
                <div class="col">
                    <select class="form-control mb-2" id="rol" name="rol"
                            title="Seleccione el rol a asignar para el usuario" required>
                            <option value="' . $idRol . '">' . $nombreRol . '</option>
                    </select>
                </div>
                <label for="estado" class="col-sm-2 col-form-label"
                       title="Caracter obligatorio">* Estado:</label>
                <div class="col">
                    <select class="form-control mb-2" id="estado" name="estado"
                            title="Seleccione el estado del usuario">' . $opcionesEstado . '</select>
                </div>
            </div>
            <div class="form-row">
                <label for="rol" class="col-sm-2 col-form-label"
                       title="Caracter obligatorio">* Método:</label>
                <div class="col">
                    <select class="form-control mb-2" id="metodo" name="metodo"
                            title="Seleccione el metodo de login">' . $opcionesMetodo . '</select>
                </div>
                <label class="col-sm-2 col-form-label"></label>
                <div class="col"></div>
            </div>';
        $boton = '<button type="submit" class="btn btn-success" 
                            id="btnModificarUsuario" title="Guardar datos" disabled>
                        <i class="far fa-save"></i> GUARDAR
                  </button>';
    } else {
        $codigo = $resultado[0];
        $mensaje = $resultado[1];
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
            <h4><i class="fas fa-user-alt"></i> MODIFICAR USUARIO</h4>
        </div>
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
                <div class="card-header bg-dark text-white"
                     title="Formulario de modificación">Modifique la información y presione GUARDAR</div>
                <div class="card-body"><?= $cuerpo; ?></div>
            </div>
            <div class="form-row mt-2 mb-4">
                <div class="col text-right">
                    <?= $boton; ?>
                    <a href="FormBuscarUsuario.php" title="Ir al formulario de búsqueda">
                        <button type="button" class="btn btn-outline-info">
                            <i class="fas fa-search"></i> BUSCAR
                        </button>
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>
<script type="text/javascript" src="../js/ModificarUsuario.js"></script>

