<?php
include_once '../../modelos/Conexion.php';
include_once '../../modelos/Llamado.php';
include_once '../../modelos/Aula.php';

echo "
<html lang='es'>
    <meta charset='UTF-8'>
    <body style='background-color: #e2e3e5'>
    <h3>PRUEBA CONSTRUCT - CLASE LLAMADO.PHP</h3>";

if (!isset($_POST['enviado'])) {
    print("
    <form method='post'>
        <input type = 'hidden' name='enviado' value='true'/>
        <table>
            <tr>
                <td><label>Fecha:</label></td>
                <td><input type = 'date' name='fecha'/></td>
            </tr>
            <tr>
                <td><label>Hora:</label></td>
                <td><input type = 'text' name='hora' placeholder='Hora'/></td>
            </tr>
            <tr>
                <td><label>Identificador de aula:</label></td>
                <td><input type = 'number' name='idaula' placeholder='Identificador aula'/></td>
            </tr>
            <tr>
                <td></td>
                <td><input type = 'submit' value = 'CREAR LLAMADO'/></td>
            </tr>
        </table>
        
    </form>
    <table>
        <tr>
            <td><a href='menu_llamado.php'>MENU DE LLAMADO</a><td>
            <td><a href='../indexTest.php'>MENU GENERAL</a><td>
        </tr>
    </table>");
} else {
    $fecha = $_POST['fecha'];
    $hora = $_POST['hora'];
    $idaula = $_POST['idaula'];
    $aula = ($idaula) ? new Aula($idaula) : NULL;
    $llamado = new Llamado();
    if ($llamado->constuctor($fecha, $hora, null, $aula)) {
        $creacion = $llamado->crear();
        switch ($creacion) {
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
    } else {
        echo "<h5>LLAMADO INVALIDO: {$llamado->getDescripcion()}</h5><br>";
    }
    print("<form method='post'>
            <input type = 'submit' value = 'REGRESAR'/>
        </form>");
}
echo "
    </body>
</html>";

