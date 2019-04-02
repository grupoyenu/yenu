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
        <input type = 'number' name='codigo' min='1' placeholder='Codigo'/>
        <input type = 'text' name='nombre' placeholder='Nombre'/>
        <input type = 'submit' value = 'CREAR'/>
    </form>");
} else {
    $codigo = $_POST['codigo'];
    $nombre = $_POST['nombre'];
    $carrera = new Carrera();
    $carrera->constructor($codigo, $nombre);
    $creacion = $carrera->crear();
    
    if (is_bool($creacion) && $creacion) {
        print("<h5 style='color:green;'>RESULTADO OBTENIDO: '{$carrera->getDescripcion()}'</h5>");
    } else {
        if (is_bool($creacion) && $creacion == false) {
            print("<h5 style='color:red;'>RESULTADO OBTENIDO: '{$carrera->getDescripcion()}'</h5>");
        } else {
            $creacion = $creacion[0];
            print("
            <h5 style='color:orange;'>RESULTADO OBTENIDO PARA: '{$carrera->getDescripcion()}'</h5>
            <table border='1'>
                <thead>
                    <tr>
                        <th>Codigo</th>
                        <th>Nombre</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{$creacion['codigo']}</td>
                        <td>{$creacion['nombre']}</td>
                    </tr>
                </tbody>
            </table><br>");
        }
    }
    print("<form method='post'>
            <input type = 'submit' value = 'REGRESAR'/>
        </form>");
}

print("
    </body>
</html>");
