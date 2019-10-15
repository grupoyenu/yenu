<?php
if (isset($_POST['codigo'])) {
    $codigo = $_POST['codigo'];
    $controlador = new ControladorAsignaturas();
    $rows = $controlador->buscarPorCarrera($codigo, FALSE);
    if (!empty($rows)) {
        /* CARGA TODAS LAS ASIGNATURAS QUE NO PERTENECEN A LA CARRERA */
        $campo = '
            <input name="asignatura" id="asignatura" placeholder="Nombre de asignatura" class="form-control mb-2" list="asignaturas" autocomplete="off">
            <datalist id="asignaturas">';
        foreach ($rows as $asignatura) {
            $campo .= "<option data-id='{$asignatura['idasignatura']}' value='{$asignatura['nombre']}'>{$asignatura['nombre']}</option>";
        }
        $campo .= "</datalist>";
    } else {
        $campo = '<input type="text" class="form-control mb-2" name="asignatura" id="asignatura" placeholder="Nombre de asignatura">';
    }
    $formulario = '
        <form name="formAgregarAsignatura" id="formAgregarAsignatura" method="POST">
            <input type="hidden" name="idasignatura" id="idasignatura">
            <input type="hidden" name="carrera" id="carrera" value="' . $codigo . '">
            <div class="card text-center">
                <div class="card-header text-left">' . str_pad($codigo, 3, "0", STR_PAD_LEFT) . ': Complete el formulario y presione CREAR</div>
                <div class="card-body">
                    <div class="form-row">
                        <label for="nombre" class="col-sm-2 col-form-label text-left">* Nombre:</label>
                        <div class="col">' . $campo . '</div>
                        <label for="nombre" class="col-sm-2 col-form-label text-left">* Año:</label>
                        <div class="col">
                            <select class="form-control mb-2" id="anio" name="anio" title="Seleccione año">
                                <option value="1">1°</option>
                                <option value="2">2°</option>
                                <option value="3">3°</option>
                                <option value="4">4°</option>
                                <option value="5">5°</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-row text-left mt-4 mb-4">
                <div class="col text-center">
                    <input type="submit" id="btnBuscarCarrera" name="btnBuscarCarrera" class="btn btn-success" value="Crear">
                </div>
            </div>
        </form>';
} else {
    $formulario = '
        <div class="card text-center">
            <div class="card-header text-left">Sobre la carga del formulario</div>
            <div class="card-body">
                <div class="alert alert-danger text-center" role="alert"><strong>No se obtuvo la información desde el formulario de búsqueda</strong></div>
            </div>
        </div>';
}
?>

<div class="container-fluid" id="FormBuscarAsignatura">
    <div id="seccionSuperior" class="container mt-2 mb-2">
        <div class="row mt-sm-3 mb-4">
            <div class="col align-middle">
                <h3>AGREGAR ASIGNATURA</h3>
            </div>
            <div class="col text-right">
                <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                    <a class="btn btn-outline-info" href="carrera_buscar" title="Regresar"><img src="./lib/img/corner-up-left.svg"/></a>
                    <a class="btn btn-outline-danger" href="principal_home" title="Cancelar"><img data-feather="x-circle"/></a>
                </div>
            </div>
        </div>
    </div>
    <div id="seccionCentral" class="container mt-2 mb-2"></div>
    <div id="seccionInferior" class="container mt-2 mb-2"><?php echo $formulario; ?></div>
</div>
<script type="text/javascript" src="./app/carreras/js/AgregarAsignatura.js"></script>