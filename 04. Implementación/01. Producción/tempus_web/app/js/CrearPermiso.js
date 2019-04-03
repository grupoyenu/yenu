/** 
 * Controla los eventos del archivo FormCrearPermiso.php y realiza las validaciones
 * correspondientes antes que el formulario se envie al servidor. Se comunica a
 * traves de AJAX con el archivo procesaCrearPermiso.php. Como resultado de la 
 * operacion recibe un arreglo JSON con un booleano y mensaje.
 * 
 * @author Oyarzo Mariela 
 * @author Quiroga Sandra
 * @author Marquez Emanuel
 */
$(document).ready(function () {

    /* Captura el formulario antes de su envio y realiza solicitud AJAX */
    
    $('#formCrearPermiso').submit(function (event) {
        event.preventDefault();
        $.ajax({
            type: "POST",
            dataType: 'json',
            url: "./app/vistas/procesaCrearPermiso.php",
            data: $("#formCrearPermiso").serialize(),
            success: function (data) {
                if (data[0]['exito'] === true) {
                    $('#resultado').html(data[0]['div']);
                    $('#contenido').empty();
                } else {
                    $('#resultado').html(data[0]['div']);
                }
            },
            error: function (data) {
                console.log(data);
                imprimirAlerta("No se procesó la petición por un error interno");
            }
        });
    });
    
    /* Agrega un borde cuando el nombre de permiso esta vacio */
    
    $('#nombre').change(function () {
        var valor = ($(this).val().length < 5) ? "1px solid red" : "";
        $(this).css("border", valor);
    });
    
    /* Imprime un alerta en el div resultado */

    function imprimirAlerta(mensaje) {
        $("#resultado").empty();
        var div = '<div class="alert alert-danger text-center" role="alert">' + mensaje + '</div>';
        $("#resultado").html(div);
    }

});