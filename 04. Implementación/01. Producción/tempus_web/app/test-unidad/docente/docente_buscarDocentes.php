<?php

header("Content-Type: text/html;charset=iso-8859-1");
include_once '../../modelos/Conexion.php';
include_once '../../modelos/Utilidades.php';
include_once '../../modelos/Docente.php';

echo "
<html lang='es'>
    <body style='background-color: #e2e3e5'>
    <h3>CLASE DOCENTE.PHP</h3>
    <table border='1'>
        <thead>
            <tr>
                <th>METODO</th>
                <th>PARAMETROS</th>
                <th>DESCRIPCION</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Buscar docentes</td>
                <td></td>
                <td>Busca todos los docentes cargados en la BD</td>
            </tr>
        </tbody>
    </table><br><br>";
$docente = new Docente();
$rows = $docente->buscarDocentes();

if(is_null($rows)) {
    echo "<h5>FALLO LA CONSULTA</h5>";
} else {
    if(empty($rows)){
        echo "<h5>NO SE OBTUVIERON RESULTADOS</h5>";
    } else {
        echo "
        <table border='1'>
            <thead>
                <tr>
                    <th>Id Docente</th>
                    <th>Nombre Docente</th>
                </tr>
            </thead>
            <tbody>";
        foreach ($rows as $plan) {
            echo "<tr>
                <td>{$plan['iddocente']}</td>
                <td>{$plan['nombre']}</td>
            </tr>";
        }    
        echo "</tbody>
        </table>
        <br>";
    }
}
echo"
    <table>
        <tr>
            <td><a href='menu_docente.php'>PROBAR OTRO METODO</a><td>
            <td><a href='../indexTest.php'>PROBAR OTRA CLASE</a><td>
        </tr>
    </table>";
echo "
    </body>
</html>";

