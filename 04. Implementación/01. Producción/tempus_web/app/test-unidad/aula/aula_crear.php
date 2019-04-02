<?php

include_once '../../modelos/Conexion.php';
include_once '../../modelos/Aula.php';
include_once '../../modelos/Utilidades.php';

print("
<html lang='es'>
    <meta charset='UTF-8'>
    <body style='background-color: #e2e3e5'>
    <h3>CLASE AULA.PHP</h3>
    <h4>METODO A PROBAR: CREAR(NOMBRE, SECTOR)</h4>");
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
        <input type = 'submit' value = 'CREAR AULA'/>
    </form>
    <br><br>
    <a href='../indexTest.php'>IR AL MENU DE OPCIONES</a>");
} else {
    $nombre = $_POST['nombre'];
    $sector = $_POST['sector'];
    $aula = new Aula();
    $aula->constructor($nombre, $sector);
    $creacion = $aula->crear();

    echo "<h5>RESULTADO OBTENIDO PARA '$nombre - $sector'</h5>";
    if($creacion >1) {
        $style = ($creacion == 2) ? "style='color:green;'"  : "style='color:orange;'";
        echo "
        <h5 $style> {$aula->getDescripcion()} </h5>
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
        </table><br>";
    } else {
        echo "<h5 style='color:red;'> {$aula->getDescripcion()} </h5>";
    }
    print("<form method='post'>
            <input type = 'submit' value = 'REGRESAR'/>
        </form>");
}
print("
    </body>
</html>");
