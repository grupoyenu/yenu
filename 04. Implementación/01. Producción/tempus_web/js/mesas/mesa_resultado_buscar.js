/**
 * Controla los eventos del formulario mesa_resultado_buscar.php
 * 
 * @author Marquez Emanuel
 */

$(document).ready(function() {
	
	/**
	 * Inicializa la tabla donde se presentan las mesas de examen encontradas.
	 * Les coloca los botones para realizar las descarga en formatos distintos.
	 * Les modifica el lenguaje a cada uno de los elementos del DataTable.
	 * */
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
	
	/**
	 * Cuando se presiona el boton modificar mesa, se asigna "modificar" al
	 * hidden accion del formulario para que el manejador sepa que operación
	 * desea hacer el usuario.
	 * */
	$("#formBuscarMesas").on("click", "#btnModificarMesa", function(event) {
		
		$("h3#mensaje" ).remove();
		if(!$("input[name='radioMesas']").is(":checked")) {
			$("<h3 id='mensaje' class='letraNaranja'>Debe seleccionar una mesa de examen a modificar</h3>").insertAfter("#content h2");
			return false;
		}
		$("input[name='accion']").val("modificar");
	});
	
	/**
	 * Cuando se presiona el boton borrar mesa, se asigna "borrar" al
	 * hidden accion del formulario para que el manejador sepa que operación
	 * desea hacer el usuario.
	 * */
	$("#formBuscarMesas").on("click", "#btnBorrarMesa", function(event) {
		$("h3#mensaje" ).remove();
		if(!$("input[name='radioMesas']").is(":checked")) {
			$("<h3 id='mensaje' class='letraNaranja'>Debe seleccionar una mesa de examen a borrar</h3>").insertAfter("#content h2");
			return false;
		}
		$("input[name='accion']").val("borrar");

	});

	
});