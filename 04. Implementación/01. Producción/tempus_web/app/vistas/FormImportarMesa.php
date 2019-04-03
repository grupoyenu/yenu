<?php

echo '<div class="container">
    <h4 class="text-center p-4">IMPORTAR MESAS DE EXAMEN</h4>
    <div id="resultado"></div>
    <div id="contenido">
        <form id="formCrearUsuario" name="formCrearUsuario" method="POST">';

$mensaje = Utilidades::validarArchivoMesas();
if (isset($mensaje)) {
    echo '<div class="alert alert-danger text-center" role="alert">' . $mensaje . '</div>';
} else {
    $nombre_temporal = $_FILES['fileMesas']['tmp_name'];
    $mesas = fopen($nombre_temporal, "r");
    $fila = fgetcsv($mesas, 2000, ";");
    $columnas = count($fila);
    rewind($mesas);
    $sesionmesas = array();
    if ($columnas == 10) {
        echo '
        <table id="tablaImportarMesas" class="table table-bordered table-hover">
            <thead class="thead-dark">
                <tr>
                    <th>Código</th>
                    <th>Carrera</th>
                    <th>Asignatura</th>
                    <th>Presidente</th>
                    <th>Vocal1</th>
                    <th>Vocal2</th>
                    <th>Suplente</th>
                    <th>Llamado 1</th>
                    <th>Llamado 2</th>
                    <th>Hora</th>
                </tr>
            </thead>
            <tbody>';
        while (($fila = fgetcsv($mesas, 2000, ";")) !== FALSE) {
            /* Para saber si agregar la fila al array en sesion */
            $agregar = TRUE;

            /* Obtiene cada una de las columnas */
            $codigo = (int) $fila[0];
            $carrera = (string) $fila[1];
            $asignatura = (string) $fila[2];
            $presidente = (string) $fila[3];
            $vocal1 = (string) $fila[4];
            $vocal2 = (string) $fila[5];
            $suplente = (string) $fila[6];
            $primero = (string) $fila[7];
            $segundo = (string) $fila[8];
            $hora = (string) $fila[9];

            $mensaje = Utilidades::mesasDuplicadas($sesionmesas, $asignatura, $codigo);
            $agregar = ($mensaje) ? false : true;
            echo "<tr {$mensaje}>";

            $mensaje = Utilidades::formatoCodigoCarrera($codigo);
            $agregar = ($mensaje) ? false : true;
            echo "<td {$mensaje}>$codigo</td>";

            $mensaje = Utilidades::formatoNombreCarrera($carrera);
            $agregar = ($mensaje) ? false : $agregar;
            echo "<td {$mensaje}>$carrera</td>";

            $mensaje = Utilidades::formatoNombreAsignatura($asignatura);
            $agregar = ($mensaje) ? false : $agregar;
            echo "<td {$mensaje}>$asignatura</td>";

            $mensaje = Utilidades::formatoNombreDocenteObligatorio($presidente);
            $agregar = ($mensaje) ? false : $agregar;
            echo "<td {$mensaje}>$presidente</td>";

            $mensaje = Utilidades::formatoNombreDocenteObligatorio($vocal1);
            $agregar = ($mensaje) ? false : $agregar;
            echo "<td {$mensaje}>$vocal1</td>";

            $mensaje = Utilidades::formatoNombreDocenteNoObligatorio($vocal2);
            $agregar = ($mensaje) ? false : $agregar;
            echo "<td {$mensaje}>$vocal2</td>";

            $mensaje = Utilidades::formatoNombreDocenteNoObligatorio($suplente);
            $agregar = ($mensaje) ? false : $agregar;
            echo "<td {$mensaje}>$suplente</td>";

            $mensaje = Utilidades::formatoFechaObligatorio($primero);
            $agregar = ($mensaje) ? false : $agregar;
            echo "<td {$mensaje}>$primero</td>";

            $mensaje = Utilidades::formatoHora($hora);
            $agregar = ($mensaje) ? false : $agregar;
            echo "<td {$mensaje}>$hora</td>";

            if ($agregar) {
                $primero = str_replace('/', '-', $primero);
                $primero = date('Y-m-d', strtotime($primero));
                $sesionmesas [] = array($codigo, $carrera, $asignatura, $presidente, $vocal1, $vocal2, $suplente, $primero, $hora);
            }

            echo "</tr>";
        }
        echo '
            </tbody>
        </table>';
    } else {
        echo '
        <table id="tablaImportarMesas" class="table table-bordered table-hover">
            <thead class="thead-dark">
                <tr>
                    <th class="text-center">Codigo</th>
                    <th class="text-center">Carrera</th>
                    <th class="text-center">Asignatura</th>
                    <th class="text-center">Presidente</th>
                    <th class="text-center">Vocal 1</th>
                    <th class="text-center">Vocal 2</th>
                    <th class="text-center">Suplente</th>
                    <th class="text-center">Fecha</th>
                    <th class="text-center">Hora</th>
                </tr>
            </thead>
            <tbody>';
        $sesionmesas = array();
        while (($fila = fgetcsv($mesas, 2000, ";")) !== FALSE) {
            /* Para saber si agregar la fila al array en sesion */
            $agregar = TRUE;

            /* Obtiene cada una de las columnas */
            $codigo = (int) $fila[0];
            $carrera = (string) $fila[1];
            $asignatura = (string) $fila[2];
            $presidente = (string) $fila[3];
            $vocal1 = (string) $fila[4];
            $vocal2 = (string) $fila[5];
            $suplente = (string) $fila[6];
            $primero = (string) $fila[7];
            $hora = (string) $fila[8];

            $mensaje = Utilidades::mesasDuplicadas($sesionmesas, $asignatura, $codigo);
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

            $mensaje = Utilidades::validarTribunal($presidente, $vocal1, $vocal2, $suplente);
            if ($mensaje) {
                $agregar = false;
                echo "<td {$mensaje}>$presidente</td>";
                echo "<td {$mensaje}>$vocal1</td>";
                echo "<td {$mensaje}>$vocal2</td>";
                echo "<td {$mensaje}>$suplente</td>";
            } else {
                $mensaje = Utilidades::formatoNombreDocenteObligatorio($presidente);
                $agregar = ($mensaje) ? false : $agregar;
                echo "<td {$mensaje}>$presidente</td>";

                $mensaje = Utilidades::formatoNombreDocenteObligatorio($vocal1);
                $agregar = ($mensaje) ? false : $agregar;
                echo "<td {$mensaje}>$vocal1</td>";

                $mensaje = Utilidades::formatoNombreDocenteNoObligatorio($vocal2);
                $agregar = ($mensaje) ? false : $agregar;
                echo "<td {$mensaje}>$vocal2</td>";

                $mensaje = Utilidades::formatoNombreDocenteNoObligatorio($suplente);
                $agregar = ($mensaje) ? false : $agregar;
                echo "<td {$mensaje}>$suplente</td>";
            }

            $mensaje = Utilidades::formatoFechaObligatorio($primero);
            $agregar = ($mensaje) ? false : $agregar;
            echo "<td {$mensaje}>$primero</td>";

            $mensaje = Utilidades::formatoHora($hora);
            $agregar = ($mensaje) ? false : $agregar;
            echo "<td {$mensaje}>$hora</td>";

            if ($agregar) {
                $primero = str_replace('/', '-', $primero);
                $primero = date('Y-m-d', strtotime($primero));
                $sesionmesas [] = array($codigo, $carrera, $asignatura, $presidente, $vocal1, $vocal2, $suplente, $primero, $hora);
            }

            echo "</tr>";
        }
        echo '
            </tbody>
        </table>';
    }
    if (count($sesionmesas) > 0) {
        echo '
        <div class="form-row"> 
            <div class="col text-center p-4">
                <input type="submit" class="btn btn-success" 
                       id="btnImportarMesa" name="btnImportarMesa" 
                       title="Confirmar la importación del archivo con mesas de examen"
                       value="Seleccionar">
                <a href="home"><input type="button" class="btn btn-outline-secondary" 
                       title="Cancelar la importación del archivo con mesas de examen"
                       value="Cancelar"></a>
            </div>
        </div>';
    }
}

echo '  </form>
    </div>  
</div>
<script type="text/javascript" src="./app/js/ImportarMesa.js"></script>';
