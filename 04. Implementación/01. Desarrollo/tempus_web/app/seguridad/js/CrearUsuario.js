/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).ready(function () {

    $('#formCrearUsuario').submit(function (evento) {
        evento.preventDefault();
        $.ajax({
            type: "POST",
            dataType: 'json',
            url: "./ProcesarCrearUsuario.php",
            data: $("#formCrearUsuario").serialize(),
            success: function (data) {
                $('#seccionResultado').html(data[0]['resultado']);
                if (data[0]['exito'] === true) {
                    $("#formCrearUsuario")[0].reset();
                }
                $('html, body').animate({scrollTop: 0}, 1250);
            },
            error: function (data) {
                console.log(data);
                var men = '<i class="fas fa-exclamation-triangle"><strong>No se procesó la petición</strong></i>';
                var div = '<div class="alert alert-danger text-center" role="alert">' + men + '</div>';
                $('#seccionResultado').html(div);
                $('html, body').animate({scrollTop: 0}, 1250);
            }
        });
    });

    $("#metodo").change(function () {
        var metodo = $(this).val();
        var habilitar = (metodo === "Google") ? true : false;
        $("#clave").prop("disabled", habilitar);
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
