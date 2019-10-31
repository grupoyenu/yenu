/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$(document).ready(function () {

    $("table#tablaBuscarRoles").DataTable({
        dom: 'Bfrtip',
        responsive: true,
        language: {url: "./lib/js/Spanish.json"}
    });

    $("#seccionCentral").on("click", "a.detalleRol", function (evento) {
        evento.preventDefault();
        var id = $(this).attr("name");
        $("#ModalDetalleRol").modal({});
        $.ajax({
            type: "POST",
            url: "./app/usuarios/vistas/ProcesarDetalleRol.php",
            data: "id=" + id,
            success: function (data) {
                $("#cuerpoModalDetalle").html(data);
            },
            error: function (data) {
                console.log(data);
                $("#cuerpoModalDetalle").html('<div class="alert alert-danger text-center" role="alert">No se procesó la petición</div>');
            }
        });
    });

});

