<?php

include_once '../../../lib/conf/Conexion.php';
include_once '../../modelos/Rol.php';
include_once '../../../lib/conf/Utilidades.php';

print("
<html lang='es'>
    <meta charset='UTF-8'>
    <body style='background-color: #e2e3e5'>
    <h3>PRUEBA CREAR - CLASE ROL.PHP</h3>");

if (!isset($_POST['nombre'])) {
    print("
    <form method='post'>
        <label>Nombre de rol:</label>
        <input type = 'text' name='nombre' placeholder='Nombre'/>
        <input type = 'submit' value = 'CREAR'/>
    </form>
    <br><br>
    <a href='../indexTest.php'>IR AL MENU DE OPCIONES</a>");
} else {
    $nombre = $_POST['nombre'];
    $rol = new Rol();
    $rol->setNombre($nombre);
    $creacion = $rol->crear();

    if (is_array($creacion)) {
        $creacion = $creacion[0];
        print("
         <h5 style='color:orange;'>RESULTADO OBTENIDO PARA '$nombre': '{$rol->getDescripcion()}'</h5>
        <table border='1'>
            <thead>
                <tr>
                    <th>Identificador</th>
                    <th>Nombre</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{$creacion['idrol']}</td>
                    <td>{$creacion['nombre']}</td>
                </tr>
            </tbody>
        </table><br>");
    } else {
        if ($creacion) {
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
