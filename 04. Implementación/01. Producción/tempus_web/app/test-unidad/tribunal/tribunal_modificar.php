<?php

header("Content-Type: text/html;charset=iso-8859-1");
include_once '../../modelos/Conexion.php';
include_once '../../modelos/Utilidades.php';
include_once '../../modelos/Tribunal.php';
include_once '../../modelos/Docente.php';

echo "
<html lang='es'>
    <body style='background-color: #e2e3e5'>
    <h3>CLASE TRIBUNAL.PHP</h3>
    <table>
            <tr>
                <td>Metodo:</td>
                <td>MODIFICAR</td>
            </tr>
            <tr>
                <td>Descripcion:</td>
                <td>Crea un tribunal (y sus docentes) y lo guarda en la BD</td>
            </tr>
    </table><br><br>";
if (!isset($_POST['enviado'])) {
    echo "
    <form method='post'>
        <input type = 'hidden' name='enviado' value = 'true'/>
        <table>
            <tr>
                <td><label>Identificador Tribunal:</label><td>
                <td><input type='number' min='1' name='tribunal' placeholder='Identificador de tribunal'><td>
            </tr>
            <tr>
                <td><label>Identificador Presidente:</label><td>
                <td><input type='number' min='1' name='presidente' placeholder='Identificador de presidente'><td>
            </tr>
            <tr>
                <td><label>Identificador Vocal 1:</label><td>
                <td><input type='number' min='1' name='vocal1' placeholder='Identificador de vocal 1'><td>
            </tr>
            <tr>
                <td><label>Identificador Vocal 2:</label><td>
                <td><input type='number' min='1' name='vocal2' placeholder='Identificador de vocal 2'><td>
            </tr>
            <tr>
                <td><label>Identificador Suplente:</label><td>
                <td><input type='number' min='1' name='suplente' placeholder='Identificador de suplente'><td>
            </tr>
            <tr>
                <td><td>
                <td><input type = 'submit' value = 'MODIFICAR TRIBUNAL'/><td>
            </tr>
        </table>
        
    </form>
    <br><br>";
} else {
    $idtribunal = $_POST['tribunal'];
    $idpresidente = $_POST['presidente'];
    $idvocal1 = $_POST['vocal1'];
    $idvocal2 = $_POST['vocal2'];
    $idsuplente = $_POST['suplente'];
    $presidente = ($idpresidente) ? new Docente($idpresidente) : NULL;
    $vocal1 = ($idvocal1) ? new Docente($idvocal1) : NULL;
    $vocal2 = ($idvocal2) ? new Docente($idvocal2) : NULL;
    $suplente = ($idvocal2 && $idsuplente) ? new Docente($idsuplente) : NULL;
    $tribunal = new Tribunal();
    if ($tribunal->constructor($presidente, $vocal1, $vocal2, $suplente, $idtribunal)) {
        $modificacion = $tribunal->modificar();

        switch ($modificacion) {
            case 1:
                echo "<h5 style='color: red;'> Descripcion: {$tribunal->getDescripcion()}</h5><br>";
                break;
            case 2:
                echo "<h5 style='color: green;'> Descripcion: {$tribunal->getDescripcion()}</h5><br>";
                break;
            case 3:
                echo "<h5 style='color: orange;'> Descripcion: {$tribunal->getDescripcion()}</h5><br>";
                break;
            default :
                echo "<h5 style='color: red;'> Default</h5><br>";
                break;
        }
    } else {
        echo "<h5 style='color: orange;'> Descripcion: {$tribunal->getDescripcion()}</h5><br>";
    }

    echo"<form method='post'>
            <input type = 'submit' value = 'REGRESAR'/>
        </form>";
}
echo"
    <table>
        <tr>
            <td><a href='menu_tribunal.php'>PROBAR OTRO METODO</a><td>
            <td><a href='../indexTest.php'>PROBAR OTRA CLASE</a><td>
        </tr>
    </table>";
echo "
    </body>
</html>";
