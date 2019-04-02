<?php
include_once '../../../lib/conf/Conexion.php';
include_once '../../modelos/Rol.php';
include_once '../../../lib/conf/Utilidades.php';

print("
<html lang='es'>
    <meta charset='UTF-8'>
    <body style='background-color: #e2e3e5'>
    <h3>PRUEBA CONSTRUCTOR - CLASE ROL.PHP</h3>");

if (!isset($_POST['idrol']) && !isset($_POST['nombre'])) {
    print("
    <form method='post'>
        <label>Identificador de rol:</label>
        <input type = 'number' name='idrol' min='1' placeholder='Identificador'/>
        <label>Nombre de rol:</label>
        <input type = 'text' name='nombre' placeholder='Nombre'/>
        <input type = 'submit' value = 'CONSTRUCTOR'/>
    </form>
    <br><br>
    <a href='../indexTest.php'>IR AL MENU DE OPCIONES</a>");
} else {
    $idrol = $_POST['idrol'];
    $nombre = $_POST['nombre'];
    $rol = new Rol();
    $rol->constructor($nombre, $idrol);
    if ($rol->getEstado()) {
        print("
        <h5>RESULTADO OBTENIDO PARA: '$idrol' - '$nombre'</h5>
        <table border='1'>
            <thead>
                <tr>
                    <th>Identificador</th>
                    <th>Nombre</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{$rol->getIdrol()}</td>
                    <td>{$rol->getNombre()}</td>
                </tr>
            </tbody>
        </table><br>");
    } else {
        print("<h5>ROL INVALIDO: {$rol->getDescripcion()}</h5><br>");
    }
    print("<form method='post'>
            <input type = 'submit' value = 'REGRESAR'/>
        </form>");
}

print("
    </body>
</html>");