<?php

include_once '../../modelos/Conexion.php';
include_once '../../modelos/Mesa.php';
include_once '../../modelos/Utilidades.php';
include_once '../../modelos/Plan.php';
include_once '../../modelos/Asignatura.php';
include_once '../../modelos/Carrera.php';
include_once '../../modelos/Tribunal.php';
include_once '../../modelos/Docente.php';
include_once '../../modelos/Aula.php';
include_once '../../modelos/Llamado.php';

echo "
<html lang='es'>
    <meta charset='UTF-8'>
    <body style='background-color: #e2e3e5'>
    <h3>PRUEBA CONSTRUCT - CLASE MESA.PHP</h3>";
if (!isset($_POST['enviado'])) {
    echo "
    <form method='post'>
        <input type='hidden' name='enviado' value='true'/>
        <table>
            <tr>
                <td>Identificador de asignatura:</td>
                <td><input type='number' name='idAsignatura' min='1' placeholder='Identificador de asignatura'/></td>
            </tr>
            <tr>
                <td>Codigo de carrera:</td>
                <td><input type='number' name='codigo' min='1' placeholder='Codigo de carrera'/></td>
            </tr>
        </table>
        <input type='submit' value = 'BUSCAR'/>
    </form>";
} else {
    $idasignatura = $_POST['idAsignatura'];
    $codigo = $_POST['codigo'];
    $plan = new Plan($idasignatura, $codigo);
    if ($plan->getEstado()) {
        $mesa = new Mesa();
        $mesa->setPlan($plan);
        $buscar = $mesa->buscar();
        switch ($buscar) {
            case 0:
                echo "<h5 style='color:red'>{$mesa->getDescripcion()}<br>";
                break;
            case 1:
                echo "<h5>No se encontraron resultados<br>";
                break;
            case 2:
                echo "<h5 style='color:green'>{$mesa->getDescripcion()}<br>";
                break;
        }
    } else {
        echo "<h5>PLAN INVALIDO</h5><br>";
    }
    echo "<form method='post'>
            <input type = 'submit' value = 'REGRESAR'/>
        </form>";
}
echo "
    </body>
</html>";
