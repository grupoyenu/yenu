/**
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
        	{
        		extend: 'excelHtml5',
        		text: 'Descargar Excel'
        	}
        ]
	});
	
});