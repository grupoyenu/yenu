<?php

include_once '../../../lib/conf/Conexion.php';
include_once '../../models/Aulas.php';
print("
<html lang='es'>
    <meta charset='UTF-8'>
    <body style='background-color: #e2e3e5'>
    <h3>PRUEBA CONSTRUCTOR - CLASE AULAS.PHP</h3>");

if (!isset($_POST['construct'])) {
    print("
    <form method='post'>
        <label>Todas:</label>
        <select name = 'construct'>
        <option value = 'true'>TRUE</option>
        <option value = 'false'>FALSE</option>
        </select>
        <input type = 'submit' value = 'CREAR'/>
    </form>");
} else {
    $buscar = $_POST['construct'];
    if($buscar == 'true') {
        $buscar = true;
    } else {
        $buscar = false;
    }
    $aulas = new Aulas($buscar);
    $rows = $aulas->getRows();
    if (!empty($rows)) {
        print("
        <h5>RESULTADO OBTENIDO PARA: '$buscar'</h5>
        <table border='1'>
            <thead>
                <tr>
                    <th>Idaula</th>
                    <th>Nombre</th>
                    <th>Sector</th>
                </tr>
            </thead>
            <tbody>");
        foreach ($rows as $key => $asignatura) {
            print("
                <tr>
                    <td>{$asignatura['idaula']}</td>
                    <td>{$asignatura['nombre']}</td>
                    <td>{$asignatura['sector']}</td>
                </tr>");
        }
        print("
            </tbody>
    </table><br>");
    } else {
        print("<h5>NO SE OBTUVIERON AULAS</h5>");
    }
    print("<form method='post'>
            <input type = 'submit' value = 'REGRESAR'/>
        </form>");
}
print("
    </body>
</html>");