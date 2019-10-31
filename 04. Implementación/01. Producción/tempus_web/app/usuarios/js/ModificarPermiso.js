/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).ready(function () {

    var formOriginal = $("#formModificarPermiso").serialize();

    $("#formModificarPermiso").change(function () {
        var formModificado = $("#formModificarPermiso").serialize();
        var habilitar = true;
        if (formOriginal !== formModificado) {
            habilitar = false;
            $("#btnModificarPermiso").prop("disabled", false);
        }
        $("#btnModificarPermiso").prop("disabled", habilitar);
    });
    
    $('#formModificarPermiso').submit(function (event) {
        event.preventDefault();
        $.ajax({
            type: "POST",
            dataType: 'json',
            url: "./app/usuarios/vistas/ProcesarModificarPermiso.php",
            data: $("#formModificarPermiso").serialize(),
            success: function (data) {
                $('#seccionResultado').html(data[0]['resultado']);
                if (data[0]['exito'] === true) {
                    $("#btnModificarPermiso").prop("disabled", true);
                }
            },
            error: function (data) {
                console.log(data);
                $("#seccionResultado").html('<div class="alert alert-danger text-center" role="alert">No se procesó la petición</div>');
            }
        });
    });

});

