/** 
 * Controla los eventos del archivo FormCrearAula.php y realiza las validaciones
 * correspondientes antes que el formulario se envie al servidor. Se comunica a
 * traves de AJAX con el archivo procesaCrearAula.php. Como resultado de la 
 * operacion recibe un arreglo JSON con un booleano y mensaje.
 * 
 * @author Oyarzo Mariela 
 * @author Quiroga Sandra
 * @author Marquez Emanuel
 */
$(document).ready(function () {

    /* Captura el formulario antes de su envio y realiza solicitud AJAX */

    $('#formCrearAula').submit(function (event) {
        event.preventDefault();
        $.ajax({
            type: "POST",
            dataType: 'json',
            url: "./app/aulas/vistas/ProcesarCrearAula.php",
            data: $("#formCrearAula").serialize(),
            success: function (data) {
                if (data[0]['exito'] === true) {
                    $('#seccionCentral').html(data[0]['div']);
                    $("#seccionInferior").empty();
                } else {
                    $('#seccionCentral').html(data[0]['div']);
                }
            },
            error: function (data) {
                console.log(data);
                var div = '<div class="alert alert-danger text-center" role="alert">No se procesó la petición por un error interno</div>';
                $("#seccionCentral").html(div);
            }
        });
    });

    /* Agrega un borde cuando el sector de aula esta vacio */

    $('#sector').change(function () {
        var valor = ($(this).val().length === 0) ? "1px solid red" : "";
        $(this).css("border", valor);
    });

    /* Agrega un borde cuando el nombre de aula esta vacio */

    $('#nombre').change(function () {
        var valor = ($(this).val().length === 0) ? "1px solid red" : "";
        $(this).css("border", valor);
    });

});


