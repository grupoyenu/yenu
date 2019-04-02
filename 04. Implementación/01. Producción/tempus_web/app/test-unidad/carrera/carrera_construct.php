<?php
include_once '../../../lib/conf/Conexion.php';
include_once '../../modelos/Carrera.php';
print("
<html lang='es'>
    <meta charset='UTF-8'>
    <body style='background-color: #e2e3e5'>
    <h3>PRUEBA CONSTRUCT - CLASE CARRERA.PHP</h3>");

if (!isset($_POST['codigo'])) {
    print("
    <form method='post'>
        <label>Codigo de carrera:</label>
        <input type = 'number' name='codigo' min='1' placeholder='Codigo'/>
        <input type = 'submit' value = 'CREAR'/>
    </form>");
} else {
    $codigo = $_POST['codigo'];
    $carrera = new Carrera($codigo);
    if ($carrera->getValida()) {
        print("
        <h5>RESULTADO OBTENIDO PARA: '$codigo'</h5>
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
        print("<h5>NO SE OBTUVO CARRERA PARA '$codigo'</h5><br>");
    }
    print("<form method='post'>
            <input type = 'submit' value = 'REGRESAR'/>
        </form>");
}

print("
    </body>
</html>");