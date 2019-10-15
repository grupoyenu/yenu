
$(document).ready(function () {

    $("#formBuscarPermiso").submit(function (evento) {
        evento.preventDefault();
        $.ajax({
            type: "POST",
            url: "./app/usuarios/vistas/ProcesarBuscarPermiso.php",
            data: $("#formBuscarPermiso").serialize(),
            success: function (data) {
                $('#seccionCentral').html(data);
                $("table#tablaBuscarPermisos").DataTable({
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

    $("#btnCrearPermiso").click(function (evento) {
        evento.preventDefault();
        $("#operacion").val("crear");
        $("#ModalActualizarPermiso").modal({});
    });


    $("#seccionCentral").on("click", "a.editarPermiso", function (evento) {
        evento.preventDefault();
        $("#operacion").val("modificar");
        $("#ModalActualizarPermiso").modal({});
    });

    $("#seccionCentral").on("click", "a.detallePermiso", function (evento) {
        evento.preventDefault();
        var id = $(this).attr("name");
        $("#ModalDetallePermiso").modal({});
        $.ajax({
            type: "POST",
            url: "./app/usuarios/vistas/ProcesarDetallePermiso.php",
            data: "id=" + id,
            success: function (data) {
                $("#cuerpoModalDetalle").html(data);
            },
            error: function (data) {
                console.log(data);
                $("#cuerpoModal").html('<div class="alert alert-danger text-center" role="alert">No se procesó la petición</div>');
            }
        });
    });

    $("#seccionCentral").on("click", "a.borrarPermiso", function (evento) {
        evento.preventDefault();
        $("#ModalBorrarPermiso").modal({});
    });


    $("#formActualizarPermiso").submit(function (evento) {
        evento.preventDefault();
        $.ajax({
            type: "POST",
            dataType: 'json',
            url: "./app/usuarios/vistas/ProcesarActualizarPermiso.php",
            data: $("#formActualizarPermiso").serialize(),
            success: function (data) {
                console.log(data);
                if (data[0]['exito'] === true) {
                    $("#seccionSuperiorModal").html(data[0]['div']);
                    $("#seccionCentralModal").empty();
                    $("#seccionInferiorModal").css("display", "block");
                } else {
                    $("#seccionSuperiorModal").html(data);
                }
            },
            error: function (data) {
                console.log(data);
                $("#seccionInferiorModal").html('<div class="alert alert-danger text-center" role="alert">No se procesó la petición</div>');
            }
        });
    });

    $("#btnRefrescar").click(function (evento) {
        evento.preventDefault();
        setTimeout(function () {
            location.reload();
        }, 1000);
    });

});
