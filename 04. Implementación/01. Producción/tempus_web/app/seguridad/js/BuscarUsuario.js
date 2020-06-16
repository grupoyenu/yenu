/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$(document).ready(function () {

    buscarUsuarios();

    $("#formBuscarUsuario").submit(function (evento) {
        evento.preventDefault();
        $("#peticion").val("true");
        buscarUsuarios();
    });

    $('#seccionInferior').on('click', '.editar', function (evento) {
        evento.preventDefault();
        var idUsuario = $(this).attr("name");
        var metodo = $(this).parents("tr").find('td:eq(2)').text();
        $.ajax({
            type: "POST",
            url: "./FormModificarUsuario.php",
            data: "idUsuario=" + idUsuario + "&metodo=" + metodo,
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
        $("#modalIdUsuario").val($(this).attr("name"));
        $("#modalMetodo").val($(this).parents("tr").find('td:eq(2)').text());
        $("#ModalBorrarUsuario").modal({});
    });

    $('#btnBorrarUsuario').click(function () {
        $.ajax({
            type: "POST",
            url: "./ProcesarBorrarUsuario.php",
            data: $("#formBorrarUsuario").serialize(),
            success: function (data) {
                $('#cuerpoModal').html(data);
                $('#btnBorrarUsuario').hide();
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

function buscarUsuarios() {
    $.ajax({
        type: "POST",
        url: "./ProcesarBuscarUsuario.php",
        data: $("#formBuscarUsuario").serialize(),
        success: function (data) {
            $("#seccionInferior").html(data);
            $("table#tablaBuscarUsuarios").DataTable({
                dom: 'frtip',
                responsive: true,
                language: {url: "./lib/js/Spanish.json"}
            });
        },
        error: function (data) {
            console.log(data);
            var men = '<strong>No se procesó la petición</strong>';
            var div = '<div class="alert alert-danger text-center" role="alert">' + men + '</div>';
            $("#seccionInferior").html(div);
        }
    });
}
