<?php

echo '<div class="container">
    <h4 class="text-center p-4">IMPORTAR HORARIOS DE CURSADA</h4>
    <div id="resultado"></div>
    <div id="contenido">
        <form id="formCrearUsuario" name="formCrearUsuario" method="POST">';

$mensaje = Utilidades::validarArchivoCursadas();

if (isset($mensaje)) {
    echo '<div class="alert alert-danger text-center" role="alert">' . $mensaje . '</div>';
} else {
    $nombre_temporal = $_FILES['fileCursadas']['tmp_name'];
    $cursadas = fopen($nombre_temporal, "r");
    rewind($cursadas);
    $sesioncursadas = array();
    echo '
    <table id="tablaImportarCursadas" class="display">
        <thead>
            <tr>
                <th>Código</th>
                <th>Carrera</th>
                <th>Asignatura</th>
                <th>Año</th>
                <th>Lunes</th>
                <th>Martes</th>
                <th>Miercoles</th>
                <th>Jueves</th>
                <th>Viernes</th>
                <th>Sábado</th>
            </tr>
        </thead>
        <tbody>';
    while (($fila = fgetcsv($cursadas, 2000, ";")) !== FALSE) {
        $agregar = TRUE;

        $codigo = (int) $fila[0];
        $carrera = (string) $fila[1];
        $asignatura = (string) $fila[2];
        $anio = (int) $fila[3];

        /* Informacion de 1 = Lunes */
        $desde1 = (string) $fila[4];
        $hasta1 = (string) $fila[5];
        $sector1 = (string) $fila[6];
        $aula1 = (string) $fila[7];

        /* Informacion de 2 = Martes */
        $desde2 = (string) $fila[8];
        $hasta2 = (string) $fila[9];
        $sector2 = (string) $fila[10];
        $aula2 = (string) $fila[11];

        /* Informacion de 3 = Miercoles */
        $desde3 = (string) $fila[12];
        $hasta3 = (string) $fila[13];
        $sector3 = (string) $fila[14];
        $aula3 = (string) $fila[15];

        /* Informacion de 4 = Jueves */
        $desde4 = (string) $fila[16];
        $hasta4 = (string) $fila[17];
        $sector4 = (string) $fila[18];
        $aula4 = (string) $fila[19];

        /* Informacion de 5 = Viernes */
        $desde5 = (string) $fila[20];
        $hasta5 = (string) $fila[21];
        $sector5 = (string) $fila[22];
        $aula5 = (string) $fila[23];

        /* Informacion de 6 = Sabado */
        $desde6 = (string) $fila[24];
        $hasta6 = (string) $fila[25];
        $sector6 = (string) $fila[26];
        $aula6 = (string) $fila[27];

        $mensaje = Utilidades::cursadasDuplicadas($sesioncursadas, $asignatura, $codigo);
        $agregar = ($mensaje) ? false : $agregar;
        echo "<tr {$mensaje}>";

        $mensaje = Utilidades::formatoCodigoCarrera($codigo);
        $agregar = ($mensaje) ? false : $agregar;
        echo "<td {$mensaje}>$codigo</td>";

        $mensaje = Utilidades::formatoNombreCarrera($carrera);
        $agregar = ($mensaje) ? false : $agregar;
        echo "<td {$mensaje}>$carrera</td>";

        $mensaje = Utilidades::formatoNombreAsignatura($asignatura);
        $agregar = ($mensaje) ? false : $agregar;
        echo "<td {$mensaje}>$asignatura</td>";

        $mensaje = Utilidades::formatoAnio($anio);
        $agregar = ($mensaje) ? false : $agregar;
        echo "<td {$mensaje}>$anio</td>";

        for ($i = 1; $i < 7; $i++) {
            $desde = ${"desde" . $i};
            $hasta = ${"hasta" . $i};
            $sector = ${"sector" . $i};
            $aula = ${"aula" . $i};
            if ($desde || $hasta || $sector || $aula) {
                $mensaje = Utilidades::formatoHora($desde);
                $agregar = ($mensaje) ? false : $agregar;
                if (!$mensaje) {
                    $mensaje = Utilidades::formatoHora($hasta);
                    $agregar = ($mensaje) ? false : $agregar;
                    if (!$mensaje) {
                        $mensaje = Utilidades::formatoNombreSector($sector);
                        $agregar = ($mensaje) ? false : $agregar;
                        if (!$mensaje) {
                            $mensaje = Utilidades::formatoNombreAula($aula);
                            $agregar = ($mensaje) ? false : $agregar;
                        }
                    }
                }
                $clase = $desde . " " . $hasta . " " . $sector . " " . $aula;
                echo "<td {$mensaje}>$clase</td>";
            } else {
                echo "<td></td>";
            }
        }

        echo "</tr>";
    }
    echo '
            </tbody>
        </table>';
}

echo '  </form>
    </div>  
</div>
<script type="text/javascript" src="./app/js/ImportarCursada.js"></script>';
