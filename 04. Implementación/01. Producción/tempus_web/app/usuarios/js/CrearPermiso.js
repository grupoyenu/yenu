/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$(document).ready(function () {

    $('#formCrearPermiso').submit(function (evento) {
        evento.preventDefault();
        $.ajax({
            type: "POST",
            dataType: 'json',
            url: "./app/usuarios/vistas/ProcesarCrearPermiso.php",
            data: $("#formCrearPermiso").serialize(),
            success: function (data) {
                $('#seccionResultado').html(data[0]['resultado']);
                $("#formCrearPermiso").reset();
            },
            error: function (data) {
                console.log(data);
                $('#seccionResultado').html('<div class="alert alert-danger text-center" role="alert"><strong>No se procesó la petición</strong></div>');
            }
        });
    });

});

