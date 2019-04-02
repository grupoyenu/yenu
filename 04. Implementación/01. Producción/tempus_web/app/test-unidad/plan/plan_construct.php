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
                <td>Construct</td>
                <td>Idasignatura:int, Codigo:int</td>
                <td>Cuando se indican los identificadores se busca la informacion del plan en la BD</td>
            </tr>
        </tbody>
    </table><br><br>";
    
if (!isset($_POST['idasignatura']) && !isset($_POST['codigo'])) {
    echo"
    <form method='post'>
         <table>
            <tr>
                <td><label>Identificador de asignatura:</label><td>
                <td><input type='number' name='idasignatura'><td>
            </tr>
            <tr>
                <td><label>Codigo de carrera:</label><td>
                <td><input type='number' name='codigo'><td>
            </tr>
        </table>
        <input type = 'submit' value = 'CONSTRUCT'/>
    </form>
    <br><br>
    <table>
        <tr>
            <td><a href='menu_plan.php'>PROBAR OTRO METODO</a><td>
            <td><a href='../indexTest.php'>PROBAR OTRA CLASE</a><td>
        </tr>
    </table>";
} else {
    $idasignatura = $_POST['idasignatura'];
    $codigo = $_POST['codigo'];
    $plan = new Plan($idasignatura, $codigo);
    echo "<h5>RESULTADO OBTENIDO PARA: '$idasignatura - $codigo'</h5>";
    if ($plan->getEstado()) {
        
        print ("
        <table border='1'>
            <thead>
                <tr>
                    <th>Id Asignatura</th>
                    <th>Nombre Asignatura</th>
                    <th>Codigo Carrera</th>
                    <th>Nombre Carrera</th>
                    <th>Anio</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{$plan->getAsignatura()->getIdasignatura()}</td>
                    <td>{$plan->getAsignatura()->getNombre()}</td>
                    <td>{$plan->getCarrera()->getCodigo()}</td>
                    <td>{$plan->getCarrera()->getNombre()}</td>
                    <td>{$plan->getAnio()}</td>
                </tr>
            </tbody>
        </table>
        <br>");
        echo $plan->getAsignatura()->getDescripcion();
    } else {
        echo "<h5>NO SE OBTUVO PLAN</h5><br>";
    }
    echo"<form method='post'>
            <input type = 'submit' value = 'REGRESAR'/>
        </form>";
}
echo "
    </body>
</html>";