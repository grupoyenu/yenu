
$(document).ready(function () {

    $("table#tablaBuscarPermisos").DataTable({
        dom: 'Bfrtip',
        responsive: true,
        language: {url: "./lib/js/Spanish.json"}
    });

    $(".editar").click(function (evento) {
        evento.preventDefault();
        var idPermiso = $(this).attr("name");
        $.ajax({
            type: "POST",
            url: "./app/usuarios/vistas/FormModificarPermiso.php",
            data: "idPermiso=" + idPermiso,
            success: function (data) {
                $("#contenido").html(data);
            },
            error: function (data) {
                console.log(data);
                $("#contenido").html('<div class="alert alert-danger text-center" role="alert"><strong>No se procesó la petición</strong></div>');
            }
        });
    });
    
    $(".borrar").click(function (evento) {
        evento.preventDefault();
        $("#modalIdPermiso").val($(this).attr("name"));
        $("#ModalBorrarPermiso").modal({});
    });
    
    $('#btnBorrarPermiso').click(function () {
        $.ajax({
            type: "POST",
            url: "./app/usuarios/vistas/ProcesarBorrarPermiso.php",
            data: $("#formBorrarPermiso").serialize(),
            success: function (data) {
                $('#cuerpoModal').html(data);
                $('#btnBorrarPermiso').hide();
                $('#btnRefrescarPantalla').show();
            },
            error: function (data) {
                console.log(data);
                $("#cuerpoModal").html('<div class="alert alert-danger text-center" role="alert"><strong>No se procesó la petición</strong></div>');
            }
        });
    });

    $("#btnRefrescarPantalla").click(function () {
        setTimeout(function () {
            location.reload();
        }, 600);
    });

});
