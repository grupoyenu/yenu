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
            error: function () {
                $("#resultado").html('<div class="alert alert-danger text-center" role="alert">Error durante la petición por AJAX</div>');
            }
        });
    });
    
   
});