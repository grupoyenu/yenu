<?php

/*
 * Este archivo se encarga de obtener los datos enviados por AJAX del formulario
 * y comunicarse con el Controlador Cursada para realizar la busqueda de cursadas.
 * 
 * Origen: FormBuscarCursada.php
 * JS:     BuscarCursada.js
 */

require_once '../controladores/Autoload.php';
$autoload = new Autoload();
$autoload->autoloadProcesa();

$nombreAsignatura = $_POST['txtAsignatura'];

$controladorCursada = new ControladorCursada();
$cursadas = $controladorCursada->buscar($nombreAsignatura);

if (!empty($cursadas)) {
    echo '<form id="formProcesaBuscarCursada" name="formProcesaBuscarCursada" method="POST">
        
        <br><table id="tablaCursadas" class="table table-bordered table-hover">
            <thead class="thead-dark">
                <tr>	
                    <th></th>
                    <th class="text-center">Carrera</th>
                    <th class="text-center">Asignatura</th>
                    <th class="text-center">Lunes</th>
                    <th class="text-center">Martes</th>
                    <th class="text-center">Miercoles</th>
                    <th class="text-center">Jueves</th>
                    <th class="text-center">Viernes</th>
                    <th class="text-center">Sabado</th>
                </tr>
            </thead>
            <tbody>';
    foreach ($cursadas as $cursada) {
        $clases = $cursada->getClases();
        echo "<tr>
                <td><input type='radio' id='radioCursadas' name='radioCursadas' value=''></td>
                <td>{$cursada->getPlan()->getCarrera()->getNombre()}</td>
                <td>{$cursada->getPlan()->getAsignatura()->getNombre()}</td>";
        for ($i = 1; $i < 7; $i++) {
            if (isset($clases[$i])) {
                $aula = $clases[$i]->getAula();
                $dia = $clases[$i]->getDesde() . " a " . $clases[$i]->getHasta() . " " . $aula->getSector() . " " . $aula->getNombre();
                echo "<td class='text-center'>{$dia}</td>";
            } else {
                echo "<td></td>";
            }
        }
    }
    echo'       </tbody>
	</table>
        <div class="row">
            <div class="col">
                <div class="text-center p-4">
                    <input type="submit" class="btn btn-danger" id="btnBorrarCursada" name="btnBorrarCursada" value="Borrar">
                    <input type="submit" class="btn btn-success"  id="btnModificarCursada" name="btnModificarCursada" value="Modificar">
                </div>
            </div>
        </div>
    </form>
    <script type="text/javascript" src="./app/js/ProcesaBuscarCursada.js"></script>';
} else {
    if (is_null($cursadas)) {
        echo '<div class="alert alert-danger text-center" role="alert">No se pudo realizar la consulta de cursadas</div>';
    } else {
        echo '<div class="alert alert-warning text-center" role="alert">No se obtuvieron resultados</div>';
    }
}