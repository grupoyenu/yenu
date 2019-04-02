<?php

header("Content-Type: text/html;charset=iso-8859-1");
include_once '../../modelos/Conexion.php';
include_once '../../modelos/Utilidades.php';
include_once '../../modelos/Plan.php';
include_once '../../modelos/Carrera.php';
include_once '../../modelos/Asignatura.php';

echo "
<html lang='es'>
    <body style='background-color: #e2e3e5'>
    <h3>CLASE PLAN.PHP</h3>
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
                <td>Asignatura:asignatura, Carrea:carrera</td>
                <td>Valida la asignatura y carrera antes de setear atributos</td>
            </tr>
        </tbody>
    </table><br><br>";

if (!isset($_POST['asignatura']) && !isset($_POST['codigo']) && !isset($_POST['carrera']) && !isset($_POST['anio'])) {
    echo"
    <form method='post'>
         <table>
            <tr>
                <td><label>Nombre de asignatura:</label><td>
                <td><input type='text' name='asignatura'><td>
            </tr>
            <tr>
                <td><label>Codigo de carrera:</label><td>
                <td><input type='number' name='codigo'><td>
            </tr>
            <tr>
                <td><label>Nombre de carrera:</label><td>
                <td><input type='text' name='carrera'><td>
            </tr>
            <tr>
                <td><label>Anio:</label><td>
                <td><input type='number' name='anio'><td>
            </tr>
        </table>
        <input type = 'submit' value = 'CREAR PLAN'/>
    </form>
    <br><br>
    <table>
        <tr>
            <td><a href='menu_plan.php'>PROBAR OTRO METODO</a><td>
            <td><a href='../indexTest.php'>PROBAR OTRA CLASE</a><td>
        </tr>
    </table>";
} else {
    $nombreAsignatura = $_POST['asignatura'];
    $codigo = $_POST['codigo'];
    $nombreCarrera = $_POST['carrera'];
    $anio = $_POST['anio'];

    $asignatura = new Asignatura();
    $asignatura->constructor($nombreAsignatura);

    echo "<h5>RESULTADO OBTENIDO PARA: '$nombreAsignatura - $codigo - $nombreCarrera'</h5>";
    if ($asignatura->getEstado()) {
        $carrera = new Carrera();
        $carrera->constructor($codigo, $nombreCarrera);
        if ($carrera->getEstado()) {
            $plan = new Plan();
            $plan->constructor($asignatura, $carrera, $anio);
            
            if ($plan->getEstado()) {
                
                $creacion = $plan->crear();
                switch ($creacion){
                    case 1:
                        echo "<h5 style='color: orange;'> Descripcion: {$plan->getDescripcion()}</h5><br>";
                        break;
                    case 2:
                        echo "<h5 style='color: red;'> Descripcion: {$plan->getDescripcion()}</h5><br>";
                        break;
                    case 3:
                        echo "<h5 style='color: green;'> Descripcion: {$plan->getDescripcion()}</h5><br>";
                        break;
                    default :
                        echo "<h5 style='color: red;'> Default</h5><br>";
                        break;
                }
               
            } else {
                echo "<h5 style='color: red;'> Descripcion: {$plan->getDescripcion()}</h5><br>";
            }
        } else {
            echo "<h5 style='color: red;'>Descripcion: {$carrera->getDescripcion()}</h5><br>";
        }
    } else {
        echo "<h5 style='color: red;'>Descripcion: {$asignatura->getDescripcion()}</h5><br>";
    }
    echo"<form method='post'>
            <input type = 'submit' value = 'REGRESAR'/>
        </form>";
}
echo "
    </body>
</html>";


