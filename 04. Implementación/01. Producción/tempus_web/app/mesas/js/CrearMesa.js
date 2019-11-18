/** 
 * Controla los eventos del archivo FormCrearMesa.php y realiza las validaciones
 * correspondientes antes que el formulario se envie al servidor. Se comunica a
 * traves de AJAX con el archivo procesaCrearMesa.php. Como resultado de la 
 * operacion recibe un arreglo JSON con un booleano y mensaje. 
 * 
 * @author Oyarzo Mariela 
 * @author Quiroga Sandra
 * @author Marquez Emanuel
 */
$(document).ready(function () {

    /* Captura el formulario antes de su envio y realiza solicitud AJAX */

    $('#formCrearMesa').submit(function (evento) {
        evento.preventDefault();
        if (verificarTribunal()) {
            $.ajax({
                type: "POST",
                dataType: 'json',
                url: "./app/mesas/vistas/ProcesarCrearMesa.php",
                data: $("#formCrearMesa").serialize(),
                success: function (data) {
                    $('#seccionResultado').html(data[0]['resultado']);
                    if (data[0]['exito'] === true) {
                        $("select#carrera").val('').trigger('change');
                        $("select#asignatura").val('').trigger('change');
                        $("select#presidente").val('').trigger('change');
                        $("select#vocal1").val('').trigger('change');
                        $("select#vocal2").val('').trigger('change');
                        $("select#suplente").val('').trigger('change');
                        $("select#aula1").val('').trigger('change');
                        $("select#aula2").val('').trigger('change');
                        $("#formCrearMesa")[0].reset();
                    }
                    $('html, body').animate({scrollTop: 0}, 1250);
                },
                error: function (data) {
                    console.log(data);
                    var mensaje = "<i class='fas fa-exclamation-triangle'></i> <strong>No se procesó la petición</strong>";
                    $('#seccionResultado').html("<div class='alert alert-danger text-center' role='alert'>" + mensaje + "</div>");
                    $('html, body').animate({scrollTop: 0}, 1250);
                }
            });
        } else {
            var mensaje = "<i class='fas fa-exclamation-circle'></i> <strong>Se detectaron docentes duplicados</strong>";
            $('#seccionResultado').html("<div class='alert alert-warning text-center' role='alert'>" + mensaje + "</div>");
            $('html, body').animate({scrollTop: 0}, 1250);
        }
    });

    $('select#carrera').select2({
        placeholder: 'Seleccione una opcion',
        theme: "bootstrap",
        minimumInputLength: 1,
        ajax: {
            url: "./app/carreras/vistas/ProcesarSeleccionarCarreraSinMesa.php",
            dataType: 'json',
            type: "POST",
            delay: 250,
            data: function (params) {
                return {nombre: params.term};
            },
            processResults: function (data) {
                return {results: data};
            },
            cache: true
        }
    });

    $('select#asignatura').select2({
        placeholder: 'Seleccione una opcion',
        theme: "bootstrap",
        minimumInputLength: 1,
        ajax: {
            url: "./app/asignaturas/vistas/ProcesarSeleccionarAsignaturaSinMesa.php",
            dataType: 'json',
            type: "POST",
            delay: 250,
            data: function (params) {
                return {nombre: params.term, codigo: $("select#carrera").val()};
            },
            processResults: function (data) {
                return {results: data};
            },
            cache: true
        }
    });

    $('select#presidente').select2({
        placeholder: 'Seleccione una opcion',
        theme: "bootstrap",
        ajax: {
            url: "./app/docentes/vistas/ProcesarSeleccionarDocente.php",
            dataType: 'json',
            type: "POST",
            delay: 250,
            data: function (params) {
                return {nombre: params.term};
            },
            processResults: function (data) {
                return {results: data};
            },
            cache: true
        }
    });

    $('select#vocal1').select2({
        placeholder: 'Seleccione una opcion',
        theme: "bootstrap",
        ajax: {
            url: "./app/docentes/vistas/ProcesarSeleccionarDocente.php",
            dataType: 'json',
            type: "POST",
            delay: 250,
            data: function (params) {
                return {nombre: params.term};
            },
            processResults: function (data) {
                return {results: data};
            },
            cache: true
        }
    });

    $('select#vocal2').select2({
        placeholder: 'Seleccione una opcion',
        theme: "bootstrap",
        ajax: {
            url: "./app/docentes/vistas/ProcesarSeleccionarDocente.php",
            dataType: 'json',
            type: "POST",
            delay: 250,
            data: function (params) {
                return {nombre: params.term};
            },
            processResults: function (data) {
                return {results: data};
            },
            cache: true
        }
    });

    $('select#suplente').select2({
        placeholder: 'Seleccione una opcion',
        theme: "bootstrap",
        ajax: {
            url: "./app/docentes/vistas/ProcesarSeleccionarDocente.php",
            dataType: 'json',
            type: "POST",
            delay: 250,
            data: function (params) {
                return {nombre: params.term};
            },
            processResults: function (data) {
                return {results: data};
            },
            cache: true
        }
    });

    $('select#aula1').select2({
        placeholder: 'Seleccione una opcion',
        theme: "bootstrap",
        ajax: {
            url: "./app/aulas/vistas/ProcesarSeleccionarAula.php",
            dataType: 'json',
            type: "POST",
            delay: 250,
            data: function (params) {
                return {nombre: params.term};
            },
            processResults: function (data) {
                return {results: data};
            },
            cache: true
        }
    });

    $("select#carrera").change(function () {
        var carrera = $(this).val();
        var habilitar = ((carrera !== null) && (carrera !== "NO")) ? false : true;
        $("select#asignatura").prop("disabled", habilitar);
    });

    $("select#presidente").change(function () {
        var presidente = $(this).val();
        if ((presidente !== null) && (presidente !== "NO")) {
            $("select#vocal1").prop("disabled", false);
        } else {
            $("select#vocal1").val('').trigger('change');
            $("select#vocal1").prop("disabled", true);
        }
    });

    $("select#vocal1").change(function () {
        var vocal1 = $(this).val();
        if ((vocal1 !== null) && (vocal1 !== "NO")) {
            $("select#vocal2").prop("disabled", false);
        } else {
            $("select#vocal2").val('').trigger('change');
            $("select#vocal2").prop("disabled", true);
        }
    });

    $("select#vocal2").change(function () {
        var vocal2 = $(this).val();
        if ((vocal2 !== null) && (vocal2 !== "NO")) {
            $("select#suplente").val('').trigger('change');
            $("select#suplente").prop("disabled", false);
        } else {
            $("select#suplente").prop("disabled", true);
        }
    });

    function verificarTribunal() {
        var presidente = $("select#presidente").val();
        var vocal1 = $("select#vocal1").val();
        var vocal2 = $("select#vocal2").val();
        var suplente = $("select#suplente").val();
        if ((presidente === vocal1) || (presidente === vocal2) || (presidente === suplente)) {
            return false;
        }
        if ((vocal2 !== null) && (vocal1 === vocal2)) {
            return false;
        }
        if ((suplente !== null) && (suplente === vocal2)) {
            return false;
        }
        return true;
    }

});


