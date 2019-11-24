/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$(document).ready(function () {

    $("table#tablaBuscarRoles").DataTable({
        dom: 'frtip',
        responsive: true,
        language: {url: "./lib/js/Spanish.json"}
    });

    $(".editar").click(function (evento) {
        evento.preventDefault();
        var idRol = $(this).attr("name");
        $.ajax({
            type: "POST",
            url: "./app/usuarios/vistas/FormModificarRol.php",
            data: "idRol=" + idRol,
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
        $("#modalIdRol").val($(this).attr("name"));
        $("#ModalBorrarRol").modal({});
    });

    $('#btnBorrarRol').click(function () {
        $.ajax({
            type: "POST",
            url: "./app/usuarios/vistas/ProcesarBorrarRol.php",
            data: $("#formBorrarRol").serialize(),
            success: function (data) {
                $('#cuerpoModal').html(data);
                $('#btnBorrarRol').hide();
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

