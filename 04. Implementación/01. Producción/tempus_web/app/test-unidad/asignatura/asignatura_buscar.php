<?php

header("Content-Type: text/html;charset=iso-8859-1");

include_once '../../modelos/Conexion.php';
include_once '../../modelos/Utilidades.php';
include_once '../../modelos/Asignatura.php';


print("
<html lang='es'>
    <body style='background-color: #e2e3e5'>
    <h3>CLASE ASIGNATURA.PHP</h3>
    <h4>METODO A PROBAR: BUSCAR(NOMBRE)</h4>");

if (!isset($_POST['idasignatura']) && !isset($_POST['nombre'])) {
    print("
    <form method='post'>
        <table>
            <tr>
                <td><label>Nombre de asignatura:</label><td>
                <td><input type='text' name='nombre'><td>
            </tr>
        </table>
        <input type = 'submit' value = 'CONSTRUCTOR'/>
    </form>
    <br><br>
    <a href='../indexTest.php'>IR AL MENU DE OPCIONES</a>");
} else {
    $nombre = $_POST['nombre'];
    $asignatura = new Asignatura();
    $asignatura->constructor($nombre);
    $rows = $asignatura->buscar();
    if (is_null($rows) || empty($rows)) {
        if($asignatura->getDescripcion()) {
            print("<h5>ASIGNATURA INVALIDA: {$asignatura->getDescripcion()}</h5><br>");
        } else {
            print("<h5>NO SE ENCONTRARON RESULTADOS</h5><br>");
        }
    } else {
        
        print ("
        <h5>RESULTADO OBTENIDO PARA: '$nombre'</h5>
        <table border='1'>
            <thead>
                <tr>
                    <th>Idasignatura</th>
                    <th>Nombre</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{$rows[0]['idasignatura']}</td>
                    <td>{$rows[0]['nombre']}</td>
                </tr>
            </tbody>
        </table>
        <br>");
    }
    print("<form method='post'>
            <input type = 'submit' value = 'REGRESAR'/>
        </form>");
}
print("
    </body>
</html>");