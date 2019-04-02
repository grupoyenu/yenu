<?php
include_once '../../../lib/conf/Conexion.php';
include_once '../../modelos/Rol.php';
print("
<html lang='es'>
    <meta charset='UTF-8'>
    <body style='background-color: #e2e3e5'>
    <h3>PRUEBA CONSTRUCT - CLASE ROL.PHP</h3>");

if (!isset($_POST['idrol'])) {
    print("
    <form method='post'>
        <label>Identificador de rol:</label>
        <input type = 'number' name='idrol' min='1' placeholder='Identificador'/>
        <input type = 'submit' value = 'CONSTRUCT'/>
    </form>
    <br><br>
    <a href='../indexTest.php'>IR AL MENU DE OPCIONES</a>");
} else {
    $idrol = $_POST['idrol'];
    $rol = new Rol($idrol);
    if ($rol->getEstado()) {
        print("
        <h5>RESULTADO OBTENIDO PARA: '$idrol'</h5>
        <table border='1'>
            <thead>
                <tr>
                    <th>Identificador</th>
                    <th>Nombre</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{$rol->getIdrol()}</td>
                    <td>{$rol->getNombre()}</td>
                </tr>
            </tbody>
        </table><br>");
    } else {
        print("<h5>NO SE OBTUVO ROL PARA '$idrol'</h5><br>");
    }
    print("<form method='post'>
            <input type = 'submit' value = 'REGRESAR'/>
        </form>");
}

print("
    </body>
</html>");