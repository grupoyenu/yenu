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

if (!isset($_POST['idmesa'])) {
    echo "
    <form method='post'>
        <table>
            <tr>
                <th><label>Identificador de mesa:</label></th>
                <th><input type = 'number' name='idmesa' min='1' placeholder='Identificador de mesa'/></th>
            </tr>
        </table>
        <input type = 'submit' value = 'CONSTRUCT'/>
    </form>";
} else {
    $idmesa = $_POST['idmesa'];
    $mesa = new Mesa($idmesa);
    if ($mesa->getEstado()) {
        echo "
        <h5>RESULTADO PARA: '$idmesa'</h5>
        <table border='1'>
            <thead>
                <tr>
                    <th>Identificador mesa</th>
                    <th>Codigo de carrera</th>
                    <th>Nombre de carrera</th>
                    <th>Identificador asignatura</th>
                    <th>Nombre asignatura</th>
                    <th>Identificador tribunal</th>
                    <th>Presidente</th>
                    <th>Vocal 1</th>
                    <th>Vocal 2</th>
                    <th>Suplente</th>
                    <th>Identificador primero</th>
                    <th>Fecha</th>
                    <th>Hora</th>
                    <th>Aula</th>
                    <th>Identificador segundo</th>
                    <th>Fecha</th>
                    <th>Hora</th>
                    <th>Aula</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{$mesa->getIdmesa()}</td>
                    <td>{$mesa->getPlan()->getCarrera()->getCodigo()}</td>
                    <td>{$mesa->getPlan()->getCarrera()->getNombre()}</td>
                    <td>{$mesa->getPlan()->getAsignatura()->getIdasignatura()}</td>
                    <td>{$mesa->getPlan()->getAsignatura()->getNombre()}</td>
                    <td>{$mesa->getTribunal()->getIdtribunal()}</td>
                    <td>{$mesa->getTribunal()->getPresidente()->getNombre()}</td>
                    <td>{$mesa->getTribunal()->getVocal1()->getNombre()}</td>";
        if ($mesa->getTribunal()->getVocal1()) {
            echo "  <td>{$mesa->getTribunal()->getVocal2()->getNombre()}</td>";
            if ($mesa->getTribunal()->getSuplente()->getNombre()) {
                echo "<td>{$mesa->getTribunal()->getSuplente()->getNombre()}</td>";
            } else {
                echo "<td></td>";
            }
        } else {
            echo "  <td></td> <td></td>";
        }
        if ($mesa->getPrimero()) {
            echo "  <td>{$mesa->getPrimero()->getIdllamado()}</td>
                    <td>{$mesa->getPrimero()->getFecha()}</td>
                    <td>{$mesa->getPrimero()->getHora()}</td>";
            if ($mesa->getPrimero()->getAula()) {
                echo "<td>{$mesa->getPrimero()->getAula()->getSector()} {$mesa->getPrimero()->getAula()->getNombre()}</td>";
                
            } else {
                echo "<td>CAMPUS</td>";
            }
        } else {
            echo "  <td></td>
                    <td></td>
                    <td></td>
                    <td></td>";
        }
        if ($mesa->getSegundo()) {
            echo "  <td>{$mesa->getSegundo()->getIdllamado()}</td>
                    <td>{$mesa->getSegundo()->getFecha()}</td>
                    <td>{$mesa->getSegundo()->getHora()}</td>";
            if ($mesa->getSegundo()->getAula()) {
                echo "<td>{$mesa->getSegundo()->getAula()->getSector()} {$mesa->getSegundo()->getAula()->getNombre()}</td>";
            } else {
                echo "<td>CAMPUS</td>";
            }
        } else {
            echo "  
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>";
        }
        echo " 
                </tr>
            </tbody>
        </table><br>";
    } else {
        echo "<h5>NO SE OBTUVO RESULTADO</h5><br>";
    }
    echo "<form method='post'>
            <input type = 'submit' value = 'REGRESAR'/>
        </form>";
}
echo "
    </body>
</html>";
