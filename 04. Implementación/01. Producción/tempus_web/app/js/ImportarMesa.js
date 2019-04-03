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
        buttons: [
            {
                extend: 'pdfHtml5',
                orientation: 'landscape',
                pageSize: 'LEGAL',
                download: 'open',
                text: 'Descargar PDF',
                title: ' Mesas de Examen '
            }
        ],
        language: {url: "./app/js/Spanish.json"}
    });

});

