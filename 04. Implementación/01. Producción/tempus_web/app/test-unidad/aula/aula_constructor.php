<?php
include_once '../../../lib/conf/Conexion.php';
include_once '../../modelos/Aula.php';
include_once '../../../lib/conf/Utilidades.php';

print("
<html lang='es'>
    <meta charset='UTF-8'>
    <body style='background-color: #e2e3e5'>
    <h3>CLASE AULA.PHP</h3>
    <h4>METODO A PROBAR: CONSTRUCTOR(NOMBRE, SECTOR, IDAULA)</h4>");
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
        <input type = 'submit' value = 'CONSTRUCTOR'/>
    </form>
    <br><br>
    <a href='../indexTest.php'>IR AL MENU DE OPCIONES</a>");
} else {
    $idaula = $_POST['idaula'];
    $nombre = $_POST['nombre'];
    $sector = $_POST['sector'];
    $aula = new Aula();
    $aula->constructor($nombre, $sector, $idaula);
    if ($aula->getEstado()) {
        print("
        <h5>RESULTADO OBTENIDO PARA: '$idaula' - '$nombre - $sector'</h5>
        <table border='1'>
            <thead>
                <tr>
                    <th>Identificador</th>
                    <th>Nombre</th>
                    <th>Sector</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{$aula->getIdaula()}</td>
                    <td>{$aula->getNombre()}</td>
                    <td>{$aula->getSector()}</td>
                </tr>
            </tbody>
        </table><br>");
    } else {
        print("<h5>AULA INVALIDA: {$aula->getDescripcion()}</h5><br>");
    }
    print("<form method='post'>
            <input type = 'submit' value = 'REGRESAR'/>
        </form>");
}
print("
    </body>
</html>");