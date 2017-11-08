/**
 * Este archivo contiene el codigo necesario para realizar los controles del 
 * formulario para modificar una mesa de examen, antes que sea enviado al servidor.
 * Para ello se hace uso de la biblioteca JQuery.
 * 
 * @see jQuery
 * 
 * @author Marquez Emanuel.
 */

$(document).ready(function() {
	
	/** Cuando se carga el formulario almacena la informacion original
	 * 	para luego realizar la verificación que se ha modificado alguno
	 *  de los campos.
	 *  orig = original.
	 */
	var orig_presidente = $('input#txtNombrePresidente').val().toLowerCase();
	var orig_vocal1 = $('input#txtNombreVocal1').val().toLowerCase();
	var orig_vocal2 = $('input#txtNombreVocal2').val().toLowerCase();
	var orig_suplente = $('input#txtNombreSuplente').val().toLowerCase();
	var orig_primero = $('input#datePrimerLlamado').val();
	var orig_segundo = $('input#dateSegundoLlamado').val();
	var orig_sector = $('input#txtSector').val();
	var orig_aula = $('input#txtNombreAula').val().toLowerCase();
	var orig_horario = $('select#selectHora').val();
	
	/** Captura el submit para hacer las validaciones al formulario  */
	
	$('form#formModificarMesa').submit(function() {
		
		var presidente = $('input#txtNombrePresidente').val().toLowerCase();
		var vocal1 = $('input#txtNombreVocal1').val().toLowerCase();
		var vocal2 = $('input#txtNombreVocal2').val().toLowerCase();
		var suplente = $('input#txtNombreSuplente').val().toLowerCase();
		var primero = $('input#datePrimerLlamado').val();
		var segundo = $('input#dateSegundoLlamado').val();
		var sector = $('input#txtSector').val();
		var aula = $('input#txtNombreAula').val().toLowerCase();
		var horario = $('select#selectHora').val();
		
		$("h3#mensaje" ).remove();
		
		/* Controla que se haya realizado al menos un cambio en el formulario */
		if (presidente == orig_presidente) {
			if (vocal1 == orig_vocal1) {
				if (vocal2 == orig_vocal2) {
					if (suplente == orig_suplente) {
						if (primero == orig_primero) {
							if (segundo == orig_segundo) {
								if (sector == orig_sector) {
									if (aula == orig_aula) {
										if (horario == orig_horario) {
											$("<h3 id='mensaje' class='letraNaranja'>No se han detectado cambios en el formulario</h3>").insertAfter( "#content h2" );
											$('html,body').animate({scrollTop: $("#content").offset().top}, 300);
											return false;
										}
									}
								}
							}
						}
					}
				}
			}
		}
		/* Se ha detectado al menos un cambio por eso llega a este punto */
		
		if (presidente == vocal1) {
			$("<h3 id='mensaje' class='letraNaranja'>El nombre del Presidente coincide con el nombre del Vocal 1</h3>").insertAfter( "#content h2" );
			$('html,body').animate({scrollTop: $("#content").offset().top}, 300);
			return false;
		}
		
		if (presidente == vocal2) {
			$("<h3 id='mensaje' class='letraNaranja'>El nombre del Presidente coincide con el nombre del Vocal 2</h3>").insertAfter( "#content h2" );
			$('html,body').animate({scrollTop: $("#content").offset().top}, 300);
			return false;
		}
		
		if (presidente == suplente) {
			$("<h3 id='mensaje' class='letraNaranja'>El nombre del Presidente coincide con el nombre del Suplente</h3>").insertAfter( "#content h2" );
			$('html,body').animate({scrollTop: $("#content").offset().top}, 300);
			return false;
		}
		
		if (vocal1 == vocal2) {
			$("<h3 id='mensaje' class='letraNaranja'>El nombre del Vocal 1 coincide con el nombre del Vocal 2</h3>").insertAfter( "#content h2" );
			$('html,body').animate({scrollTop: $("#content").offset().top}, 300);
			return false;
		}
		
		if (vocal1 == suplente) {
			$("<h3 id='mensaje' class='letraNaranja'>El nombre del Vocal 1 coincide con el nombre del Suplente</h3>").insertAfter( "#content h2" );
			$('html,body').animate({scrollTop: $("#content").offset().top}, 300);
			return false;
		}
		
		if(vocal2 && suplente) {
			if(vocal2 == suplente) {
				$("<h3 id='mensaje' class='letraNaranja'>El nombre del Vocal 2 coincide con el nombre del Suplente</h3>").insertAfter( "#content h2" );
				$('html,body').animate({scrollTop: $("#content").offset().top}, 300);
				return false;
			}
		}
		
		if (!primero && !segundo) {
			$("<h3 id='mensaje' class='letraNaranja'>Debe indicar una fecha de llamado</h3>").insertAfter( "#content h2" );
			$('html,body').animate({scrollTop: $("#content").offset().top}, 300);
			return false;
		}
		
	});
		
});