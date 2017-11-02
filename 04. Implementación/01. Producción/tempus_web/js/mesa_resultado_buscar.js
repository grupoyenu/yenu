/**
 * Controla los eventos del formulario mesa_resultado_buscar.php
 * 
 */

$(document).ready(function() {
	
	$("table#tablaBuscarMesas").DataTable({
		dom: 'Bfrtip',
        buttons: [
        	{
	    		extend: 'pdfHtml5',
	            orientation: 'landscape',
	            pageSize: 'LEGAL',
	            download: 'open',
	            text: 'Descargar PDF',
	            title: ' Mesas de examen '
        	},
        	'excelHtml5',
            'csvHtml5',
        ],
        language: {
			processing: "Procesando...",
	        search: "Buscar:",
            lengthMenu: "Viendo _MENU_ regristros por página",
            zeroRecords: "Sin resultados",
            info: "Mostrando _START_ a _END_ de _TOTAL_ entradas",
            infoEmpty: "No hay registros disponibles",
            infoFiltered: "(Filtrado de _MAX_ registros totales)",
            loadingRecords: "Cargando registros...",
            emptyTable: "Sin resultados",
            paginate: {
                previous: "Anterior",
                next: "Siguiente"
            }
       }
	});
	
});