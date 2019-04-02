/** 
 * Este archivo JavaScript se encarga de controlar los eventos de FormBuscarUsuario.php
 * y de realizar las validaciones correspondientes antes que el formulario sea 
 * enviado al servidor. Se comunica con procesaBorrarUsuario.php y 
 * procesaModificarUsuario.js a traves de AJAX. 
 * 
 * @author Oyarzo Mariela 
 * @author Quiroga Sandra
 * @author Marquez Emanuel
 */
$(document).ready(function () {

    /* Inicializa la tabla con DataTable */
    
    $("table#tablaBuscarUsuarios").DataTable({
        dom: 'Bfrtip',
        responsive: true,
        language: { url: "./app/js/Spanish.json" }
    });
    
    /* Abre el modal de confirmacion para eliminar el usuario */
    $('img.borrarUsuario').click(function () {
        $("#mdBorrar").modal();
    });
    
    /* Solicitud AJAX para procesar la eliminacion */
    
    /* Solicitud AJAX para cargar el formulario de modificacion*/
    
    $('img.modificarUsuario').click(function () {
        var idusuario = $(this).attr('name');
        $.ajax({
            type: "POST",
            url: "./app/vistas/FormModificarRol.php",
            data: "idusuario="+idusuario,
            success: function (data) {
                $("#FormBuscarUsuario").empty();
                $("#FormBuscarUsuario").html(data);
            },
            error: function () {
                $("#resultado").html('<div class="alert alert-danger text-center" role="alert">Error durante la petición por AJAX</div>');
            }
        });
    });

});

