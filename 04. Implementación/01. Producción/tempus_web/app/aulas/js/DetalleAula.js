/** 
 * Este archivo JavaScript se encarga de controlar los eventos de FormBuscarAula.php
 * y de realizar las validaciones correspondientes antes que el formulario sea 
 * enviado al servidor. Se comunica con procesaBorrarAula.php y procesaModificarAula.js 
 * a traves de AJAX. 
 * 
 * @author Oyarzo Mariela 
 * @author Quiroga Sandra
 * @author Marquez Emanuel
 */
$(document).ready(function () {

    $("table#tablaCursadasAula").DataTable({
        dom: 'Bfrtip',
        buttons: [
            {extend: 'pdfHtml5', download: 'open', title: 'Horarios de aula'},
            {extend: 'excelHtml5'},
            {extend: 'print', text: 'Imprimir'},
            {extend: 'copy', text: 'Copiar'}
        ],
        paging: false,
        responsive: true,
        language: {url: "./lib/js/Spanish.json"}
    });

    $("table#tablaMesasAula").DataTable({
        dom: 'Bfrtip',
        buttons: [
            {extend: 'pdfHtml5', download: 'open', title: 'Mesas de examen de aula'},
            {extend: 'excelHtml5'},
            {extend: 'print', text: 'Imprimir'},
            {extend: 'copy', text: 'Copiar'}
        ],
        paging: false,
        responsive: true,
        language: {url: "./lib/js/Spanish.json"}
    });


});
