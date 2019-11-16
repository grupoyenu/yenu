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

    $(".editar").click(function (evento) {
        evento.preventDefault();
        var idUsuario = $(this).attr("name");
        var metodo = $(this).parents("tr").find('td:eq(2)').text();
        $.ajax({
            type: "POST",
            url: "./app/usuarios/vistas/FormModificarUsuario.php",
            data: "idUsuario=" + idUsuario + "&metodo=" + metodo,
            success: function (data) {
                $("#contenido").html(data);
            },
            error: function (data) {
                console.log(data);
                $("#seccionInferior").html('<div class="alert alert-danger text-center" role="alert"><strong>No se procesó la petición</strong></div>');
            }
        });
    });

    $(".borrar").click(function (evento) {
        evento.preventDefault();
        $("#modalIdUsuario").val($(this).attr("name"));
        $("#modalMetodo").val($(this).parents("tr").find('td:eq(2)').text());
        $("#ModalBorrarUsuario").modal({});
    });

    $('#btnBorrarUsuario').click(function () {
        $.ajax({
            type: "POST",
            url: "./app/usuarios/vistas/ProcesarBorrarUsuario.php",
            data: $("#formBorrarUsuario").serialize(),
            success: function (data) {
                $('#cuerpoModal').html(data);
                $('#btnBorrarUsuario').hide();
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
