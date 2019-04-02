<?php

header("Content-Type: text/html;charset=iso-8859-1");
include_once '../../modelos/Conexion.php';
include_once '../../modelos/Utilidades.php';
include_once '../../modelos/Plan.php';
include_once '../../modelos/Carrera.php';
include_once '../../modelos/Asignatura.php';

echo "
<html lang='es'>
    <body style='background-color: #e2e3e5'>
    <h3>CLASE PLAN.PHP</h3>
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
                <td>Buscar planes</td>
                <td></td>
                <td>Busca todos los planes cargados en la BD</td>
            </tr>
        </tbody>
    </table><br><br>";
$plan = new Plan();
$rows = $plan->buscarPlanes();

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
                    <th>Id Asignatura</th>
                    <th>Nombre Asignatura</th>
                    <th>Codigo Carrera</th>
                    <th>Nombre Carrera</th>
                    <th>Anio</th>
                </tr>
            </thead>
            <tbody>";
        foreach ($rows as $plan) {
            echo "<tr>
                <td>{$plan['idasignatura']}</td>
                <td>{$plan['asignatura']}</td>
                <td>{$plan['codigo']}</td>
                <td>{$plan['carrera']}</td>
                <td>{$plan['anio']}</td>
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
            <td><a href='menu_plan.php'>PROBAR OTRO METODO</a><td>
            <td><a href='../indexTest.php'>PROBAR OTRA CLASE</a><td>
        </tr>
    </table>";
echo "
    </body>
</html>";


