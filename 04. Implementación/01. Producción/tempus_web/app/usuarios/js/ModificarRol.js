/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).ready(function () {

    var formOriginal = $("#formModificarRol").serialize();

    $("#formModificarRol").change(function () {
        var formModificado = $("#formModificarRol").serialize();
        var habilitar = (formOriginal !== formModificado) ? false : true;
        $("#btnModificarRol").prop("disabled", habilitar);
    });

    $('#formModificarRol').submit(function (event) {
        event.preventDefault();
        $.ajax({
            type: "POST",
            dataType: 'json',
            url: "./app/usuarios/vistas/ProcesarModificarRol.php",
            data: $("#formModificarRol").serialize(),
            success: function (data) {
                $('#seccionResultado').html(data[0]['resultado']);
                if (data[0]['exito'] === true) {
                    $('#formModificarRol').find('input, textarea, select').prop('disabled', true);
                    $("#btnModificarRol").prop("disabled", true);
                }
            },
            error: function (data) {
                console.log(data);
                $("#seccionResultado").html('<div class="alert alert-danger text-center" role="alert">No se procesó la petición</div>');
            }
        });
    });

});