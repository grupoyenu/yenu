/**
 * 
 */

$(document).ready(function() {
	
	$("table#tablaImportarCursadas").DataTable({
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