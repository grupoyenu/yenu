<?php

header("Content-Type: text/html;charset=iso-8859-1");
include_once '../../modelos/Conexion.php';
include_once '../../modelos/Asignatura.php';
print("
<html lang='es'>
    <body style='background-color: #e2e3e5'>
    <h3>CLASE ASIGNATURA.PHP</h3>
    <h4>METODO A PROBAR: CONSTRUCT(IDASIGNATURA)</h4>");

if (!isset($_POST['identificador'])) {
    print("
    <form method='post'>
        <label>Identificador de asignatura:</label>
        <input type='number' name='identificador'>
        <input type = 'submit' value = 'CONSTRUCT'/>
    </form>
    <br><br>
    <table>
        <tr>
            <td><a href='menu_asignatura.php'>PROBAR OTRO METODO</a><td>
            <td><a href='../indexTest.php'>PROBAR OTRA CLASE</a><td>
        </tr>
    </table>");
} else {
    $idasignatura = $_POST['identificador'];
    $asignatura = new Asignatura($idasignatura);
    if ($asignatura->getEstado()) {
        print ("
        <h5>RESULTADO OBTENIDO PARA: '$idasignatura'</h5>
        <table border='1'>
            <thead>
                <tr>
                    <th>Idasignatura</th>
                    <th>Nombre</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{$asignatura->getIdasignatura()}</td>
                    <td>{$asignatura->getNombre()}</td>
                </tr>
            </tbody>
        </table>
        <br>");
    } else {
        print("<h5>NO SE OBTUVO ASIGNATURA PARA '$idasignatura'</h5><br>");
    }
    print("<form method='post'>
            <input type = 'submit' value = 'REGRESAR'/>
        </form>");
}
print("
    </body>
</html>");
