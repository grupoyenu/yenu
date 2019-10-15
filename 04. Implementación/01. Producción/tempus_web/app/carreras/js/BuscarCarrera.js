/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$(document).ready(function () {

    $("#formBuscarCarrera").submit(function (evento) {
        evento.preventDefault();
        $.ajax({
            type: "POST",
            url: "./app/carreras/vistas/ProcesarBuscarCarrera.php",
            data: $("#formBuscarCarrera").serialize(),
            success: function (data) {
                $('#seccionCentral').html(data);
                $("table#tablaBuscarCarreras").DataTable({
                    dom: 'Bfrtip',
                    responsive: true,
                    language: {url: "./lib/js/Spanish.json"}
                });
            },
            error: function (data) {
                console.log(data);
                $("#seccionCentral").html('<div class="alert alert-danger text-center" role="alert">No se procesó la petición</div>');
            }
        });
    });

    $("#seccionCentral").on("click", "a.detalleCarrera", function (evento) {
        evento.preventDefault();
        var id = $(this).attr("name");
        $("#ModalDetalleCarrera").modal({});
        $.ajax({
            type: "POST",
            url: "./app/carreras/vistas/ProcesarDetalleCarrera.php",
            data: "id=" + id,
            success: function (data) {
                $("#cuerpoModal").html(data);
            },
            error: function (data) {
                console.log(data);
                $("#cuerpoModal").html('<div class="alert alert-danger text-center" role="alert">No se procesó la petición</div>');
            }
        });
    });

    $("#seccionCentral").on("click", "a.agregarAsignatura", function (evento) {
        evento.preventDefault();
        $("#codigo").val($(this).attr("name"));
        $("#fmBuscarCarrera").submit();
    });


});