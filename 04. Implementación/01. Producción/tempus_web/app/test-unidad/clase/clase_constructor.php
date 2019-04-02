<?php
include_once '../../../lib/conf/Conexion.php';
include_once '../../modelos/Clase.php';
include_once '../../modelos/Aula.php';
include_once '../../../lib/conf/Utilidades.php';

print("
<html lang='es'>
    <meta charset='UTF-8'>
    <body style='background-color: #e2e3e5'>
    <h3>PRUEBA CONSTRUCTOR - CLASE.PHP</h3>");

if (!isset($_POST['dia']) && !isset($_POST['idclase']) && !isset($_POST['desde']) && !isset($_POST['hasta']) && !isset($_POST['idaula'])&& !isset($_POST['fecha'])) {
    print("
    <form method='post'>
        <label>Id clase:</label>
        <input type = 'number' name='idclase' min='1' placeholder='Identificador clase'/>
        <label>Dia:</label>
        <input type = 'number' name='dia' min='1' placeholder='Dia'/>
        <br>
        <label>Desde:</label>
        <input type = 'text' name='desde' placeholder='Desde'/>
        <label>Hasta:</label>
        <input type = 'text' name='hasta' placeholder='Hasta'/>
        <br>
        <label>Id aula:</label>
        <input type = 'number' name='idaula' min='1' placeholder='Identificador aula'/>
        <label>Fecha modificacion:</label>
        <input type = 'text' name='fecha' placeholder='Fecha modificacion'/>
        <br>
        <input type = 'submit' value = 'CONSTRUCTOR'/>
    </form>
    <br><br>
    <a href='../indexTest.php'>IR AL MENU DE OPCIONES</a>");
} else {
    $idclase = $_POST['idclase'];
    $dia = $_POST['dia'];
    $desde = $_POST['desde'];
    $hasta = $_POST['hasta'];
    $idaula = $_POST['idaula'];
    $fecha = $_POST['fecha'];
    
    print("DATOS: ".$idclase."-".$dia."-".$desde."-".$hasta."-".$idaula."-".$fecha);
    $aula = new Aula($idaula);
    $clase = new Clase();
    $clase->constructor($dia, $desde, $hasta, $aula, $idclase, $fecha);
    if ($clase->getEstado()) {
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
                    <td>{$clase->getIdclase()}</td>
                    <td>{$clase->getDia()}</td>
                    <td>{$clase->getDesde()}</td>
                    <td>{$clase->getHasta()}</td>
                    <td>{$clase->getAula()->getIdaula()}</td>
                    <td>{$clase->getAula()->getNombre()}</td>
                    <td>{$clase->getAula()->getSector()}</td>
                    <td>{$clase->getFechamod()}</td>    
                </tr>
            </tbody>
        </table><br>");
    } else {
        print("<h5>CLASE INVALIDA: {$clase->getDescripcion()}</h5><br>");
    }
    print("<form method='post'>
            <input type = 'submit' value = 'REGRESAR'/>
        </form>");
}

print("
    </body>
</html>");