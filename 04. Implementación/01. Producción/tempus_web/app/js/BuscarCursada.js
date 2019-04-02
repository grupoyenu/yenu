/**
 * Este archivo controla los eventos del archivo FormBuscarCursada.php que se
 * encuentra en el directorio de vistas. El mismo realiza la solicitud a traves 
 * de AJAX al procesaBuscarCursada.php en el momento que se activa el SUBMIT. Una 
 * vez procesada la peticion se refresca el div resultado. 
 * 
 * @author Oyarzo Mariela 
 * @author Quiroga Sandra
 * @author Marquez Emanuel
 */
$(document).ready(function () {

    /* Captura el formulario al momento de su envio */
    
    $('#formBuscarCursada').submit(function (event) {
        event.preventDefault();
        $.ajax({
            type: "POST",
            url: "./app/vistas/procesaBuscarCursada.php",
            data: $("#formBuscarCursada").serialize(),
            success: function (data) {
                $("#resultado").html(data);
            },
            error: function () {
                var mensaje = 'Error durante la petición por AJAX';
                var div = '<div class="alert alert-danger text-center" role="alert">'+mensaje+'</div>';
                $("#resultado").html(div);
            }
        });
    });
    
});