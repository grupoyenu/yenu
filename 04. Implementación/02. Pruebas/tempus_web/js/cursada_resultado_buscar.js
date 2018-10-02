/**
 * Controla los eventos del archivo cursada_resultado_buscar.php.
 * Se realiza la inicialización de la tabla para la presentacion
 * de los horarios de cursada y se realiza el control de la 
 * seleccion de elementos (filas de la tabla) antes de realizar
 * alguna de las operaciones disponibles.
 * 
 * @author Marquez Emanuel
 */

$(document).ready(function() {
	
	/**
	 * Inicializa la tabla donde se presentan las cursadas encontradas.
	 * Les coloca los botones para realizar las descarga en formatos distintos.
	 * Les modifica el lenguaje a cada uno de los elementos del DataTable.
	 * */
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
        	},
        	{
        		extend: 'excelHtml5',
        		text: 'Descargar Excel'
        	}
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
	 * Cuando se presiona el boton modificar cursada, se asigna "modificar" al
	 * hidden accion del formulario para que el manejador sepa que operación
	 * desea hacer el usuario.
	 * */
	$("#formBuscarCursadas").on("click", "#btnModificarCursada", function(event) {
		
		$("h3#mensaje" ).remove();
		if(!$("input[name='radioCursadas']").is(":checked")) {
			$("<h3 id='mensaje' class='letraNaranja'>Debe seleccionar una cursada a modificar</h3>").insertAfter("#content h2");
			return false;
		}
		$("input[name='accion']").val("modificar");
	});
	
	/**
	 * Cuando se presiona el boton borrar cursada, se asigna "borrar" al
	 * hidden accion del formulario para que el manejador sepa que operación
	 * desea hacer el usuario.
	 * */
	$("#formBuscarCursadas").on("click", "#btnBorrarCursada", function(event) {
		$("h3#mensaje" ).remove();
		if(!$("input[name='radioCursadas']").is(":checked")) {
			$("<h3 id='mensaje' class='letraNaranja'>Debe seleccionar una cursada a borrar</h3>").insertAfter("#content h2");
			return false;
		}
		$("input[name='accion']").val("borrar");

	});
	
});