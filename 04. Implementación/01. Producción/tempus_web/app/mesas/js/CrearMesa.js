/** 
 * Controla los eventos del archivo FormCrearMesa.php y realiza las validaciones
 * correspondientes antes que el formulario se envie al servidor. Se comunica a
 * traves de AJAX con el archivo procesaCrearMesa.php. Como resultado de la 
 * operacion recibe un arreglo JSON con un booleano y mensaje. 
 * 
 * @author Oyarzo Mariela 
 * @author Quiroga Sandra
 * @author Marquez Emanuel
 */
$(document).ready(function () {

    /* Captura el formulario antes de su envio y realiza solicitud AJAX */

    $('#formCrearMesa').submit(function (evento) {
        evento.preventDefault();
        $.ajax({
            type: "POST",
            dataType: 'json',
            url: "./app/mesas/vistas/ProcesarCrearMesa.php",
            data: $("#formCrearMesa").serialize(),
            success: function (data) {
                $('#seccionResultado').html(data[0]['resultado']);
                if (data[0]['exito'] === true) {
                    $("#formCrearMesa")[0].reset();
                }
            },
            error: function (data) {
                console.log(data);
                $('#seccionResultado').html("<div class='alert alert-danger text-center' role='alert'><i class='fas fa-exclamation-triangle'></i> <strong>No se procesó la petición</strong></div>");
            }
        });
    });

});


