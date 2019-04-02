/** 
 * Este archivo JavaScript se encarga de controlar los eventos de FormBuscarPermiso.php
 * y de realizar las validaciones correspondientes antes que el formulario sea 
 * enviado al servidor. Se comunica con procesaBorrarPermiso.php y 
 * procesaModificarPermiso.js a traves de AJAX. 
 * 
 * @author Oyarzo Mariela 
 * @author Quiroga Sandra
 * @author Marquez Emanuel
 */
$(document).ready(function () {

    var idpermiso = null;

    /* Inicializa la tabla con DataTable */

    $("table#tablaPermisos").DataTable({
        dom: 'Bfrtip',
        responsive: true,
        language: {url: "./app/js/Spanish.json"}
    });

    /* Abre el modal de confirmacion para eliminar permiso */

    $('img.borrarPermiso').click(function () {
        idpermiso = $(this).attr('name');
        $("#mdBorrar").modal();
    });

    /* Solicitud AJAX para procesar la eliminacion */

    $('#btnConfirmarEliminacion').click(function () {
        $.ajax({
            type: "POST",
            url: "./app/vistas/procesaBorrarPermiso.php",
            dataType: 'json',
            data: "idpermiso=" + idpermiso,
            success: function (data) {
                $("#FormBuscarPermiso").empty();
                $("#FormBuscarPermiso").html(data[0]['div']);
            },
            error: function () {
                imprimirAlerta("Error durante la petición por AJAX");
            }
        });
        $("#mdBorrar").modal("toggle");
    });

    /* Solicitud AJAX para cargar el formulario de modificacion */

    $('img.modificarPermiso').click(function () {
        idpermiso = $(this).attr('name');
        $.ajax({
            type: "POST",
            url: "./app/vistas/FormModificarPermiso.php",
            data: "idpermiso=" + idpermiso,
            success: function (data) {
                $("#FormBuscarPermiso").empty();
                $("#FormBuscarPermiso").html(data);
            },
            error: function () {
                imprimirAlerta("Error durante la petición por AJAX");
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
