/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).ready(function () {

    $(".custom-file-input").on("change", function () {
        var fileName = $(this).val().split("\\").pop();
        $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
    });

    $('form#formSeleccionarMesa').submit(function () {
        $("seccionResultado").empty();
        var archivo = $('input#fileMesas').val();
        /** Controla si no se ha seleccionado un archivo */
        if (archivo === '') {
            var men = "<strong>Seleccione un archivo .CSV</strong>";
            var div = '<div class="alert alert-danger text-center" role="alert">' + mensaje + '</div>';
            $("#seccionResultado").html(div);
            return false;
        }
        /** Controla si el archivo seleccionado es CSV */
        if (document.getElementById("fileMesas").value.toLowerCase().lastIndexOf(".csv") === -1) {
            var men = "<strong>Se debe seleccionar un archivo cuyo formato sea .CSV</strong>";
            var div = '<div class="alert alert-danger text-center" role="alert">' + men + '</div>';
            $("#seccionResultado").html(div);
            return false;
        }
        /** Controla los ultimos 4 elementos del nombre del archivo para saber la extension */
        if (archivo.substring(archivo.length - 4, archivo.length) !== '.csv') {
            var men = "<strong>Se debe seleccionar un archivo cuyo formato sea .CSV</strong>";
            var div = '<div class="alert alert-danger text-center" role="alert">' + men + '</div>';
            $("#seccionResultado").html(div);
            return false;
        }
    });

});


