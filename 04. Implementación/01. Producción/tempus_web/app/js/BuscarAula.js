/** 
 * Este archivo JavaScript se encarga de controlar los eventos de FormBuscarAula.php
 * y de realizar las validaciones correspondientes antes que el formulario sea 
 * enviado al servidor. Se comunica con procesaBorrarAula.php y procesaModificarAula.js 
 * a traves de AJAX. 
 * 
 * @author Oyarzo Mariela 
 * @author Quiroga Sandra
 * @author Marquez Emanuel
 */
$(document).ready(function () {
    
    var idaula = null;

    /* Inicializa la tabla con DataTable */

    $("table#tablaAulas").DataTable({
        dom: 'Bfrtip',
        responsive: true,
        language: {url: "./app/js/Spanish.json"}
    });

    /* Abre el modal de confirmacion para eliminar aula */

    $('img.borrarAula').click(function () {
        idaula = $(this).attr('name');
        $("#mdBorrar").modal();
    });

    /* Solicitud AJAX para procesar la eliminacion */
    
    $('#btnConfirmarEliminacion').click(function () {
        $.ajax({
            type: "POST",
            url: "./app/vistas/procesaBorrarAula.php",
            dataType: 'json',
            data: "idaula=" + idaula,
            success: function (data) {
                $("#FormBuscarAula").empty();
                $("#FormBuscarAula").html(data[0]['div']);
            },
            error: function (data) {
                console.log(data);
                imprimirAlerta("No se procesó la petición por un error interno");
            }
        });
        $("#mdBorrar").modal("toggle");
    });

    /* Solicitud AJAX para cargar el formulario de modificacion */

    $('img.modificarAula').click(function () {
        var idaula = $(this).attr('name');
        $.ajax({
            type: "POST",
            url: "./app/vistas/FormModificarAula.php",
            data: "idaula=" + idaula,
            success: function (data) {
                $("#FormBuscarAula").empty();
                $("#FormBuscarAula").html(data);
            },
            error: function (data) {
                console.log(data);
                imprimirAlerta("No se procesó la petición por un error interno");
            }
        });
    });

    /* Solicitud AJAX para cargar el formulario de informe */

    $('img.informeAula').click(function () {
        var idaula = $(this).attr('name');
        $.ajax({
            type: "POST",
            url: "./app/vistas/FormInformeAula.php",
            data: "idaula=" + idaula,
            success: function (data) {
                $("#FormBuscarAula").empty();
                $("#FormBuscarAula").html(data);
            },
            error: function (data) {
                console.log(data);
                imprimirAlerta("No se procesó la petición por un error interno");
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