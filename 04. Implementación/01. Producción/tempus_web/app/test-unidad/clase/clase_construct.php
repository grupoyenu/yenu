<?php
include_once '../../../lib/conf/Conexion.php';
include_once '../../../lib/conf/Utilidades.php';
include_once '../../modelos/Clase.php';
include_once '../../modelos/Aula.php';

print("
<html lang='es'>
    <meta charset='UTF-8'>
    <body style='background-color: #e2e3e5'>
    <h3>PRUEBA CONSTRUCT - CLASE.PHP</h3>");

if (!isset($_POST['idclase'])) {
    print("
    <form method='post'>
        <label>Identificador de clase:</label>
        <input type = 'number' name='idclase' min='1' placeholder='Identificador'/>
        <input type = 'submit' value = 'CONSTRUCT'/>
    </form>
    <br><br>
    <a href='../indexTest.php'>IR AL MENU DE OPCIONES</a>");
} else {
    $idclase = $_POST['idclase'];
    $clase = new Clase($idclase);
    if ($clase->getEstado()) {
        print("
        <h5>RESULTADO OBTENIDO PARA: '$idclase'</h5>
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
        print("<h5>NO SE OBTUVO CLASE PARA '$idclase': {$clase->getDescripcion()}</h5><br>");
    }
    print("<form method='post'>
            <input type = 'submit' value = 'REGRESAR'/>
        </form>");
}

print("
    </body>
</html>");