/** 
 * Este archivo JavaScript se encarga de controlar los eventos de FormImportarCursada.php
 * No se comunica con ningun otro archivo.
 * 
 * @author Oyarzo Mariela 
 * @author Quiroga Sandra
 * @author Marquez Emanuel
 */
$(document).ready(function () {

    /* Inicializa la tabla con DataTable */

    $("table#tablaImportarCursadas").DataTable({
        dom: 'Bfrtip',
        responsive: true,
        language: {url: "./lib/js/Spanish.json"}
    });
    
    $('#btnImportarCursada').click(function (evento) {
        evento.preventDefault();
        $("#ModalProcesando").modal({});
        $.ajax({
            type: "POST",
            url: "./app/cursadas/vistas/ProcesarImportarCursada.php",
            success: function (data) {
                $('#contenido').html(data);
            },
            error: function (data) {
                console.log(data);
                $("#seccionResultado").html('<div class="alert alert-danger text-center" role="alert"><strong>No se procesó la petición<strong></div>');
            },
            complete: function () {
                $("#ModalProcesando").modal('toggle');
            }
        });
    });

});