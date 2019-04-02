<?php
$controladorPlan = new ControladorPlan();
$controladorAula = new ControladorAula();
$docente = new Docente();

$planes = $controladorPlan->buscarPlanes();
$aulas = $controladorAula->buscarAulas();
$docentes = $docente->buscarDocentes();
?>

<div class="container">
    <h4 class="text-center p-4">CREAR MESA DE EXAMEN</h4>
    <div id="resultado"></div>
    <div id="contenido">
        <?php
        if (is_null($planes) || empty($planes)) {
            $mensaje = "No se obtuvieron carreras para cargar el formulario. Verifique que exista al menos una carrera";
            echo '<div class="alert alert-danger text-center" role="alert">' . $mensaje . '</div>';
        } else {

            if (is_null($aulas) || empty($aulas)) {
                $mensaje = "No se obtuvieron aulas para cargar el formulario. Verifique que exista al menos un aula";
                echo '<div class="alert alert-danger text-center" role="alert">' . $mensaje . '</div>';
            } else {

                if (is_null($docentes) || empty($docentes)) {
                    $mensaje = "No se obtuvieron docentes para cargar el formulario. Verifique que exista al menos un docente";
                    echo '<div class="alert alert-danger text-center" role="alert">' . $mensaje . '</div>';
                } else {

                    date_default_timezone_set('America/Argentina/Buenos_Aires');
                    $hoy = date("Y-m-d");

                    /* Fecha minima del segundo llamado (fecha actual mas 7 dias) */
                    $fechaminima = strtotime('+7 days', strtotime($hoy));
                    $fechaminima = date("Y-m-d", $fechaminima);

                    /* Fecha maxima del segundo llamado (fecha actual mas 1 anio) */
                    $fechamaxima = strtotime('+1 year', strtotime($hoy));
                    $fechamaxima = date("Y-m-d", $fechamaxima);

                    echo '
                    <form id="formCrearMesa" name="formCrearMesa" method="POST">
                        <fieldset class="border p-2">
                            <legend class="w-auto h6">Información de plan</legend>
                            <div class="form-row">
                                <label for="nombreCarrera" class="col-sm-2 col-form-label">* Nombre de carrera:</label>
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
                            <legend class="w-auto h6">Información del tribunal</legend>
                            <div class="form-row">
                                <label for="" class="col-sm-2 col-form-label">* Presidente:</label>
                                <div class="col">
                                    <input type="hidden" id="idPresidente" name="idPresidente">
                                    <input type="text" class="form-control mb-2"
                                           id="nombrePresidente" name="nombrePresidente"
                                           placeholder="Nombre del presidente" 
                                           title="Nombre del docente con rol de presidente" readonly required>
                                </div>
                                <div class="col-xs-3">
                                    <button type="button" id="buscarPresidente" name="buscarPresidente"  class="btn  btn-outline-info">
                                        <img src="./lib/img/tempus_seleccionar.png" width="20" height="20"/>
                                    </button>
                                </div>
                                <label for="" class="col-sm-2 col-form-label">* Vocal 1:</label>
                                <div class="col">
                                    <input type="hidden" id="idVocal1" name="idVocal1">
                                    <input type="text" class="form-control mb-2"
                                           id="nombreVocal1" name="nombreVocal1"
                                           placeholder="Nombre del vocal primero" 
                                           title="Nombre del docente con rol de vocal primero" readonly required> 
                                </div>
                                <div class="col-xs-3">
                                    <button type="button" id="buscarVocal1" name="buscarVocal1" class="btn  btn-outline-info">
                                        <img src="./lib/img/tempus_seleccionar.png" width="20" height="20"/>
                                    </button>
                                </div>
                                <div class="w-100"></div>
                                <label for="" class="col-sm-2 col-form-label"> Vocal 2:</label>
                                <div class="col">
                                    <input type="hidden" id="idVocal2" name="idVocal2">
                                    <input type="text" class="form-control mb-2"
                                            id="nombreVocal2" name="nombreVocal2"
                                            placeholder="Nombre del vocal segundo" 
                                            title="Nombre del docente con rol de vocal segundo" readonly>
                                </div>
                                <div class="col-xs-3">
                                    <button type="button" id="buscarVocal2" name="buscarVocal2" class="btn  btn-outline-info">
                                        <img src="./lib/img/tempus_seleccionar.png" width="20" height="20"/>
                                    </button>
                                </div>
                                <label for="" class="col-sm-2 col-form-label"> Suplente:</label>
                                <div class="col">
                                    <input type="hidden" id="idSuplente" name="idSuplente">
                                    <input type="text" class="form-control mb-2" 
                                           id="nombreSuplente" name="nombreSuplente"
                                           placeholder="Nombre del docente suplente" 
                                           title="Nombre del docente con rol de suplente" readonly>
                                </div>
                                <div class="col-xs-3">
                                    <button type="button" id="buscarSuplente" name="buscarSuplente" class="btn  btn-outline-info">
                                        <img src="./lib/img/tempus_seleccionar.png" width="20" height="20"/>
                                    </button>
                                </div>
                            </div>
                        </fieldset>
                        <br>
                        <fieldset class="border p-2">
                            <legend class="w-auto h6">Información de llamado</legend>
                            <div class="form-group row">
                                <label for="" class="col-sm-2 col-form-label" title="Campo obligatorio">* Fecha:</label>
                                <div class="col">
                                    <input type="date" class="form-control mb-2"
                                           id="primerLlamado" name="primerLlamado"
                                           value="' . $hoy . '" min="' . $hoy . '" max="' . $fechamaxima . '"
                                           title="Fecha del primer llamado"
                                           required>
                                </div>
                                <label for="" class="col-sm-2 col-form-label" title="Campo obligatorio">* Hora:</label>
                                <div class="col">
                                    <select class="form-control mb-2" name="selectHora" id="selectHora" title="Hora del primer llamado">';

                    for ($hora = 10; $hora < 23; ++$hora) {
                        echo "<option value='{$hora}:00'>{$hora}:00 hs</option>";
                    }
                    echo'           </select>
                                </div>
                            </div>
                        </fieldset>
                        <br>
                        <fieldset class="border p-2">
                            <legend class="w-auto h6">Información de lugar</legend>
                            <div  class="form-row">
                                <input type="hidden" id="idAula" name="idAula">
                                <label for="nombreSector" class="col-sm-2 col-form-label" title="Campo obligatorio">* Nombre de sector:</label>
                                <div class="col">
                                    <input type="text" class="form-control mb-2"
                                           id="nombreSector" name="nombreSector"
                                           placeholder="Nombre del sector" 
                                           title="Nombre del sector" readonly required>
                                </div>
                                <label for="nombreAula" class="col-sm-2 col-form-label" title="Campo obligatorio">Nombre de aula:</label>
                                <div class="col">
                                    <input type="text" class="form-control mb-2"
                                           id="nombreAula" name="nombreAula"
                                           placeholder="Nombre del aula" 
                                           title="Nombre de aula" readonly required>
                                </div>
                                <div class="col-xs-3">
                                    <button type="button" class="btn  btn-outline-info" 
                                            id="buscarAula" name="buscarAula" 
                                            title="Seleccionar un aula">
                                        <img src="./lib/img/tempus_seleccionar.png" width="20" height="20"/>
                                    </button>
                                </div>
                            </div>
                        </fieldset>
                        <div class="form-row"> 
                            <div class="col text-center p-4">
                                <input class="btn btn-success" type="submit" value="Crear">
                            </div>
                        </div>
                    </form>';
                }
            }
        }
        ?>
    </div>
</div>
<?php
include_once './app/vistas/ModalPlanes.php';
include_once './app/vistas/ModalDocentes.php';
include_once './app/vistas/ModalAulas.php';
?>
<script type="text/javascript" src="./app/js/CrearMesa.js"></script>