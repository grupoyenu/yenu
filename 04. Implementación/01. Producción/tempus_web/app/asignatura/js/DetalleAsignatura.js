/** 
 * 
 * @author Oyarzo Mariela <marielaoyarzo89@gmail.com>
 * @author Quiroga Sandra <squiroga17@gmail.com>
 * @author Marquez Emanuel <e.m.a-13@hotmail.com>
 */
$(document).ready(function () {

    $("table#tablaDetalleAsignatura").DataTable({
        dom: 'Bfrtip',
        responsive: true,
        language: {url: "../../lib/js/Spanish.json"}
    });

});

