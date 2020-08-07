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
            url: "./ProcesarImportarCursada.php",
            success: function (data) {
                $('#contenido').html(data);
            },
            error: function (data) {
                console.log(data);
                var men = "<i class='fas fa-exclamation-triangle'><strong>No se procesó la petición</strong></i>";
                var div = '<div class="alert alert-danger text-center" role="alert">' + men + '</div>';
                $("#seccionResultado").html(div);
            },
            complete: function () {
                $("#ModalProcesando").modal('toggle');
            }
        });
    });

});