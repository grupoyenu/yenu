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
    <table border='1'>
        <thead>
            <tr>
                <th>METODO</th>
                <th>DESCRIPCION</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Buscar</td>
                <td>Busca UN tribunal por el identificador de sus integrantes en la BD</td>
            </tr>
        </tbody>
    </table><br>";
if (!isset($_POST['enviado'])) {
    echo "
    <form method='post'>
        <input type = 'hidden' name='enviado' value = 'true'/>
        <table>
            <tr>
                <td><label>Identificador Presidente:</label><td>
                <td><input type='number' name='idpresidente' placeholder='Identificador de presidente'><td>
            </tr>
            <tr>
                <td><label>Identificador Vocal 1:</label><td>
                <td><input type='number' name='idvocal1' placeholder='Identificador de vocal1'><td>
            </tr>
            <tr>
                <td><label>Identificador Vocal 2:</label><td>
                <td><input type='number' name='idvocal2' placeholder='Identificador de vocal2'><td>
            </tr>
            <tr>
                <td><label>Identificador Suplente:</label><td>
                <td><input type='number' name='idsuplente' placeholder='Identificador de suplente'><td>
            </tr>
            <tr>
                <td><td>
                <td><input type = 'submit' value = 'BUSCAR TRIBUNAL'/><td>
            </tr>
        </table>
    </form>
    <br><br>";
} else {
    $idpresidente = $_POST['idpresidente'];
    $idvocal1 = $_POST['idvocal1'];
    $idvocal2 = $_POST['idvocal2'];
    $idsuplente = $_POST['idsuplente'];
    $presidente = new Docente($idpresidente);
    $vocal1 = new Docente($idvocal1);
    $vocal2 = new Docente($idvocal2);
    $suplente = new Docente($idsuplente);

    $tribunal = new Tribunal();
    $tribunal->constructor($presidente, $vocal1, $vocal2, $suplente);
    $rows = $tribunal->buscar();

    if (is_null($rows)) {
        echo "<h5>NO SE HIZO LA CONSULTA: {$tribunal->getDescripcion()}</h5>";
    } else {
        if (empty($rows)) {
            echo "<h5>NO SE OBTUVIERON RESULTADOS</h5>";
        } else {
            $tribunal = $rows[0];
            echo "
            <table border='1'>
                <thead>
                    <tr>
                        <th>Id tribunal</th>
                        <th>Id Presidente</th>
                        <th>Nombre presidente</th>
                        <th>Id Vocal 1</th>
                        <th>Nombre vocal 1</th>
                        <th>Id vocal 2</th>
                        <th>Id suplente</th>
                    </tr>
                </thead>
                <tbody> 
                    <tr>
                        <td>{$tribunal['idtribunal']}</td>
                        <td>{$tribunal['idp']}</td>
                        <td>{$tribunal['nombrep']}</td>
                        <td>{$tribunal['idv']}</td>
                        <td>{$tribunal['nombrev']}</td>
                        <td>{$tribunal['vocal2']}</td>
                        <td>{$tribunal['suplente']}</td>
                    </tr>
                </tbody>
            </table>
            <br>";
        }
    }
    echo"<form method='post'>
            <input type = 'submit' value = 'REGRESAR'/>
        </form>";
}
echo"
    <table>
        <tr>
            <td><a href='menu_tribunal.php'>MENU TRIBUNAL</a><td>
            <td><a href='../indexTest.php'>MENU GENERAL</a><td>
        </tr>
    </table>";
echo "
    </body>
</html>";
