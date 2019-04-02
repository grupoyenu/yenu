<?php

$controlador = new ControladorUsuario();
$rows = $controlador->buscar();

echo '
<div class="container">
    <h4 class="text-center p-4">BUSCAR USUARIO</h4>';
if (is_null($rows)) {
    echo '<h5 class="text-center p-2">No se pudo realizar la consulta de usuarios</h5>';
} else {
    if (empty($rows)) {
        echo '<h5 class="text-center p-2">No se obtuvieron resultados</h5>';
    } else {
        echo '
        <table id="tablaBuscarUsuarios" class="table table-bordered table-hover">
            <thead class="thead-dark">
                <tr>
                    <th class="text-center">Nombre de usuario</th>
                    <th class="text-center">Correo electronico</th>
                    <th class="text-center">Rol</th>
                    <th class="text-center">Eliminar</th>
                    <th class="text-center">Modificar</th>
                </tr>
            </thead>
            <tbody style="background-color: white;">';
        foreach ($rows as $rol) {
            echo '
                <tr>
                    <td>' . $rol['nombre'] . '</td>
                    <td>' . $rol['email'] . '</td>
                    <td>' . $rol['rol'] . '</td>
                    <td class="text-center">
                        <button type="button" class="btn btn-sm  btn-outline-danger">
                            <img src="./lib/img/tempus_borrar.png" width="18" height="18" alt="abm_eliminar"/>
                        </button>
                    </td>
                    <td class="text-center">
                        <button type="button" class="btn btn-sm  btn-outline-warning">
                            <img src="./lib/img/tempus_editar.png" width="18" height="18" alt="abm_editar"/>
                        </button>
                    </td>
                </tr>';
        }
        echo '
            </tbody>
        </table>';
    }
}
echo '</div> 
      <script type="text/javascript" src="./app/js/BuscarUsuario.js"></script>';