<?php

include_once '../../../lib/conf/Conexion.php';
include_once '../../modelos/Rol.php';
include_once '../../../lib/conf/Utilidades.php';

print("
<html lang='es'>
    <meta charset='UTF-8'>
    <body style='background-color: #e2e3e5'>
    <h3>PRUEBA MODIFICAR - CLASE ROL.PHP</h3>");

if (!isset($_POST['idrol']) && !isset($_POST['nombre'])) {
    print("
    <form method='post'>
        <label>Identificador de rol:</label>
        <input type = 'number' name='idrol' min='1' placeholder='Identificador'/>
        <label>Nuevo nombre de rol:</label>
        <input type = 'text' name='nombre' placeholder='Nombre'/>
        <input type = 'submit' value = 'MODIFICAR'/>
    </form>
    <br><br>
    <a href='../indexTest.php'>IR AL MENU DE OPCIONES</a>");
} else {
    $idrol = $_POST['idrol'];
    $nombre = $_POST['nombre'];
    $rol = new Rol();
    $rol->constructor($nombre, $idrol);
    $modificacion = $rol->modificar();

    if(is_null($modificacion)) {
        if($rol->getDescripcion()) {
            print("<h5 style='color:orange;'>RESULTADO OBTENIDO: '{$rol->getDescripcion()}'</h5>");
        } else {
             print("<h5 style='color:orange;'>RESULTADO OBTENIDO: 'El rol se considera invalido por eso no se realizó la modificación'</h5>");
        }
    } else {
        if($modificacion) {
            print("<h5 style='color:green;'>RESULTADO OBTENIDO: '{$rol->getDescripcion()}'</h5>");
        } else {
             print("<h5 style='color:red;'>RESULTADO OBTENIDO: '{$rol->getDescripcion()}'</h5>");
        }
    }
    print("<form method='post'>
            <input type = 'submit' value = 'REGRESAR'/>
        </form>");
}

print("
    </body>
</html>");