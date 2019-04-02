<?php
include_once '../../modelos/Conexion.php';
include_once '../../modelos/Aula.php';
include_once '../../modelos/Utilidades.php';

print("
<html lang='es'>
    <meta charset='UTF-8'>
    <body style='background-color: #e2e3e5'>
    <h3>CLASE AULA.PHP</h3>
    <h4>METODO A PROBAR: BUSCAR(NOMBRE, SECTOR)</h4>");

if (!isset($_POST['nombre']) && !isset($_POST['sector'])) {
    print("
    <form method='post'>
        <table>
            <tr>
                <td><label>Nombre de sector:</label></td>
                <td><input type = 'text' name='sector' placeholder='Sector'/></td>
            </tr>
            <tr>
                <td><label>Nombre de aula:</label></td>
                <td><input type = 'text' name='nombre' placeholder='Nombre'/></td>
            </tr>
        </table>
        <input type = 'submit' value = 'BUSCAR AULA'/>
    </form>
    <br><br>
    <a href='../indexTest.php'>IR AL MENU DE OPCIONES</a>");
} else {
    $nombre = $_POST['nombre'];
    $sector = $_POST['sector'];
    $aula = new Aula();
    $aula->constructor($nombre, $sector);
    $rows = $aula->buscar();
    if (empty($rows)) {
        if($aula->getDescripcion()) {
            print("<h5>AULA INVALIDA: {$aula->getDescripcion()}</h5><br>");
        } else {
            print("<h5>NO SE ENCONTRARON RESULTADOS</h5><br>");
        }
    } else {
        $aula = $rows[0];
        print("
        <h5>RESULTADO OBTENIDO PARA: '$nombre - $sector'</h5>
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
                    <td>{$aula['idaula']}</td>
                    <td>{$aula['nombre']}</td>
                    <td>{$aula['sector']}</td>    
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