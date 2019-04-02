<?php
$controladorPlan = new ControladorPlan();
$controladorAula = new ControladorAula();

$planes = $controladorPlan->buscarPlanes();
$aulas = $controladorAula->buscarAulas();
?>
<div class="container">
    <h4 class="text-center p-4">CREAR HORARIO DE CURSADA</h4>
    <div id="resultado"></div>
    <div id="contenido">
        <form method="POST" id="formCrearCursada" name="formCrearCursada">
            <?php
            if (is_null($planes) || empty($planes)) {
                $mensaje = "No se obtuvieron carreras para cargar el formulario. Verifique que exista al menos una carrera";
                echo '<div class="alert alert-danger text-center" role="alert">' . $mensaje . '</div>';
            } else {

                if (is_null($aulas) || empty($aulas)) {
                    $mensaje = "No se obtuvieron aulas para cargar el formulario. Verifique que exista al menos un aula";
                    echo '<div class="alert alert-danger text-center" role="alert">' . $mensaje . '</div>';
                } else {


                    echo '
                    <form id="formCrearCursada" name="formCrearCursada" metod="POST">
                        <fieldset class="border p-2">
                            <legend class="w-auto h6">Información de plan</legend>
                            <div class="form-row">
                                <label for="nombreCarrera" class="col-sm-2 col-form-label">Nombre de carrera:</label>
                                <div class="col">
                                    <input type="hidden" id="codigoCarrera" name="codigoCarrera">
                                    <input type="text" class="form-control mb-2" 
                                           id="nombreCarrera" name="nombreCarrera" 
                                           placeholder="Nombre de carrera" 
                                           title="Nombre de la carrera" readonly required>
                                </div>
                                <label for="nombreAsignatura" class="col-sm-2 col-form-label">Nombre de asignatura:</label>
                                <div class="col">
                                    <input type="hidden" id="idAsignatura" name="idAsignatura">
                                    <input type="text" class="form-control mb-2" 
                                               id="nombreAsignatura" name="nombreAsignatura" 
                                               placeholder="Nombre de asignatura" 
                                               title="Nombre de la asignatura" readonly required>
                                </div>
                                <div class="col-xs-3 text-right">
                                    <button type="button" id="seleccionarPlan" name="seleccionarPlan" class="btn btn-outline-info" title="Seleccionar una asignatura">
                                        <img src="./lib/img/tempus_seleccionar.png" width="20" height="20"/>
                                    </button>
                                </div>
                            </div>
                        </fieldset>
                        <br>
                        <fieldset class="border p-2">
                            <legend class="w-auto h6">Horarios de clase</legend>';
                    for ($i = 1; $i < 7; ++$i) {
                        $dia = Utilidades::nombreDeDia($i);
                        echo'<div class="form-row">
                                <label class="col-sm-1 col-form-label">' . $dia . '</label>
                                <div class="p-2">
                                    <input type="checkbox" class="clases" id="clases" name="cbClases[]" value="' . $i . '">
                                </div>
                                <div class="col">
                                    <select class="form-control mb-2" id="inicio' . $i . '" name="inicio' . $i . '" disabled>';
                        for ($horainicio = 10; $horainicio < 23; ++$horainicio) {
                            echo "<option value='{$horainicio}:00'>{$horainicio}:00 hs</option>";
                            echo "<option value='{$horainicio}:30'>{$horainicio}:30 hs</option>";
                        }
                        echo '      </select>
                            </div>
                            <div class="col">
                                <select class="form-control mb-2" id="fin' . $i . '" name="fin' . $i . '" disabled>';
                        for ($horafin = 11; $horafin < 24; ++$horafin) {
                            echo "<option value='{$horafin}:00'>{$horafin}:00 hs</option>";
                            echo "<option value='{$horafin}:30'>{$horafin}:30 hs</option>";
                        }
                        echo '  </select>
                            </div>
                            <div class="col">
                                <input type="hidden" id="idaula' .$i . '" name="idaula' . $i . '">
                                <input type="text" class="form-control mb-2" 
                                       id="nombreSector' . $i . '" name="nombreSector' . $i . '" 
                                       placeholder="Sector" 
                                       title="Nombre del sector" readonly>
                            </div>
                            <div class="col">
                                <input type="text" class="form-control mb-2" 
                                       id="nombreAula' . $i . '" name="nombreAula' .$i . '" 
                                       placeholder="Nombre de aula" 
                                       title="Nombre del aula" readonly>
                            </div>
                            <div class="col-xs-3 text-right">
                                <button type="button" class="btn btn-outline-info" 
                                        id="seleccionarAula' . $i . '" name="seleccionarAula' . $i . '" 
                                        title="Seleccionar una asignatura" disabled>
                                    <img src="./lib/img/tempus_seleccionar.png" width="20" height="20"/>
                                </button>
                            </div>
                        </div>';
                    }

                    echo '</fieldset>
                        <div class="row">
                            <div class="col">
                                <div class="text-center">
                                    <br><input class="btn btn-success" type="submit" id="btnCrearCursada" name="btnCrearCursada" value="Crear">
                                </div>
                            </div>
                        </div>
                    </form>';
                }
            }
            ?>
        </form>
    </div>
</div>

</div>
<?php
include_once './app/vistas/ModalPlanes.php';
include_once './app/vistas/ModalAulas.php';
?>
<script type="text/javascript" src="./app/js/CrearCursada.js"></script>