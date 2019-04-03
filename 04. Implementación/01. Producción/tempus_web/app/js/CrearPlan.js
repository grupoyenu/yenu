/** 
 * Controla los eventos del archivo FormCrearPlan.php y realiza las validaciones
 * correspondientes antes que el formulario se envie al servidor. Se comunica a
 * traves de AJAX con el archivo procesaCrearPlan.php. Como resultado de la 
 * operacion recibe un arreglo JSON con un booleano y mensaje. Tambien controla 
 * los eventos asociados al modal de carrera y modal de asignatura.
 * 
 * @author Oyarzo Mariela 
 * @author Quiroga Sandra
 * @author Marquez Emanuel
 */
$(document).ready(function () {

    /* Captura el formulario antes de su envio y realiza solicitud AJAX */

    $('#formCrearPlan').submit(function (event) {
        event.preventDefault();
        $.ajax({
            type: "POST",
            url: "./app/vistas/procesaCrearPlan.php",
            data: $("#formCrearPlan").serialize(),
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
    
    /* Abre el modal para la seleccion de carrera */
    
   $('#seleccionarCarrera').click(function () {
        $("#modalCarreras").modal();
        return false;
    });
    
    /* Abre el modal para la seleccion de asignatura */
    
    $('#seleccionarAsignatura').click(function () {
        $("#modalAsignaturas").modal();
        return false;
    });
    
    /* Imprime un alerta en el div resultado */

    function imprimirAlerta(mensaje) {
        $("#resultado").empty();
        var div = '<div class="alert alert-danger text-center" role="alert">' + mensaje + '</div>';
        $("#resultado").html(div);
    }

});

