<?php

include_once '../modelos/Conexion.php';

$desde1 = (string) "fila[4]";
$hasta1 = (string) "fila[5]";
$sector1 = (string) "fila[6]";
$aula1 = (string) "fila[7]";

/* Informacion de 2 = Martes */
$desde2 = (string) "fila[8]";
$hasta2 = (string) "fila[9]";
$sector2 = (string) "fila[10]";
$aula2 = (string) "fila[11]";

/* Informacion de 3 = Miercoles */
$desde3 = (string) "fila[12]";
$hasta3 = (string) "fila[13]";
$sector3 = (string) "fila[14]";
$aula3 = (string) "fila[15]";

/* Informacion de 4 = Jueves */
$desde4 = (string) "fila[16]";
$hasta4 = (string) "fila[17]";
$sector4 = (string) "fila[18]";
$aula4 = (string) "fila[19]";

/* Informacion de 5 = Viernes */
$desde5 = (string) "fila[20]";
$hasta5 = (string) "fila[21]";
$sector5 = (string) "fila[22]";
$aula5 = (string) "fila[23]";

/* Informacion de 6 = Sabado */
$desde6 = (string) "fila[24]";
$hasta6 = (string) "fila[25]";
$sector6 = (string) "fila[26]";
$aula6 = (string) "fila[27]";


for ($i = 1; $i < 7; $i++) {
    echo "<br>". ${"desde".$i};
    echo "<br>". ${"hasta".$i};
    echo "<br>". ${"sector".$i};
    echo "<br>". ${"aula".$i};
}



/*
$arreglo = array();
$arreglo[1][16] = array('nombre' => "CUS", 'inicio' => "16:00", 'fin' => "18:00");
$arreglo[1][18] = array('nombre' => "ICC", 'inicio' => "18:00", 'fin' => "20:00");
$arreglo[3][16] = array('nombre' => "CUS", 'inicio' => "16:00", 'fin' => "18:00");
$arreglo[3][18] = array('nombre' => "ICC", 'inicio' => "18:00", 'fin' => "20:00");
$arreglo[4][17] = array('nombre' => "Gestion", 'inicio' => "17:00", 'fin' => "19:00");

echo "
<table border='1'>
    <thead>
        <tr>
            <th></th>
            <th>Lunes</th>
            <th>Martes</th>
            <th>Miercoles</th>
            <th>Jueves</th>
            <th>Viernes</th>
            <th>Sabado</th>
        </tr>
    </thead>   
    <tbody>";
$marca = array();
for ($i = 15; $i < 24; $i++) {
    $hora = $i . ":00";
    echo "<tr> <td>$hora</td>";
    for ($dia = 1; $dia < 7; $dia++) {

        if (isset($arreglo[$dia][$i])) {
            $clase = $arreglo[$dia][$i];
            $desde = substr($clase['inicio'], 0, 2);
            $hasta = substr($clase['fin'], 0, 2);
            $rowspan = $hasta - $desde;
            $td = substr($clase['fin'], 0, 2);
            for ($j = $desde; $j < $hasta; $j++) {
                $marca[$dia][$j] = "true";
            }
            echo "fsd";
            echo "<td rowspan='{$rowspan}'> {$rowspan} {$desde} {$clase['nombre']} {$clase['inicio']} {$clase['fin']} </td>";
        } else {
            if (!isset($marca[$dia][$i])) {
                echo "<td></td>";
            } 
        }
    }
    echo "</tr>";
}
echo "
    </tbody>
</table>";

echo "dfffs:";
for ($j = 16; $j <2; $j++) {
    echo "EMANUEL";
}


echo "
<table >
    <thead>
        <tr>
            <th>Lunes</th>
            <th>Martes</th>
            <th>Miercoles</th>
            <th>Jueves</th>
            <th>Viernes</th>
            <th>Sabado</th>
        </tr>
    </thead>   
    <tbody>";

for ($i = 15; $i < 24; $i++) {

    $hora = $i . ":00";
    echo "<tr>";
    for ($dia = 1; $dia < 7; $dia++) {
        if (isset($arreglo[$dia][$i])) {
            $clase = $arreglo[$dia][$i];
            $rowspan = substr($clase['fin'], 0, 2) - substr($clase['inicio'], 0, 2);
            echo "<td>{$clase['nombre']} {$clase['inicio']} {$clase['fin']} </td>";
        } else {
            echo "<td></td>";
        }
    }
    echo "</tr>";
}
echo "
    </tbody>
</table>";


echo "<pre>";
var_dump($arreglo);
echo "</pre>";


$arreglo = NULL;



if(!empty($arreglo)) {
    echo "<br> NO ES NULO";
}
echo "<br>RETORNAR";


$dias = array();
$dias[2]= "eeee";
var_dump($dias);


$r = isset($v) ?: 'No Value';

echo "<br>".$r;


$inicio = "12:50";
$fin = "12:40";


$horaInicio = substr($inicio, 0, 2);
$horaFin = substr($fin, 0, 2);

echo $inicio." < ".$fin.": ";
if ($horaInicio < $horaFin) {
    echo "true";
} else {
    if ($horaInicio == $horaFin) {
        $minutosInicio = substr($inicio, 3, 2);
        $minutosFin = substr($fin, 3, 2);
        echo ($minutosInicio < $minutosFin) ? "true" : "false";
    }
    return "false";
}

 */