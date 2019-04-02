<?php

include_once '../../modelos/Conexion.php';
include_once '../../modelos/Aula.php';
include_once '../../modelos/Utilidades.php';

print("
<html lang='es'>
    <meta charset='UTF-8'>
    <body style='background-color: #e2e3e5'>
    <h3>CLASE AULA.PHP</h3>
    <h4>METODO A PROBAR: MODIFICAR(NOMBRE, SECTOR, IDAULA)</h4>");
if (!isset($_POST['idaula']) && !isset($_POST['nombre']) && !isset($_POST['sector'])) {
    print("
    <form method='post'>
        <table>
            <tr>
                <td><label>Identificador de aula:</label></td>
                <td><input type = 'number' name='idaula' min='1' placeholder='Identificador'/></td>
            </tr>
            <tr>
                <td><label>Nombre de sector:</label></td>
                <td><input type = 'text' name='sector' placeholder='Sector'/></td>
            </tr>
            <tr>
                <td><label>Nombre de aula:</label></td>
                <td><input type = 'text' name='nombre' placeholder='Nombre'/></td>
            </tr>
        </table>
        <input type = 'submit' value = 'MODIFICAR AULA'/>
    </form>
    <br><br>
    <a href='../indexTest.php'>IR AL MENU DE OPCIONES</a>");
} else {
    $idaula = $_POST['idaula'];
    $nombre = $_POST['nombre'];
    $sector = $_POST['sector'];
    $aula = new Aula();
    $aula->constructor($nombre, $sector, $idaula);
    $modificacion = $aula->modificar();

    if($modificacion) {
        print("<h5>RESULTADO OBTENIDO PARA '$idaula - $nombre - $sector':</h5>");
        print("<h5 style='color:green;'>{$aula->getDescripcion()}</h5>");
    } else {
        print("<h5>RESULTADO OBTENIDO PARA '$idaula - $nombre - $sector':</h5>");
        print("<h5 style='color:red;'>'{$aula->getDescripcion()}'</h5>");
    }
    print("<form method='post'>
            <input type = 'submit' value = 'REGRESAR'/>
        </form>");
}
print("
    </body>
</html>");