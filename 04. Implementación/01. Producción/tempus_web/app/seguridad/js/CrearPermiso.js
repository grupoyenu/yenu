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
            url: "./ProcesarCrearPermiso.php",
            data: $("#formCrearPermiso").serialize(),
            success: function (data) {
                $('#seccionResultado').html(data[0]['resultado']);
                if (data[0]['exito'] === true) {
                    $("#formCrearPermiso")[0].reset();
                }
                $('html, body').animate({scrollTop: 0}, 1250);
            },
            error: function (data) {
                console.log(data);
                var men = "<strong>No se procesó la petición</strong>";
                var div = '<div class="alert alert-danger text-center" role="alert">' + men + '</div>';
                $('#seccionResultado').html(div);
                $('html, body').animate({scrollTop: 0}, 1250);
            }
        });
    });

    $('#nombre').change(function () {
        var borde = ($(this).val().length < 5) ? "1px solid red" : "";
        $(this).css("border", borde);
    });

});

