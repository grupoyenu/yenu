/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).ready(function () {

    $('#formInformeMesa').submit(function (evento) {
        evento.preventDefault();
        $.ajax({
            type: "POST",
            url: "./app/mesas/vistas/ProcesarInformeMesa.php",
            data: $("#formInformeMesa").serialize(),
            success: function (data) {
                $('#seccionInferior').html(data);
            },
            error: function (data) {
                console.log(data);
                $("#seccionInferior").html('<div class="alert alert-danger text-center" role="alert"><strong>No se procesó la petición</strong></div>');
            }
        });
    });

});
