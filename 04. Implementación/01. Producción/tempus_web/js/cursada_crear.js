/**
 * Este archivo contiene el codigo necesario para realizar los controles del formulario
 * para crear un nuevo horariod de cursada, antes que sea enviado al servidor.
 * Para ello se hace uso de la biblioteca JQuery.
 * 
 * @see jQuery
 * 
 * @author Marquez Emanuel.
 */

$(document).ready(function() {
	
	$('#cbDiasClase').each(function(){
        if( this.attr('checked')) {
                    alert("pre");
                }
    });
      /*
	$('#cbDiasClase').click(function() {	
		
		alert($('cbDiasClase:checked').val());
		
		
		
	});
	*/
	
});