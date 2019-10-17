/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$(document).ready(function () {

    $("table#tablaBuscarCursadas").DataTable({
        dom: 'Bfrtip',
        responsive: true,
        language: {url: "./lib/js/Spanish.json"}
    });


    $(".detalle").click(function () {
        $(this).parents("tr").each(function (i) {
            alert(i + " " + $(this).find('td').text());
        });

      
    });
});

