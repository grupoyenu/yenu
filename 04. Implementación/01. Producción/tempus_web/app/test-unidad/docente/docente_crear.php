<?php

header("Content-Type: text/html;charset=iso-8859-1");
include_once '../../modelos/Conexion.php';
include_once '../../modelos/Utilidades.php';
include_once '../../modelos/Docente.php';

echo "
<html lang='es'>
    <body style='background-color: #e2e3e5'>
    <h3>CLASE DOCENTE.PHP</h3>
    <table border='1'>
        <thead>
            <tr>
                <th>METODO</th>
                <th>PARAMETROS</th>
                <th>DESCRIPCION</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Crear</td>
                <td>Nombre:string</td>
                <td>Crea un docente y lo guarda en la BD</td>
            </tr>
        </tbody>
    </table><br><br>";
if (!isset($_POST['nombre'])) {
    echo"
    <form method='post'>
         <table>
            <tr>
                <td><label>Nombre de docente:</label><td>
                <td><input type='text' name='nombre'><td>
            </tr>
        </table>
        <input type = 'submit' value = 'CREAR DOCENTE'/>
    </form>
    <br><br>";
} else {
    $nombre = $_POST['nombre'];
    $docente = new Docente();
    $docente->constructor($nombre);
    $creacion = $docente->crear();

    echo "<h5>RESULTADO OBTENIDO PARA: '$nombre'</h5>";
    switch ($creacion) {
        case 0:
            echo "<h5 style='color: orange;'> Descripcion: {$docente->getDescripcion()}</h5><br>";
            break;
        case 1:
            echo "<h5 style='color: red;'> Descripcion: {$docente->getDescripcion()}</h5><br>";
            break;
        case 2:
            echo "<h5 style='color: green;'> Descripcion: {$docente->getDescripcion()}</h5><br>";
            break;
        case 3:
            echo "<h5 style='color: orange;'> Descripcion: {$docente->getDescripcion()}</h5><br>";
            break;
        default :
            echo "<h5 style='color: red;'> Default</h5><br>";
            break;
    }
    echo"<form method='post'>
            <input type = 'submit' value = 'REGRESAR'/>
        </form>";
}
echo"
    <table>
        <tr>
            <td><a href='menu_docente.php'>PROBAR OTRO METODO</a><td>
            <td><a href='../indexTest.php'>PROBAR OTRA CLASE</a><td>
        </tr>
    </table>";
echo "
    </body>
</html>";
