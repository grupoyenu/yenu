/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).ready(function () {

    $("table#tablaBuscarAsignaturas").DataTable({
        dom: 'Bfrtip',
        responsive: true,
        language: {url: "./lib/js/Spanish.json"}
    });

    $(".detalle").click(function () {
        var idAsignatura = $(this).attr("name");
        var nombre = $(this).parents("tr").find("td").eq(0).html();
        $.ajax({
            type: "POST",
            url: "./app/asignaturas/vistas/FormDetalleAsignatura.php",
            data: "idAsignatura=" + idAsignatura + "&nombre=" + nombre,
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
