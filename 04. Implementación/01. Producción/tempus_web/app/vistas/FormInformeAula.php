<?php
echo '<h4 class="text-center p-4">INFORME AULA</h4>';
if (isset($_POST['idaula'])) {
    /* SE RECIBE LA INFORMACION DESDE EL FORMULARIO  */

    require_once '../controladores/Autoload.php';
    $autoload = new Autoload();
    $autoload->autoloadProcesa();

    $idaula = $_POST['idaula'];

    $controladorAula = new ControladorAula();
    $rows = $controladorAula->informe($idaula);

    if (is_null($rows)) {
        echo '<div class="alert alert-danger text-center" role="alert">No se pudo realizar la consulta de horarios</div>';
    } else {
        if (empty($rows)) {
            echo '<div class="alert alert-warning text-center" role="alert">No se obtuvieron resultados</div>';
        } else {
            echo "
            <table id='tablaInformeAula' class='table table-bordered table-hover'>
                <thead class='thead-dark'>
                    <tr>
                        <th>Hora</th>
                        <th class='text-center'>Lunes</th>
                        <th class='text-center'>Martes</th>
                        <th class='text-center'>Miercoles</th>
                        <th class='text-center'>Jueves</th>
                        <th class='text-center'>Viernes</th>
                        <th class='text-center'>Sábado</th>
                    </tr>
                </thead>   
                <tbody>";
            $marca = array();
            for ($i = 10; $i < 24; $i++) {
                $hora = $i . ":00";
                echo "<tr> 
                            <td>$hora</td>";
                for ($dia = 1; $dia < 7; $dia++) {
                    if (isset($rows[$dia][$i])) {
                        $clase = $rows[$dia][$i];
                        $desde = substr($clase['inicio'], 0, 2);
                        $hasta = substr($clase['fin'], 0, 2);
                        $rowspan = $hasta - $desde;
                        for ($j = $desde; $j < $hasta; $j++) {
                            $marca[$dia][$j] = "true";
                        }
                        echo "<td class='text-center' rowspan='{$rowspan}'>{$clase['nombre']} {$clase['inicio']} {$clase['fin']} </td>";
                    } else {
                        if (!isset($marca[$dia][$i])) {
                            echo "<td></td>";
                        }
                    }
                }
                echo "</tr>";
            }
        }
    }
} else {
    /* NO SE RECIBE LA INFORMACION DESDE EL FORMULARIO  */
    $mensaje = "No se obtuvieron los datos del formulario de búsqueda";
    echo '<div class="alert alert-danger text-center" role="alert">' . $mensaje . '</div>';
}
?>

<script type="text/javascript" src="./app/js/InformeAula.js"></script>