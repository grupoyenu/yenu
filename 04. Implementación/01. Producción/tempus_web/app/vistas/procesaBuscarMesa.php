<?php

require_once '../controladores/Autoload.php';
$autoload = new Autoload();
$autoload->autoloadProcesa();

$nombreAsignatura = $_POST['txtAsignatura'];

$controladorMesa = new ControladorMesaExamen();
$mesas = $controladorMesa->buscarMesas($nombreAsignatura);
$llamados = $controladorMesa->obtenerCantidadLlamados();

if (is_null($mesas) || ($llamados == 0)) {
    echo '<div class="alert alert-danger text-center" role="alert">No se pudo realizar la consulta de mesas de examen</div>';
} else {
    if (empty($mesas)) {
        echo '<div class="alert alert-warning text-center" role="alert">No se obtuvieron resultados</div>';
    } else {
        echo '<form id="formProcesaBuscarMesa" name="formProcesaBuscarMesa" method="POST">';
        if ($llamados == 1) {
            echo '
            
                
            <table id="tablaMesasExamen" class="table table-bordered table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th></th>
                        <th class="text-center">Código</th>
                        <th class="text-center" style="display:none;">Carrera</th>
                        <th class="text-center">Asignatura</th>
                        <th class="text-center">Presidente</th>
                        <th class="text-center">Vocal 1</th>
                        <th class="text-center">Vocal 2</th>
                        <th class="text-center">Suplente</th>
                        <th class="text-center">Fecha</th>
                        <th class="text-center">Hora</th>
                        <th class="text-center">Lugar</th>
                    </tr>
                </thead>
                <tbody>';
            foreach($mesas as $mesa) {
                $codigo = $mesa->getPlan()->getCarrera()->getCodigo();
                $nombre = $mesa->getPlan()->getCarrera()->getNombre();
                $asignatura = $mesa->getPlan()->getAsignatura()->getNombre();
                $presidente = $mesa->getTribunal()->getPresidente()->getNombre();
                $vocal1 = $mesa->getTribunal()->getPresidente()->getNombre();
                $primero = $mesa->getLlamados()->getPrimero();
                $fecha = substr($primero->getFecha(), 0, 5);
                echo"<tr>
                        <td class='text-center'><input type='radio' id='radioMesas' name='radioMesas' value='{$mesa->getIdmesa()}'/></td>
                        <td class='text-center' title='{$nombre}'>{$codigo}</td>
                        <td style='display:none;'>{$nombre}</td>
                        <td>{$asignatura}</td>
                        <td>{$presidente}</td>
                        <td>{$vocal1}</td>";
                if($mesa->getTribunal()->getVocal2()) {
                    $vocal2 = $mesa->getTribunal()->getVocal2()->getNombre();
                    $suplente = ($mesa->getTribunal()->getSuplente()) ? $mesa->getTribunal()->getSuplente()->getNombre() : "";
                    echo "<td>{$vocal2}</td>
                          <td>{$suplente}</td>";
                } else {
                    echo "<td></td> <td></td>";
                }
                echo "  <td class='text-center'>{$fecha}</td>
                        <td class='text-center'>{$primero->getHora()}</td>";
                if($primero->getAula()) {
                    echo "<td>{$primero->getAula()->getSector()} {$primero->getAula()->getNombre()}</td>";
                } else {
                     echo "<td>campus</td>";
                }
                echo "
                    </tr>";
            }
            echo '
                </tbody>
            </table>';
        } else {
            echo '
            <table id="tablaMesasExamen" class="table table-bordered table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th>Código</th>
                        <th>Asignatura</th>
                        <th>Presidente</th>
                        <th>Vocal 1</th>
                        <th>Vocal 2</th>
                        <th>Suplente</th>
                        <th>Llamado 1</th>
                        <th>Llamado 2</th>
                        <th>Hora</th>
                        <th>Lugar</th>
                        <th>Borrar</th>
                        <th>Modificar</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                </tbody>
            </table>';
        }
        echo '
        <div class="row">
            <div class="col">
                <div class="text-center">
                    <input type="submit" class="btn btn-danger" id="btnBorrarMesa" name="btnBorrarMesa" value="Borrar">
                    <input type="submit" class="btn btn-success"  id="btnModificarMesa" name="btnModificarMesa" value="Modificar">
                </div>
            </div>
        </div>
        </form>
        <script type="text/javascript" src="./app/js/ProcesaBuscarMesa.js"></script>';
    }
}
