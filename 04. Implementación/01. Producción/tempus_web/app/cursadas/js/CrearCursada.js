/** 
 * Controla los eventos del archivo FormCrearCursada.php y realiza las validaciones
 * correspondientes antes que el formulario se envie al servidor. Se comunica a
 * traves de AJAX con el archivo procesaCrearCursada.php. Como resultado de la 
 * operacion recibe un arreglo JSON con un booleano y mensaje. Tambien controla
 * los eventos para el modal de planes y modal de aulas.
 * 
 * @author Oyarzo Mariela 
 * @author Quiroga Sandra
 * @author Marquez Emanuel
 */
$(document).ready(function () {

    /* Captura el formulario antes de su envio y realiza solicitud AJAX */

    $('#formCrearCursada').submit(function (evento) {
        evento.preventDefault();
        $.ajax({
            type: "POST",
            dataType: 'json',
            url: "./app/cursadas/vistas/ProcesarCrearCursada.php",
            data: $("#formCrearCursada").serialize(),
            success: function (data) {
                $('#seccionResultado').html(data[0]['resultado']);
                if (data[0]['exito'] === true) {
                    $("#formCrearCursada")[0].reset();
                    $('select#carrera').val('').trigger('change');
                    $('select#asignatura').val('').trigger('change');
                    $('.aula').val('').trigger('change');
                }
            },
            error: function (data) {
                console.log(data);
                $('#seccionResultado').html("<div class='alert alert-danger text-center' role='alert'><i class='fas fa-exclamation-triangle'></i> <strong>No se procesó la petición</strong></div>");
            }
        });
        $('html, body').animate({scrollTop: 0}, 1250);
    });

    $('select#carrera').select2({
        placeholder: 'Seleccione una opcion',
        theme: "bootstrap",
        minimumInputLength: 1,
        ajax: {
            url: "./app/carreras/vistas/ProcesarSeleccionarCarreraSinCursada.php",
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
            url: "./app/asignaturas/vistas/ProcesarSeleccionarAsignaturaSinCursada.php",
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

    $('select#aula1').select2({
        placeholder: 'Seleccione una opcion',
        theme: "bootstrap",
        minimumInputLength: 1,
        ajax: {
            url: "./app/aulas/vistas/ProcesarSeleccionarAulaDisponible.php",
            dataType: 'json',
            type: "POST",
            delay: 250,
            data: function (params) {
                return {
                    dia: 1,
                    desde: $("#horaInicio1").val(),
                    hasta: $("#horaFin1").val(),
                    nombre: params.term};
            },
            processResults: function (data) {
                return {results: data};
            },
            cache: true
        }
    });

    $('select#aula2').select2({
        placeholder: 'Seleccione una opcion',
        theme: "bootstrap",
        minimumInputLength: 1,
        ajax: {
            url: "./app/aulas/vistas/ProcesarSeleccionarAulaDisponible.php",
            dataType: 'json',
            type: "POST",
            delay: 250,
            data: function (params) {
                return {
                    dia: 2,
                    desde: $("#horaInicio2").val(),
                    hasta: $("#horaFin2").val(),
                    nombre: params.term};
            },
            processResults: function (data) {
                return {results: data};
            },
            cache: true
        }
    });

    $('select#aula3').select2({
        placeholder: 'Seleccione una opcion',
        theme: "bootstrap",
        minimumInputLength: 1,
        ajax: {
            url: "./app/aulas/vistas/ProcesarSeleccionarAulaDisponible.php",
            dataType: 'json',
            type: "POST",
            delay: 250,
            data: function (params) {
                return {
                    dia: 3,
                    desde: $("#horaInicio3").val(),
                    hasta: $("#horaFin3").val(),
                    nombre: params.term};
            },
            processResults: function (data) {
                return {results: data};
            },
            cache: true
        }
    });

    $('select#aula4').select2({
        placeholder: 'Seleccione una opcion',
        theme: "bootstrap",
        minimumInputLength: 1,
        ajax: {
            url: "./app/aulas/vistas/ProcesarSeleccionarAulaDisponible.php",
            dataType: 'json',
            type: "POST",
            delay: 250,
            data: function (params) {
                return {
                    dia: 4,
                    desde: $("#horaInicio4").val(),
                    hasta: $("#horaFin4").val(),
                    nombre: params.term};
            },
            processResults: function (data) {
                return {results: data};
            },
            cache: true
        }
    });

    $('select#aula5').select2({
        placeholder: 'Seleccione una opcion',
        theme: "bootstrap",
        minimumInputLength: 1,
        ajax: {
            url: "./app/aulas/vistas/ProcesarSeleccionarAulaDisponible.php",
            dataType: 'json',
            type: "POST",
            delay: 250,
            data: function (params) {
                return {
                    dia: 1,
                    desde: $("#horaInicio5").val(),
                    hasta: $("#horaFin5").val(),
                    nombre: params.term};
            },
            processResults: function (data) {
                return {results: data};
            },
            cache: true
        }
    });

    $('select#aula6').select2({
        placeholder: 'Seleccione una opcion',
        theme: "bootstrap",
        minimumInputLength: 1,
        ajax: {
            url: "./app/aulas/vistas/ProcesarSeleccionarAulaDisponible.php",
            dataType: 'json',
            type: "POST",
            delay: 250,
            data: function (params) {
                return {
                    dia: 6,
                    desde: $("#horaInicio6").val(),
                    hasta: $("#horaFin6").val(),
                    nombre: params.term};
            },
            processResults: function (data) {
                return {results: data};
            },
            cache: true
        }
    });

    $(".clases").change(function () {
        var dia = $(this).val();
        var checkeado = $(this).prop('checked');
        var disabled = (checkeado) ? false : true;
        $("#horaInicio" + dia).prop("disabled", disabled);
        $("#horaFin" + dia).prop("disabled", disabled);
        $("#aula" + dia).prop("disabled", disabled);
    });

    $("select#carrera").change(function () {
        var carrera = $(this).val();
        var habilitar = ((carrera !== null) && (carrera !== "NO")) ? false : true;
        $("select#asignatura").prop("disabled", habilitar);
    });

    $(".horaInicio").change(function () {
        var dia = $(this).parents("tr").attr("name");
        var hora = $(this).val().substring(0, 2);
        $('select#aula' + dia).val('').trigger('change');
        for (var i = 10; i < 24; i++) {
            if (i <= hora) {
                $("#horaFin" + dia).find("option[value='" + i + ":00']").attr("disabled", "disabled");
                $("#horaFin" + dia).find("option[value='" + i + ":30']").attr("disabled", "disabled");
            } else {
                $("#horaFin" + dia).find("option[value='" + i + ":00']").removeAttr("disabled");
                $("#horaFin" + dia).find("option[value='" + i + ":30']").removeAttr("disabled");
            }
        }
    });

    $(".horaFin").change(function () {
        var dia = $(this).parents("tr").attr("name");
        $('select#aula' + dia).val('').trigger('change');
    });

});