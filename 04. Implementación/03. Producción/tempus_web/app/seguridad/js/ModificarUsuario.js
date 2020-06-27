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

});
