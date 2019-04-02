<?php
include_once '../../../lib/conf/Conexion.php';
include_once '../../modelos/Carrera.php';
include_once '../../../lib/conf/Utilidades.php';

print("
<html lang='es'>
    <meta charset='UTF-8'>
    <body style='background-color: #e2e3e5'>
    <h3>PRUEBA CONSTRUCTOR - CLASE CARRERA.PHP</h3>");

if (!isset($_POST['codigo']) && !isset($_POST['nombre'])) {
    print("
    <form method='post'>
        <label>Codigo de carrera:</label>
        <input type = 'number' name='codigo' min='1' placeholder='Codigo' required/>
        <input type = 'text' name='nombre' placeholder='Nombre' required/>
        <input type = 'submit' value = 'CREAR'/>
    </form>");
} else {
    $codigo = $_POST['codigo'];
    $nombre = $_POST['nombre'];
    $carrera = new Carrera();
    $carrera->constructor($codigo, $nombre);
    if ($carrera->getValida()) {
        print("
        <h5>RESULTADO OBTENIDO PARA: '$codigo' - '$nombre'</h5>
        <table border='1'>
            <thead>
                <tr>
                    <th>Codigo</th>
                    <th>Nombre</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{$carrera->getCodigo()}</td>
                    <td>{$carrera->getNombre()}</td>
                </tr>
            </tbody>
        </table><br>");
    } else {
        print("<h5>CARRERA INVALIDA: {$carrera->getDescripcion()}</h5><br>");
    }
    print("<form method='post'>
            <input type = 'submit' value = 'REGRESAR'/>
        </form>");
}

print("
    </body>
</html>");