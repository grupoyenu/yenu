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

});