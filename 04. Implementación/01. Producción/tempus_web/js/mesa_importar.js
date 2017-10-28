/**
 * 
 */

$(document).ready(function() {
	
	$("table#tablaImportarMesas").DataTable({
		dom: 'Bfrtip',
        buttons: [
        	{
    		extend: 'pdfHtml5',
            orientation: 'landscape',
            pageSize: 'LEGAL',
            download: 'open',
            text: 'Descargar PDF',
            title: ' Mesas de Examen '
        	}
        ]
	});
	
});