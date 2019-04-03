/**
 * Este archivo controla los eventos del archivo FormBuscarMesa.PHP que se
 * encuentra en el directorio de vistas. El mismo realiza la solicitud a traves 
 * de AJAX al procesaBuscarMesa.php en el momento que se activa el SUBMIT. Una 
 * vez procesada la peticion se refresca el div resultado. 
 * 
 * @author Oyarzo Mariela 
 * @author Quiroga Sandra
 * @author Marquez Emanuel
 */
$(document).ready(function () {

    /* Captura el formulario al momento de su envio */

    $('#formBuscarMesas').submit(function (event) {
        event.preventDefault();
        $.ajax({
            type: "POST",
            url: "./app/vistas/procesaBuscarMesa.php",
            data: $("#formBuscarMesas").serialize(),
            success: function (data) {
                $("#resultado").html(data);
            },
            error: function (data) {
                console.log(data);
                imprimirAlerta("No se procesó la petición por un error interno");
            }
        });
    });

    /* Imprime un alerta en el div resultado */

    function imprimirAlerta(mensaje) {
        $("#resultado").empty();
        var div = '<div class="alert alert-danger text-center" role="alert">' + mensaje + '</div>';
        $("#resultado").html(div);
    }

});