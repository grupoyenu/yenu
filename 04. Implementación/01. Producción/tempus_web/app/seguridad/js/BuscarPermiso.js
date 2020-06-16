
$(document).ready(function () {

    buscarPermisos();

    $("#formBuscarPermiso").submit(function (evento) {
        evento.preventDefault();
        $("#peticion").val("true");
        buscarPermisos();
    });

    $('#seccionInferior').on('click', '.editar', function (evento) {
        evento.preventDefault();
        var idPermiso = $(this).attr("name");
        $.ajax({
            type: "POST",
            url: "./FormModificarPermiso.php",
            data: "idPermiso=" + idPermiso,
            success: function (data) {
                $("#contenido").html(data);
            },
            error: function (data) {
                console.log(data);
                var men = '<i class="fas fa-exclamation-triangle"><strong>No se procesó la petición</strong></i>';
                var div = '<div class="alert alert-danger text-center" role="alert">' + men + '</div>';
                $("#contenido").html(div);
            }
        });
    });

    $('#seccionInferior').on('click', '.borrar', function (evento) {
        evento.preventDefault();
        $("#modalIdPermiso").val($(this).attr("name"));
        $("#ModalBorrarPermiso").modal({});
    });

    $('#btnBorrarPermiso').click(function () {
        $.ajax({
            type: "POST",
            url: "./ProcesarBorrarPermiso.php",
            data: $("#formBorrarPermiso").serialize(),
            success: function (data) {
                $('#cuerpoModal').html(data);
                $('#btnBorrarPermiso').hide();
                $('#btnRefrescarPantalla').show();
            },
            error: function (data) {
                console.log(data);
                var men = '<i class="fas fa-exclamation-triangle"><strong>No se procesó la petición</strong></i>';
                var div = '<div class="alert alert-danger text-center" role="alert">' + men + '</div>';
                $("#cuerpoModal").html(div);
            }
        });
    });

    $("#btnRefrescarPantalla").click(function () {
        setTimeout(function () {
            location.reload();
        }, 600);
    });

});

function buscarPermisos() {
    $.ajax({
        type: "POST",
        url: "./ProcesarBuscarPermiso.php",
        data: $("#formBuscarPermiso").serialize(),
        success: function (data) {
            $("#seccionInferior").html(data);
            $("table#tablaBuscarPermisos").DataTable({
                dom: 'frtip',
                responsive: true,
                language: {url: "./lib/js/Spanish.json"}
            });
        },
        error: function (data) {
            console.log(data);
            var men = '<i class="fas fa-exclamation-triangle"><strong>No se procesó la petición</strong></i>';
            var div = '<div class="alert alert-danger text-center" role="alert">' + men + '</div>';
            $("#seccionInferior").html(div);
        }
    });
}