<?php
include_once '../../../lib/conf/Conexion.php';
include_once '../../modelos/Clase.php';
include_once '../../modelos/Aula.php';
include_once '../../../lib/conf/Utilidades.php';

print("
<html lang='es'>
    <meta charset='UTF-8'>
    <body style='background-color: #e2e3e5'>
    <h3>PRUEBA BUSCAR - CLASE.PHP</h3>");

if (!isset($_POST['dia']) && !isset($_POST['desde']) && !isset($_POST['hasta']) && !isset($_POST['idaula'])) {
    print("
    <form method='post'>
        <label>Dia:</label>
        <input type = 'number' name='dia' min='1' placeholder='Dia'/>
        <label>Desde:</label>
        <input type = 'text' name='desde' placeholder='Desde'/>
        <br>
        <label>Hasta:</label>
        <input type = 'text' name='hasta' placeholder='Hasta'/>
        <label>Id aula:</label>
        <input type = 'number' name='idaula' min='1' placeholder='Identificador aula'/>
        <input type = 'submit' value = 'BUSCAR CLASE'/>
    </form>
    <br><br>
    <a href='../indexTest.php'>IR AL MENU DE OPCIONES</a>");
} else {
    $dia = $_POST['dia'];
    $desde = $_POST['desde'];
    $hasta = $_POST['hasta'];
    $idaula = $_POST['idaula'];
    print("DATOS: ".$dia."-".$desde."-".$hasta."-".$idaula);
    $aula = new Aula($idaula);
    $clase = new Clase();
    $clase->constructor($dia, $desde, $hasta, $aula);
    $rows = $clase->buscar();
    if (!empty($rows)) {
        $clase = $rows[0];
        print("
        <h5>RESULTADO OBTENIDO</h5>
        <table border='1'>
            <thead>
                <tr>
                    <th>Identificador</th>
                    <th>dia</th>
                    <th>desde</th>
                    <th>hasta</th>
                    <th>idaula</th>
                    <th>nombre</th>
                    <th>sector</th>
                    <th>fecha modificacion</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{$clase['idclase']}</td>
                    <td>{$clase['dia']}</td>
                    <td>{$clase['desde']}</td>
                    <td>{$clase['hasta']}</td>
                    <td>{$clase['idaula']}</td>
                    <td>{$clase['nombre']}</td>
                    <td>{$clase['sector']}</td>
                    <td>{$clase['fechamod']}</td>    
                </tr>
            </tbody>
        </table><br>");
    } else {
        print("<h5>NO SE OBTUVIERON RESULTADOS: {$clase->getDescripcion()}</h5><br>");
    }
    print("<form method='post'>
            <input type = 'submit' value = 'REGRESAR'/>
        </form>");
}

print("
    </body>
</html>");