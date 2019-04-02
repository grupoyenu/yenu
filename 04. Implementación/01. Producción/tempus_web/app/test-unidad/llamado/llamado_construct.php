<?php
include_once '../../modelos/Conexion.php';
include_once '../../modelos/Llamado.php';
include_once '../../modelos/Aula.php';

echo "
<html lang='es'>
    <meta charset='UTF-8'>
    <body style='background-color: #e2e3e5'>
    <h3>PRUEBA CONSTRUCT - CLASE LLAMADO.PHP</h3>";

if (!isset($_POST['idllamado'])) {
    echo "
    <form method='post'>
        <table>
            <tr>
                <td>Identificador de llamado:</td>
                <td><input type = 'number' name='idllamado' min='1' placeholder='Identificador llamado'/></td>
            </tr>
            <tr>
                <td></td>
                <td><input type = 'submit' value = 'CONSTRUCT'/></td>
            </tr>
        </table>
    </form>
    <table>
        <tr>
            <td><a href='menu_llamado.php'>MENU DE LLAMADO</a><td>
            <td><a href='../indexTest.php'>MENU GENERAL</a><td>
        </tr>
    </table>";
} else {
    $idllamado = $_POST['idllamado'];
    $llamado = new Llamado($idllamado);
    if ($llamado->getEstado()) {
        echo "
        <h5>RESULTADO OBTENIDO PARA: '$idllamado'</h5>
        <table border='1'>
            <thead>
                <tr>
                    <th>Identificador</th>
                    <th>Fecha</th>
                    <th>Hora</th>
                    <th>Aula</th>
                    <th>Fecha mod</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{$llamado->getIdllamado()}</td>
                    <td>{$llamado->getFecha()}</td>
                    <td>{$llamado->getHora()}</td>";
        if($llamado->getAula()) {
            echo "  <td>{$llamado->getAula()->getSector()} {$llamado->getAula()->getNombre()}</td>";
        } else {
            echo "  <td></td>";
        }
        echo "      <td>{$llamado->getFechamod()}</td>         
                </tr>
            </tbody>
        </table><br>";
    } else {
        echo "<h5>NO SE OBTUVIERON RESULTADOS</h5><br>";
    }
    echo 
    "<form method='post'>
        <input type = 'submit' value = 'REGRESAR'/>
    </form>";
}
echo "
    </body>
</html>";
