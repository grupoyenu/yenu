/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$(document).ready(function () {

    buscarRoles();

    $("#formBuscarRol").submit(function (evento) {
        evento.preventDefault();
        $("#peticion").val("true");
        buscarRoles();
    });

    $('#seccionInferior').on('click', '.editar', function (evento) {
        evento.preventDefault();
        var idRol = $(this).attr("name");
        $.ajax({
            type: "POST",
            url: "./FormModificarRol.php",
            data: "idRol=" + idRol,
            success: function (data) {
                $("#contenido").html(data);
            },
            error: function (data) {
                console.log(data);
                var men = '<i class="fas fa-exclamation-triangle"><strong>No se procesó la petición</strong></i>';
                var div = '<div class="alert alert-danger text-center" role="alert">' + men + '</div>';
                $("#seccionInferior").html(div);
            }
        });
    });

    $('#seccionInferior').on('click', '.borrar', function (evento) {
        evento.preventDefault();
        $("#modalIdRol").val($(this).attr("name"));
        $("#ModalBorrarRol").modal({});
    });

    $('#btnBorrarRol').click(function () {
        $.ajax({
            type: "POST",
            url: "./ProcesarBorrarRol.php",
            data: $("#formBorrarRol").serialize(),
            success: function (data) {
                $('#cuerpoModal').html(data);
                $('#btnBorrarRol').hide();
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

function buscarRoles() {
    $.ajax({
        type: "POST",
        url: "./ProcesarBuscarRol.php",
        data: $("#formBuscarRol").serialize(),
        success: function (data) {
            $("#seccionInferior").html(data);
            $("table#tablaBuscarRoles").DataTable({
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

