<?php

include_once '../../modelos/Conexion.php';
include_once '../../modelos/Llamado.php';
include_once '../../modelos/Aula.php';

echo "
<html lang='es'>
    <meta charset='UTF-8'>
    <body style='background-color: #e2e3e5'>
    <h3>PRUEBA MODIFICAR - CLASE LLAMADO.PHP</h3>";

if (!isset($_POST['enviado'])) {
    echo "
    <form method='post'>
        <input type='hidden' name='enviado' value='true'/>
        <table>
            <tr>
                <td>Identificador de llamado:</td>
                <td><input type='number' name='idllamado' min='1' placeholder='Identificador de llamado'/></td>
            </tr>
            <tr>
                <td>Fecha:</td>
                <td><input type='date' name='fecha' min='1'/></td>
            </tr>
            <tr>
                <td>Hora:</td>
                <td><input type='text' name='hora' maxlength='5' placeholder='Hora de llamado'/></td>
            </tr>
            <tr>
                <td>Identificador de aula:</td>
                <td><input type='number' name='idaula' min='1' placeholder='Identificador de aula'/></td>
            </tr>
            <tr>
                <td></td>
                <td><input type = 'submit' value = 'MODIFICAR LLAMADO'/></td>
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
    $fecha = $_POST['fecha'];
    $hora = $_POST['hora'];
    $idaula = $_POST['idaula'];

    $llamado = new Llamado();
    $llamado->setIdllamado($idllamado);
    $llamado->setFecha($fecha);
    $llamado->setHora($hora);
    if ($_POST['idaula']) {
        $aula = new Aula($_POST['idaula']);
        $llamado->setAula($aula);
    }
    $modificar = $llamado->modificar();
    switch ($modificar) {
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
