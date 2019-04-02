/** 
 * Controla los eventos del archivo FormCrearUsuario.php y realiza las validaciones
 * correspondientes antes que el formulario se envie al servidor. Se comunica a
 * traves de AJAX con el archivo procesaCrearUsuario.php. Como resultado de la 
 * operacion recibe un arreglo JSON con un booleano y mensaje.
 * 
 * @author Oyarzo Mariela 
 * @author Quiroga Sandra
 * @author Marquez Emanuel
 */
$(document).ready(function () {
    
    /* Captura el formulario antes de su envio y realiza solicitud AJAX */
    
    $('#formCrearUsuario').submit(function (event) {
        event.preventDefault();
        $.ajax({
            type: "POST",
            dataType: 'json',
            url: "./app/vistas/procesaCrearUsuario.php",
            data: $("#formCrearUsuario").serialize(),
            success: function (data) {
                if (data[0]['exito'] === true) {
                    $('#resultado').html(data[0]['div']);
                    $('#contenido').empty();
                } else {
                    $('#resultado').html(data[0]['div']);
                }
            },
            error: function () {
                var mensaje = "Solicita creación: no se pudo procesar la petición";
                $("#resultado").html('<div class="alert alert-danger text-center" role="alert">'+mensaje+'</div>');
            }
        });
    });
    
    /* Agrega un borde cuando el email de usuario esta vacio */
    
    $('#email').change(function () {
        var valor = ($(this).val().length < 0) ? "1px solid red" : "";
        $(this).css("border", valor);
    });
    
    /* Agrega un borde cuando el nombre de usuario esta vacio */
    
    $('#nombre').change(function () {
        var valor = ($(this).val().length < 5) ? "1px solid red" : "";
        $(this).css("border", valor);
    });
    
});