<?php
include_once '../../../lib/conf/Conexion.php';
include_once '../../modelos/Rol.php';
print("
<html lang='es'>
    <meta charset='UTF-8'>
    <body style='background-color: #e2e3e5'>
    <h3>PRUEBA BUSCAR PERMISOS - CLASE ROL.PHP</h3>");

if (!isset($_POST['idrol'])) {
    print("
    <form method='post'>
        <label>Identificador de rol:</label>
        <input type = 'number' name='idrol' min='1' placeholder='Identificador'/>
        <input type = 'submit' value = 'BUSCAR PERMISOS'/>
    </form>
    <br><br>
    <a href='../indexTest.php'>IR AL MENU DE OPCIONES</a>");
} else {
    $idrol = $_POST['idrol'];
    $rol = new Rol($idrol);
    $rows = $rol->buscarPermisos();
    if (empty($rows)) {
        if($rol->getDescripcion()) {
            print("<h5>ROL INVALIDO: {$rol->getDescripcion()}</h5><br>");
        } else {
            print("<h5>NO SE ENCONTRARON RESULTADOS</h5><br>");
        }
    } else {
        print("
        <h5>RESULTADO OBTENIDO PARA: '$idrol'</h5>
        <table border='1'>
            <thead>
                <tr>
                    <th>Identificador</th>
                    <th>Nombre</th>
                </tr>
            </thead>
            <tbody>");
        foreach ($rows as $key => $permiso) {
            print("
            <tr>
                <td>{$permiso['idpermiso']}</td>
                <td>{$permiso['nombre']}</td>
            </tr>");
        }    
        print("</tbody>
        </table><br>");
    }
    print("<form method='post'>
            <input type = 'submit' value = 'REGRESAR'/>
        </form>");
}

print("
    </body>
</html>");