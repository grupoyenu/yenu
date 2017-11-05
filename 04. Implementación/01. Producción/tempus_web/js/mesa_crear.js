/**
 * Este archivo contiene el codigo necesario para realizar los controles del formulario
 * para crear una nueva mesa de examen, antes que sea enviado al servidor.
 * Para ello se hace uso de la biblioteca JQuery.
 * 
 * @see jQuery
 * 
 * @author Marquez Emanuel.
 */

$(document).ready(function() {
	
	/** Captura el submit para controlar el archivo que se ha seleccionado */
	$('form#formCrearMesa').submit(function() {	
		
		$("h3#mensaje" ).remove();
		var mensaje = "";
		
		var codigocarrera = $('input#codigoCarrera').val();
		if (codigocarrera == '' || codigocarrera == null) {
			mensaje = "El código de carrera es un campo obligatorio";
			$("<h3 id='mensaje' class='letraNaranja'>"+mensaje+"</h3>").insertAfter( "#content h2" );
			$('html,body').animate({scrollTop: $("#content").offset().top}, 300);
			return false;
		}
		
		var nombrecarrera = $('input#txtCarrera').val();
		if (nombrecarrera == '' || nombrecarrera == null) {
			mensaje = "El nombre de carrera es un campo obligatorio";
			$("<h3 id='mensaje' class='letraNaranja'>"+mensaje+"</h3>").insertAfter( "#content h2" );
			$('html,body').animate({scrollTop: $("#content").offset().top}, 300);
			return false;
		}
		
		var nombreasignatura = $('input#txtAsignatura').val();
		if (nombreasignatura == '' || nombreasignatura == null) {
			mensaje = "El nombre de asignatura es un campo obligatorio";
			$("<h3 id='mensaje' class='letraNaranja'>"+mensaje+"</h3>").insertAfter( "#content h2" );
			$('html,body').animate({scrollTop: $("#content").offset().top}, 300);
			return false;
		}
		
		var presidente = $('input#txtNombrePresidente').val();
		if (presidente == '' || presidente == null) {
			mensaje = "El presidente de tribunal es un campo obligatorio";
			$("<h3 id='mensaje' class='letraNaranja'>"+mensaje+"</h3>").insertAfter( "#content h2" );
			$('html,body').animate({scrollTop: $("#content").offset().top}, 300);
			return false;
		}
		
		var vocal1 = $('input#txtNombreVocal1').val();
		if (vocal1 == '' || vocal1 == null) {
			mensaje = "El vocal primero de tribunal es un campo obligatorio";
			$("<h3 id='mensaje' class='letraNaranja'>"+mensaje+"</h3>").insertAfter( "#content h2" );
			$('html,body').animate({scrollTop: $("#content").offset().top}, 300);
			return false;
		}
		
		var sector = $('input#txtSector').val();
		if (sector == '' || sector == null) {
			mensaje = "El sector es un campo obligatorio";
			$("<h3 id='mensaje' class='letraNaranja'>"+mensaje+"</h3>").insertAfter( "#content h2" );
			$('html,body').animate({scrollTop: $("#content").offset().top}, 300);
			return false;
		}
		
		var nombreaula = $('input#txtNombreAula').val();
		if (nombreaula == '' || nombreaula == null) {
			mensaje = "El nombre de aula es un campo obligatorio";
			$("<h3 id='mensaje' class='letraNaranja'>"+mensaje+"</h3>").insertAfter( "#content h2" );
			$('html,body').animate({scrollTop: $("#content").offset().top}, 300);
			return false;
		}
	});
	
});