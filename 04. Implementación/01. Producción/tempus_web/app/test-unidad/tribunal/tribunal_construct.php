<?php
include_once '../../modelos/Conexion.php';
include_once '../../modelos/Tribunal.php';
include_once '../../modelos/Docente.php';
include_once '../../modelos/Utilidades.php';
echo "
<html lang='es'>
    <meta charset='UTF-8'>
    <body style='background-color: #e2e3e5'>
    <h3>PRUEBA CONSTRUCT - CLASE TRIBUNAL.PHP</h3>";

if (!isset($_POST['idtribunal'])) {
    echo "
    <form method='post'>
        <table>
            <tr>
                <td>Identificador de tribunal:</td>
                <td><input type = 'number' name='idtribunal' min='1' placeholder='Identificador de tribunal'/></td>
            </tr>
            <tr>
                <td></td>
                <td><input type = 'submit' value = 'CONSTRUCT'/></td>
            </tr>
        </table>
    </form>
    <table>
        <tr>
            <td><a href='menu_tribunal.php'>MENU DE TRIBUNAL</a><td>
            <td><a href='../indexTest.php'>MENU GENERAL</a><td>
        </tr>
    </table>";
} else {
    $idtribunal = $_POST['idtribunal'];
    $tribunal = new Tribunal($idtribunal);
    if ($tribunal->getEstado()) {
        echo "
        <table border='1'>
            <thead>
                <tr>
                    <th>Identificador tribunal</th>
                    <th>Identificador presidente</th>
                    <th>Nombre de presidente</th>
                    <th>Identificador vocal 1</th>
                    <th>Nombre vocal 1</th>
                    <th>Identificador vocal 2</th>
                    <th>Nombre vocal 2</th>
                    <th>Identificador suplente</th>
                    <th>Nombre suplente</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{$tribunal->getIdtribunal()}</td>
                    <td>{$tribunal->getPresidente()->getIdDocente()}</td>
                    <td>{$tribunal->getPresidente()->getNombre()}</td>
                    <td>{$tribunal->getVocal1()->getIdDocente()}</td>
                    <td>{$tribunal->getVocal1()->getNombre()}</td>";
        if($tribunal->getVocal2()) {
            echo "  <td>{$tribunal->getVocal2()->getIdDocente()}</td>
                    <td>{$tribunal->getVocal2()->getNombre()}</td>";
        } else {
            echo "  <td></td><td></td>";
        }
        if($tribunal->getSuplente()) {
            echo "  <td>{$tribunal->getSuplente()->getIdDocente()}</td>
                    <td>{$tribunal->getSuplente()->getNombre()}</td>";
        } else {
            echo "  <td></td><td></td>";
        }
        echo "      
                </tr>
            </tbody>
        </table><br>";
    } else {
        echo "<h5>NO SE OBTUVIERON RESULTADOS</h5><br>";
    }
    echo 
    "<form method='post'>
        <input type = 'submit' value = 'REGRESAR'/>
    </form>";
}
echo "
    </body>
</html>";