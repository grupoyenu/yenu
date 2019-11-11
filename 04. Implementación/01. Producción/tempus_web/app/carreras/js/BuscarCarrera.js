/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$(document).ready(function () {

    $("table#tablaBuscarCarreras").DataTable({
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'pdfHtml5',
                orientation: 'landscape',
                pageSize: 'LEGAL',
                download: 'open',
                text: 'Descargar PDF',
                title: ' Mesas de examen '

            },
            'excel',
            'csvHtml5'
        ],
        responsive: true,
        language: {url: "./lib/js/Spanish.json"}
    });

    $(".detalle").click(function () {
        var codigo = $(this).attr("name");
        var nombre = $(this).parents("tr").find("td").eq(1).html();
        $.ajax({
            type: "POST",
            url: "./app/carreras/vistas/FormDetalleCarrera.php",
            data: "codigo=" + codigo + "&nombre=" + nombre,
            success: function (data) {
                $('#contenido').html(data);
            },
            error: function (data) {
                console.log(data);
                $("#seccionInferior").html('<div class="alert alert-danger text-center" role="alert">No se procesó la petición</div>');
            }
        });
    });

    $(".agregar").click(function () {
        var codigo = $(this).attr("name");
        var nombre = $(this).parents("tr").find("td").eq(1).html();
        $.ajax({
            type: "POST",
            url: "./app/carreras/vistas/FormAgregarAsignatura.php",
            data: "codigo=" + codigo + "&nombre=" + nombre,
            success: function (data) {
                $('#contenido').html(data);
            },
            error: function (data) {
                console.log(data);
                $("#seccionInferior").html('<div class="alert alert-danger text-center" role="alert">No se procesó la petición</div>');
            }
        });
    });


});