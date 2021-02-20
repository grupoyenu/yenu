/** 
 * Este archivo JavaScript se encarga de controlar los eventos de FormImportarMesa.php
 * No se comunica con ningun otro archivo.
 * 
 * @author Oyarzo Mariela 
 * @author Quiroga Sandra
 * @author Marquez Emanuel
 */
$(document).ready(function () {

    /* Inicializa la tabla con DataTable */

    $("table#tablaImportarMesas").DataTable({
        dom: 'Bfrtip',
        "bPaginate": false,
        paging: false,
        responsive: true,
        language: { url: "../../../lib/js/Spanish.json" }
    });

    $('#btnImportarMesa').click(function (evento) {
        evento.preventDefault();
        $("#ModalProcesando").modal({});
        $.ajax({
            type: "POST",
            url: "./ProcesarImportarMesa.php",
            success: function (data) {
                $('#contenido').html(data);
                $("table#tablaImportarMesasErrores").DataTable({
                    dom: 'Bfrtip',
                    "bPaginate": false,
                    paging: false,
                    responsive: true,
                    language: { url: "../../../lib/js/Spanish.json" }
                });

            },
            error: function (data) {
                console.log(data);
                var men = "<i class='fas fa-exclamation-triangle'></i> <strong>No se procesó la petición</strong>";
                var div = "<div class='alert alert-danger text-center' role='alert'>" + men + "</div>";
                $("#seccionResultado").html(div);
            },
            complete: function () {
                $("#ModalProcesando").modal('toggle');
            }
        });
    });

});

