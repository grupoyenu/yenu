<?php

header("Content-Type: text/html;charset=iso-8859-1");
include_once '../../modelos/Conexion.php';
include_once '../../modelos/Utilidades.php';
include_once '../../modelos/Asignatura.php';


print("
<html lang='es'>
    <body style='background-color: #e2e3e5'>
    <h3>CLASE ASIGNATURA.PHP</h3>
    <h4>METODO A PROBAR: CONSTRUCT(NOMBRE, IDASIGNATURA)</h4>");

if (!isset($_POST['idasignatura']) && !isset($_POST['nombre'])) {
    print("
    <form method='post'>
        <table>
            <tr>
                <td><label>Identificador de asignatura:</label><td>
                <td><input type='number' name='idasignatura'><td>
            </tr>
            <tr>
                <td><label>Nombre de asignatura:</label><td>
                <td><input type='text' name='nombre'><td>
            </tr>
        </table>
        <input type = 'submit' value = 'CONSTRUCTOR'/>
    </form>
    <br><br>
    <table>
        <tr>
            <td><a href='menu_asignatura.php'>PROBAR OTRO METODO</a><td>
            <td><a href='../indexTest.php'>PROBAR OTRA CLASE</a><td>
        </tr>
    </table>
    ");
} else {
    $idasignatura = $_POST['idasignatura'];
    $nombre = $_POST['nombre'];
    $asignatura = new Asignatura();
    $asignatura->constructor($nombre, $idasignatura);
    if ($asignatura->getEstado()) {
        print ("
        <h5>RESULTADO OBTENIDO PARA: '$nombre - $idasignatura'</h5>
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
        print("<h5>ASIGNATURA INVALIDA '{$asignatura->getDescripcion()}'</h5><br>");
    }
    print("<form method='post'>
            <input type = 'submit' value = 'REGRESAR'/>
        </form>");
}
print("
    </body>
</html>");
