/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$(document).ready(function () {
    
    $("table#tablaInformeAula").DataTable({
        dom: 'Bfrtip',
        responsive: true,
        language: {url: "./app/js/Spanish.json"}
    });
    
});