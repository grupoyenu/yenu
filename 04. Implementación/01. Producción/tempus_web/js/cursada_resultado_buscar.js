/**
 * 
 */


$(document).ready(function() {
	
	$("table#tablaBuscarCursadas").DataTable({
		dom: 'Bfrtip',
        buttons: [
        	{
    		extend: 'pdfHtml5',
            orientation: 'landscape',
            pageSize: 'LEGAL',
            download: 'open',
            text: 'Descargar PDF',
            title: ' Horarios de cursada '
        	}
        ]
	});
	
});