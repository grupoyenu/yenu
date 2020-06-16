/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).ready(function () {

    var formOriginal = $("#formModificarPermiso").serialize();

    $("#formModificarPermiso").change(function () {
        var formModificado = $("#formModificarPermiso").serialize();
        var habilitar = (formOriginal !== formModificado) ? false : true;
        $("#btnModificarPermiso").prop("disabled", habilitar);
    });

    $('#formModificarPermiso').submit(function (event) {
        event.preventDefault();
        $.ajax({
            type: "POST",
            dataType: 'json',
            url: "./ProcesarModificarPermiso.php",
            data: $("#formModificarPermiso").serialize(),
            success: function (data) {
                $('#seccionResultado').html(data[0]['resultado']);
                if (data[0]['exito'] === true) {
                    $("#nombre").prop("disabled", true);
                    $("#btnModificarPermiso").prop("disabled", true);
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

    $('#nombre').change(function () {
        var borde = ($(this).val().length < 5) ? "1px solid red" : "";
        $(this).css("border", borde);
    });


});

