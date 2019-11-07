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
        responsive: true,
        language: {url: "./lib/js/Spanish.json"}
    });

    $('#btnImportarMesa').click(function (evento) {
        evento.preventDefault();
        $.ajax({
            type: "POST",
            url: "./app/mesas/vistas/ProcesarImportarMesa.php",
            success: function (data) {
                $('#contenido').html(data);
            },
            error: function (data) {
                console.log(data);
                $("#contenido").html('<div class="alert alert-danger text-center" role="alert"><strong>No se procesó la petición<strong></div>');
            }
        });
    });

});

