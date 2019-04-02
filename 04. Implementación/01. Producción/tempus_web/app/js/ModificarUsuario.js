/* 
 * Este archivo JavaScript se encarga de controlar los eventos de FormModificarUsuario.php
 * y de realizar las validaciones correspondientes antes que el formulario sea 
 * enviado al servidor. Se comunica con procesaModificarUsuario.php a traves de
 * AJAX. 
 * 
 * @author Oyarzo Mariela 
 * @author Quiroga Sandra
 * @author Marquez Emanuel
 */
$(document).ready(function () {
    
    /* Se obtienen los valores originales del formulario */
    
    /* Se captura el formulario antes que sea enviado */
    
    $('#formModificarUsuario').submit(function (event) {
        event.preventDefault();
        
    });
    
});
