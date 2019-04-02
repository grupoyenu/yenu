/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$(document).ready(function () {

    $("table#tablaCursadas").DataTable({
        dom: 'Bfrtip',
        responsive: true,
        language: {url: "./app/js/Spanish.json"}
    });

    $('#btnBorrarCursada').click(function (event) {
        event.preventDefault();
        if (!$("input[name='radioCursadas']").is(":checked")) {
            $("#modalSeleccione").modal();
        } else {
            $("#mdBorrar").modal();
        }
    });

    $('#btnModificarCursada').click(function (event) {
        event.preventDefaul();
        if (!$("input[name='radioCursadas']").is(":checked")) {
             $("#modalSeleccione").modal();
        } else {
            $.ajax({
                type: "POST",
                url: "./app/vistas/FormModificarCursada.php",
                data: $("#formBuscarCursada").serialize(),
                success: function (data) {
                    $("#FormBuscarCursada").empty();
                    $("#FormBuscarCursada").html(data);
                },
                error: function () {
                    $("#resultado").html('<div class="alert alert-danger text-center" role="alert">Error durante la petición por AJAX</div>');
                }
            });
        }
    });

});

