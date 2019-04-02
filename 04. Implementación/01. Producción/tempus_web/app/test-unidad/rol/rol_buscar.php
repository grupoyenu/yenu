<?php
include_once '../../../lib/conf/Conexion.php';
include_once '../../modelos/Rol.php';
include_once '../../../lib/conf/Utilidades.php';

print("
<html lang='es'>
    <meta charset='UTF-8'>
    <body style='background-color: #e2e3e5'>
    <h3>PRUEBA BUSCAR - CLASE ROL.PHP</h3>");

if (!isset($_POST['nombre'])) {
    print("
    <form method='post'>
        <label>Nombre de rol:</label>
        <input type = 'text' name='nombre' placeholder='Nombre'/>
        <input type = 'submit' value = 'BUSCAR ROL'/>
    </form>
    <br><br>
    <a href='../indexTest.php'>IR AL MENU DE OPCIONES</a>");
} else {
    $nombre = $_POST['nombre'];
    $rol = new Rol();
    $rol->setNombre($nombre);
    $rows = $rol->buscar();
    if (empty($rows)) {
        if($rol->getDescripcion()) {
            print("<h5>ROL INVALIDO: {$rol->getDescripcion()}</h5><br>");
        } else {
            print("<h5>NO SE ENCONTRARON RESULTADOS</h5><br>");
        }
    } else {
        $rol = $rows[0];
        print("
        <h5>RESULTADO OBTENIDO PARA: '$nombre'</h5>
        <table border='1'>
            <thead>
                <tr>
                    <th>Identificador</th>
                    <th>Nombre</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{$rol['idrol']}</td>
                    <td>{$rol['nombre']}</td>
                </tr>
            </tbody>
        </table><br>");
    }
    print("<form method='post'>
            <input type = 'submit' value = 'REGRESAR'/>
        </form>");
}

print("
    </body>
</html>");