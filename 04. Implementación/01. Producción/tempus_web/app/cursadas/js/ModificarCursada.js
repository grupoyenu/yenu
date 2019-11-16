/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$(document).ready(function () {

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
                    dia: 5,
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

    $(".editar").click(function (evento) {
        evento.preventDefault();
        var id = $(this).attr("name");
        var dia = $(this).parents("tr").attr('name');
        var inicio = $("#horaInicio" + dia).val();
        var fin = $("#horaFin" + dia).val();
        var aula = $("#aula" + dia).val();
        if ((aula !== null) && (aula !== "NO")) {
            $.ajax({
                type: "POST",
                dataType: 'json',
                url: "./app/cursadas/vistas/ProcesarModificarClase.php",
                data: "idClase=" + id + "&desde=" + inicio + "&hasta=" + fin + "&aula=" + aula,
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
            var mensaje = "Seleccione un aula para modificar la clase";
            var div = "<div class='alert alert-warning text-center' role='alert'>\n\
                        <i class='fas fa-exclamation-circle'></i> <strong>" + mensaje + "</strong></div>";
            $('#seccionResultado').html(div);
        }
        $('html, body').animate({scrollTop: 0}, 1250);
    });

    $('.baja').click(function (evento) {
        evento.preventDefault();
        var idClase = $(this).attr("name");
        $("#modalIdClase").val(idClase);
        $("#modalBorrarClase").modal();
    });

    $("#btnConfirmarEliminacion").click(function (evento) {
        evento.preventDefault();
        $.ajax({
            type: "POST",
            dataType: 'json',
            url: "./app/cursadas/vistas/ProcesarBorrarClase.php",
            data: ("#formBorrarClase").serialize(),
            success: function (data) {
                $('#seccionResultado').html(data[0]['resultado']);
            },
            error: function (data) {
                console.log(data);
                var mensaje = "No se procesó la petición";
                var div = "<div class='alert alert-danger text-center' role='alert'>\n\
                               <i class='fas fa-exclamation-triangle'></i> <strong>" + mensaje + "</strong></div>";
                $('#seccionResultado').html(div);
            }
        });
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

