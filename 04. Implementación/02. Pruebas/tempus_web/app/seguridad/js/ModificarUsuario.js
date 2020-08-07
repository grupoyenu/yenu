/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).ready(function () {

    var formOriginal = $("#formModificarUsuario").serialize();

    $("#formModificarUsuario").change(function () {
        var formModificado = $("#formModificarUsuario").serialize();
        var habilitar = (formOriginal !== formModificado) ? false : true;
        $("#btnModificarUsuario").prop("disabled", habilitar);
    });

    $('#formModificarUsuario').submit(function (event) {
        event.preventDefault();
        $.ajax({
            type: "POST",
            dataType: 'json',
            url: "./ProcesarModificarUsuario.php",
            data: $("#formModificarUsuario").serialize(),
            success: function (data) {
                $('#seccionResultado').html(data[0]['resultado']);
                if (data[0]['exito'] === true) {
                    $('#formModificarUsuario').find('input, textarea, select').prop('disabled', true);
                    $("#btnModificarUsuario").prop("disabled", true);
                }
            },
            error: function (data) {
                console.log(data);
                var men = '<i class="fas fa-exclamation-triangle"><strong>No se procesó la petición</strong></i>';
                var div = '<div class="alert alert-danger text-center" role="alert">' + men + '</div>';
                $("#seccionResultado").html(div);
            }
        });
    });

    $('select#rol').select2({
        placeholder: 'Seleccione una opcion',
        theme: "bootstrap",
        minimumInputLength: 1,
        maximumSelectionLength: 30,
        language: "es",
        allowClear: true,
        width: '100%',
        ajax: {
            url: "./ProcesarSeleccionarRol.php",
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

    $('#nombre').change(function () {
        var borde = ($(this).val().length < 8) ? "1px solid red" : "";
        $(this).css("border", borde);
    });

    $('#correo').change(function () {
        var correo = $(this).val();
        var borde = ($(this).val().length < 12) ? "1px solid red" : "";
        $(this).css("border", borde);
        if ($("#metodo").val() === "Google") {
            if (!correo.includes('@unpa.edu.ar') && !correo.includes('@gmail.com')) {
                var men = "Para metodo 'Google' se debe indicar un correo @unpa.edu.ar o @gmail.com";
                var div = '<div class="alert alert-warning text-center" role="alert"><strong>' + men + '</strong></div>';
                $('#seccionResultado').html(div);
            }
        }
    });

    $('#clave').change(function () {
        var borde = ($(this).val().length < 8) ? "1px solid red" : "";
        $(this).css("border", borde);
    });


});
