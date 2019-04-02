/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$(document).ready(function () {
    
    
    $('form#formSeleccionarMesas').submit(function () {

        $("h3#mensaje").remove();
        var archivo = $('input#fileMesas').val();

        /** Controla si no se ha seleccionado un archivo */
        if (archivo == '') {
            $("<h3 id='mensaje' class='letraNaranja'>Antes de importar debe seleccionar un archivo csv</h3>").insertAfter("#content h2");
            return false;
        }

        /** Controla si el archivo seleccionado es CSV */
        if (document.getElementById("fileMesas").value.toLowerCase().lastIndexOf(".csv") == -1) {
            $("<h3 id='mensaje' class='letraNaranja'>Se debe seleccionar un archivo cuyo formato sea csv</h3>").insertAfter("#content h2");
            return false;
        }

        /** Controla los ultimos 4 elementos del nombre del archivo para saber la extension */
        if (archivo.substring(archivo.length - 4, archivo.length) != '.csv') {
            $("<h3 id='mensaje' class='letraNaranja'>Se debe seleccionar un archivo cuyo formato sea csv</h3>").insertAfter("#content h2");
            return false;
        }
    });
    
});
