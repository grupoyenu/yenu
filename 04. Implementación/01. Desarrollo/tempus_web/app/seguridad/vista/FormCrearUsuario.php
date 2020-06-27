<?php include_once '../../principal/vista/header.php'; ?>
<div class="container-fluid" id="contenido">
    <div class="container">
        <div class="form-row mt-4 mb-4">
            <div class="col text-left">
                <h4><i class="fas fa-user-alt"></i> CREAR USUARIO</h4>
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
            <form id="formCrearUsuario" name="formCrearUsuario" method="POST">
                <div class="card border-dark">
                    <div class="card-header bg-dark text-white"
                         title="Formulario de creación">Complete el formulario y presione GUARDAR</div>
                    <div class="card-body">
                        <div class="form-row">
                            <label for="nombre" class="col-sm-2 col-form-label"
                                   title="Caracter obligatorio">* Nombre completo:</label>
                            <div class="col">
                                <input type="text" class="form-control mb-2" 
                                       name="nombre" id="nombre" 
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
                                        title="Seleccione el rol a asignar para el usuario" required></select>
                            </div>
                            <label for="estado" class="col-sm-2 col-form-label"
                                   title="Caracter obligatorio">* Estado:</label>
                            <div class="col">
                                <select class="form-control mb-2" id="estado" name="estado"
                                        title="Seleccione el estado del usuario">
                                    <option value="Activo">Activo</option>
                                    <option value="Inactivo">Inactivo</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <label for="rol" class="col-sm-2 col-form-label"
                                   title="Caracter obligatorio">* Método:</label>
                            <div class="col">
                                <select class="form-control mb-2" id="metodo" name="metodo"
                                        title="Seleccione el metodo de login">
                                    <option value="Google">Google</option>
                                    <option value="Manual">Manual</option>
                                </select>
                            </div>
                            <label class="col-sm-2 col-form-label"></label>
                            <div class="col"></div>
                        </div>
                    </div>
                </div>
                <div class="form-row mt-2 mb-4">
                    <div class="col text-right"> 
                        <button type="submit" class="btn btn-success" 
                                id="btnCrearPermiso" title="Guardar datos">
                            <i class="far fa-save"></i> GUARDAR
                        </button>
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
</div>
<script type="text/javascript" src="../js/CrearUsuario.js"></script>
<?php
include_once '../../principal/vista/footer.php';
