/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$(document).ready(function () {

    $('#btnModificarCursada').click(function (evento) {
        evento.preventDefault();
        $.ajax({
            type: "POST",
            dataType: 'json',
            url: "./ProcesarModificarCursada.php",
            data: $("#formModificarCursada").serialize(),
            success: function (data) {
                $('#seccionResultado').html(data[0]['resultado']);
                if (data[0]['exito'] === true) {
                    $('#formModificarCursada').find('input, textarea, select').prop('disabled', true);
                    $('select#plan').val('').trigger('change');
                    $('.aula').val('').trigger('change');
                }
            },
            error: function (data) {
                console.log(data);
                var men = "<i class='fas fa-exclamation-triangle'><strong>No se procesó la petición</strong></i>";
                var div = '<div class="alert alert-danger text-center" role="alert">' + men + '</div>';
                $('#seccionResultado').html(div);
            },
            complete: function () {
                $('html, body').animate({scrollTop: 0}, 1250);
            }
        });
    });

    $("#btnConfirmarEliminacion").click(function (evento) {
        evento.preventDefault();
        alert("PETICION AJAX 3");
        $.ajax({
            type: "POST",
            dataType: 'json',
            url: "./ProcesarBorrarClase.php",
            data: $("#formModificarCursada").serialize(),
            success: function (data) {
                $('#seccionResultado').html(data[0]['resultado']);
                if (data[0]['exito'] === true) {
                    $('#formModificarCursada').find('input, textarea, select').prop('disabled', true);
                    $('select#plan').val('').trigger('change');
                    $('.aula').val('').trigger('change');
                }
            },
            error: function (data) {
                console.log(data);
                var men = "<i class='fas fa-exclamation-triangle'><strong>No se procesó la petición</strong></i>";
                var div = '<div class="alert alert-danger text-center" role="alert">' + men + '</div>';
                $('#seccionResultado').html(div);
            },
            complete: function () {
                $('html, body').animate({scrollTop: 0}, 1250);
            }
        });
    });

    $(".borrarClases").change(function () {
        var checkeado = $(this).prop('checked');
        var disabled = (checkeado) ? false : true;
        $("#btnBorrarClases").prop("disabled", disabled);
    });

    $('#btnBorrarClases').click(function (evento) {
        evento.preventDefault();
        $("#modalBorrarClase").modal();
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

    $('#aula1').select2({
        placeholder: 'Seleccione una opcion',
        theme: "bootstrap",
        minimumInputLength: 1,
        language: "es",
        allowClear: true,
        width: '100%',
        ajax: {
            url: "../../aula/vista/ProcesarSeleccionarAulaDisponible.php",
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
        language: "es",
        allowClear: true,
        width: '100%',
        ajax: {
            url: "../../aula/vista/ProcesarSeleccionarAulaDisponible.php",
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
        language: "es",
        allowClear: true,
        width: '100%',
        ajax: {
            url: "../../aula/vista/ProcesarSeleccionarAulaDisponible.php",
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
        language: "es",
        allowClear: true,
        width: '100%',
        ajax: {
            url: "../../aula/vista/ProcesarSeleccionarAulaDisponible.php",
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
        language: "es",
        allowClear: true,
        width: '100%',
        ajax: {
            url: "../../aula/vista/ProcesarSeleccionarAulaDisponible.php",
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
        language: "es",
        allowClear: true,
        width: '100%',
        ajax: {
            url: "../../aula/vista/ProcesarSeleccionarAulaDisponible.php",
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

});

