/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$(document).ready(function () {

    $(".clases").change(function () {
        var dia = $(this).val();
        var checkeado = $(this).prop('checked');
        var disabled = (checkeado) ? false : true;
        $("#horaInicio" + dia).prop("disabled", disabled);
        $("#horaFin" + dia).prop("disabled", disabled);
        $("#aula" + dia).prop("disabled", disabled);
        $("#baja" + dia).prop("disabled", disabled);
        $("#crear" + dia).prop("disabled", disabled);
        $("#editar" + dia).prop("disabled", disabled);
    });

    $(".crear").click(function (evento) {
        evento.preventDefault();
        var dia = $(this).parents("tr").attr('name');
        var codigo = $("#codigo").val();
        var asignatura = $("#idAsignatura").val();
        var inicio = $("#horaInicio" + dia).val();
        var fin = $("#horaFin" + dia).val();
        var aula = $("#aula" + dia).val();
        if ((aula !== null) && (aula !== "NO")) {
            $.ajax({
                type: "POST",
                dataType: 'json',
                url: "./app/cursadas/vistas/ProcesarCrearClase.php",
                data: "codigo=" + codigo + "&idAsignatura=" + asignatura + "&dia=" + dia + "&desde=" + inicio + "&hasta=" + fin + "&aula=" + aula,
                success: function (data) {
                    $('#seccionResultado').html(data[0]['resultado']);
                    $('input[value="' + dia + '"]').prop("disabled", true);
                    $("#horaInicio" + dia).prop("disabled", true);
                    $("#horaFin" + dia).prop("disabled", true);
                    $("#aula" + dia).prop("disabled", true);
                    $(this).prop("disabled", true);
                },
                error: function (data) {
                    console.log(data);
                    var mensaje = "No se procesó la petición";
                    var div = "<div class='alert alert-danger text-center' role='alert'>\n\
                               <i class='fas fa-exclamation-triangle'></i> <strong>" + mensaje + "</strong></div>";
                    $('#seccionResultado').html(div);
                }
            });
        } else {
            var mensaje = "Seleccione un aula para crear la clase";
            var div = "<div class='alert alert-warning text-center' role='alert'>\n\
                        <i class='fas fa-exclamation-circle'></i> <strong>" + mensaje + "</strong></div>";
            $('#seccionResultado').html(div);
        }
        $('html, body').animate({scrollTop: 0}, 1250);
    });

    $('#aula1').select2({
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

    $('#aula2').select2({
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

    $('#aula3').select2({
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

    $('#aula4').select2({
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

    $('#aula5').select2({
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

    $('#aula6').select2({
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

    $('.baja').click(function (evento) {
        evento.preventDefault();
        $("#modalBorrarClase").modal();
    });

    $(".horaInicio").change(function () {
        var dia = $(this).parents("tr").attr("name");
        $('select#aula' + dia).val('').trigger('change');
    });

    $(".horaFin").change(function () {
        var dia = $(this).parents("tr").attr("name");
        $('select#aula' + dia).val('').trigger('change');
    });


});

