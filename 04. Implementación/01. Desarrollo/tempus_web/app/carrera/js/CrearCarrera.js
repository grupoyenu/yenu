/** 
 * 
 * @author Oyarzo Mariela <marielaoyarzo89@gmail.com>
 * @author Quiroga Sandra <squiroga17@gmail.com>
 * @author Marquez Emanuel <e.m.a-13@hotmail.com>
 */
$(document).ready(function () {

    /* Captura el formulario antes de su envio y realiza solicitud AJAX */

    $('#formCrearCarrera').submit(function (event) {
        event.preventDefault();
        $.ajax({
            type: "POST",
            dataType: 'json',
            url: "./ProcesarCrearCarrera.php",
            data: $("#formCrearCarrera").serialize(),
            success: function (data) {
                $('#seccionResultado').html(data[0]['resultado']);
                if (data[0]['exito'] === true) {
                    $("#formCrearCarrera")[0].reset();
                }
            },
            error: function (data) {
                console.log(data);
                var men = "<i class='fas fa-exclamation-triangle'><strong>No se procesó la petición</strong></i>";
                var div = "<div class='alert alert-danger text-center' role='alert'>" + men + "</div>";
                $('#seccionResultado').html(div);
            }
        });
    });



});
