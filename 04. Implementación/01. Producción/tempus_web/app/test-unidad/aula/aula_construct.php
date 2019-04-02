<?php

include_once '../../../lib/conf/Conexion.php';
include_once '../../modelos/Aula.php';

print("
<html lang='es'>
    <meta charset='UTF-8'>
    <body style='background-color: #e2e3e5'>
    <h3>CLASE AULA.PHP</h3>
    <h4>METODO A PROBAR: __CONSTRUCT(IDAULA)</h4>");

if (!isset($_POST['idaula'])) {
    print("
    <form method='post'>
        <label>Identificador de aula:</label>
        <input type = 'number' name='idaula' min='1' placeholder='Identificador'/>
        <input type = 'submit' value = 'CONSTRUCT'/>
    </form>
    <br><br>
    <a href='../indexTest.php'>IR AL MENU DE OPCIONES</a>");
} else {
    $idaula = $_POST['idaula'];
    $aula = new Aula($idaula);
    if ($aula->getEstado()) {
        print("
        <h5>RESULTADO OBTENIDO PARA: '$idaula'</h5>
        <table border='1'>
            <thead>
                <tr>
                    <th>Identificador</th>
                    <th>Nombre</th>
                    <th>Sector</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{$aula->getIdaula()}</td>
                    <td>{$aula->getNombre()}</td>
                    <td>{$aula->getSector()}</td>
                </tr>
            </tbody>
        </table><br>");
    } else {
        print("<h5>NO SE OBTUVO ROL PARA '$idaula'</h5><br>");
    }
    print("<form method='post'>
            <input type = 'submit' value = 'REGRESAR'/>
        </form>");
}

print("
    </body>
</html>");
