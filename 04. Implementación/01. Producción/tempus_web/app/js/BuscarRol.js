/** 
 * Este archivo JavaScript se encarga de controlar los eventos de FormBuscarRol.php
 * y de realizar las validaciones correspondientes antes que el formulario sea 
 * enviado al servidor. Se comunica con procesaBorrarRol.php y 
 * procesaModificarRol.js a traves de AJAX. 
 * 
 * @author Oyarzo Mariela 
 * @author Quiroga Sandra
 * @author Marquez Emanuel
 */
$(document).ready(function () {

    var idrol = null;

    /* Inicializa la tabla con DataTable */

    $("table#tablaBuscarRoles").DataTable({
        dom: 'Bfrtip',
        responsive: true,
        language: {url: "./app/js/Spanish.json"}
    });

    /* Abre el modal de confirmacion para eliminar rol */

    $('img.borrarRol').click(function () {
        idrol = $(this).attr('name');
        $("#mdBorrar").modal();
    });

    /* Solicitud AJAX para procesar la eliminacion */

    $('#btnConfirmarEliminacion').click(function () {
        $.ajax({
            type: "POST",
            url: "./app/vistas/procesaBorrarRol.php",
            dataType: 'json',
            data: "idrol=" + idrol,
            success: function (data) {
                $("#FormBuscarRol").empty();
                $("#FormBuscarRol").html(data[0]['div']);
            },
            error: function (data) {
                console.log(data);
                imprimirAlerta("No se procesó la petición por un error interno");
            }
        });
        $("#mdBorrar").modal("toggle");
    });

    /* Solicitud AJAX para cargar el formulario de modificacion */

    $('img.modificarRol').click(function () {
        var idrol = $(this).attr('name');
        $.ajax({
            type: "POST",
            url: "./app/vistas/FormModificarRol.php",
            data: "idrol=" + idrol,
            success: function (data) {
                $("#FormBuscarRol").empty();
                $("#FormBuscarRol").html(data);
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

    /* Marca o desmarca todos los permisos de la tabla */

    $('#todosPermisos').change(function () {
        if ($(this).is(':checked')) {
            $("input[name='permisos[]']").each(function () {
                $(this).prop('checked', true);
            });
        } else {
            $("input[name='permisos[]']").each(function () {
                $(this).prop('checked', false);
            });
        }
    });

    /* Imprime un alerta en el div resultado */

    function imprimirAlerta(mensaje) {
        $("#resultado").empty();
        var div = '<div class="alert alert-danger text-center" role="alert">' + mensaje + '</div>';
        $("#resultado").html(div);
    }

});