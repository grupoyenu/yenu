/** 
 * Este archivo JavaScript se encarga de controlar los eventos de FormBuscarAsignatura.php
 * No se comunica con ningun otro archivo.
 * 
 * @author Oyarzo Mariela 
 * @author Quiroga Sandra
 * @author Marquez Emanuel
 */
$(document).ready(function () {

    /* Inicializa la tabla con DataTable */
    
    $("table#tablaBuscarAsignaturas").DataTable({
        dom: 'Bfrtip',
        responsive: true,
        language: {url: "./app/js/Spanish.json"}
    });

});
