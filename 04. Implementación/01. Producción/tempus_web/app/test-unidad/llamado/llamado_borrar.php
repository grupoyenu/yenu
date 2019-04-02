<?php

include_once '../../modelos/Conexion.php';
include_once '../../modelos/Llamado.php';
include_once '../../modelos/Aula.php';

echo "
<html lang='es'>
    <meta charset='UTF-8'>
    <body style='background-color: #e2e3e5'>
    <h3>PRUEBA BORRAR - CLASE LLAMADO.PHP</h3>";

if (!isset($_POST['idllamado'])) {
    echo "
    <form method='post'>
        <table>
            <tr>
                <td>Identificador de llamado:</td>
                <td> <input type = 'number' name='idllamado' min='1' placeholder='Identificador llamado'/></td>
            </tr>
            <tr>
                <td></td>
                <td><input type = 'submit' value = 'BORRAR LLAMADO'/></td>
            </tr>
        </table>
    </form>
    <table>
        <tr>
            <td><a href='menu_llamado.php'>MENU DE LLAMADO</a><td>
            <td><a href='../indexTest.php'>MENU GENERAL</a><td>
        </tr>
    </table>";
} else {
    $idllamado = $_POST['idllamado'];
    $llamado = new Llamado();
    $llamado->setIdllamado($idllamado);
    
    $borrar = $llamado->borrar();
    switch ($borrar) {
        case 0:
            echo "<h5 style='color:blue'>{$llamado->getDescripcion()}</h5>";
            break;
        case 1:
            echo "<h5 style='color:red'>{$llamado->getDescripcion()}</h5>";
            break;
        case 2:
            echo "<h5 style='color:green'>{$llamado->getDescripcion()}</h5>";
            break;
    }
    echo
    "<form method='post'>
        <input type = 'submit' value = 'REGRESAR'/>
    </form>";
}
echo "
    </body>
</html>";
