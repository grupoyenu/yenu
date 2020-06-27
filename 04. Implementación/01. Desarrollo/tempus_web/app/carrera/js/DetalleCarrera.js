/** 
 * 
 * @author Oyarzo Mariela <marielaoyarzo89@gmail.com>
 * @author Quiroga Sandra <squiroga17@gmail.com>
 * @author Marquez Emanuel <e.m.a-13@hotmail.com>
 */
$(document).ready(function () {

    $("table#tablaDetalleCarrera").DataTable({
        dom: 'Bfrtip',
        responsive: true,
        language: {url: "../../../lib/js/Spanish.json"},
        buttons: [
            {extend: 'pdfHtml5',
                download: 'open',
                title: 'TEMPUS Detalle de carrera'},
            {extend: 'excelHtml5',
                title: 'TEMPUS Detalle de carrera'},
            {extend: 'print',
                text: 'Imprimir',
                title: 'TEMPUS Detalle de carrera',
                customize: function (win) {
                    $(win.document.body).css('font-size', '12pt');
                    $(win.document.body).find('table')
                            .addClass('compact')
                            .css('font-size', 'inherit');
                }
            },
            {extend: 'copy', text: 'Copiar'}
        ]
    });

});


