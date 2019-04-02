/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$(document).ready(function () {

    $("table#tablaMesasExamen").DataTable({
        dom: 'Bfrtip',
        responsive: true,
        language: {url: "./app/js/Spanish.json"}
    });

    $('#btnBorrarMesa').click(function (event) {
        event.preventDefault();
        if (!$("input[name='radioMesas']").is(":checked")) {
            $("#modalSeleccione").modal();
        } else {
            $("#mdBorrar").modal();
        }
    });

    $('#btnConfirmarEliminacion').click(function () {
        $.ajax({
            type: "POST",
            url: "./app/vistas/procesaBorrarMesa.php",
            data: $("#formBuscarMesa").serialize(),
            success: function (data) {
                $("#resultado").empty();
                $("#resultado").html(data);
            },
            error: function () {
                var mensaje = "Error durante la petición por AJAX";
                $("#resultado").html('<div class="alert alert-danger text-center" role="alert">' + mensaje + '</div>');
            }
        });
        $("#mdBorrar").modal('toggle');
    });

    $('#btnModificarMesa').click(function (event) {
        event.preventDefaul();
        if (!$("input[name='radioMesas']").is(":checked")) {
            $("#modalSeleccione").modal();
        } else {
            $.ajax({
                type: "POST",
                url: "./app/vistas/FormModificarMesa.php",
                data: $("#formBuscarMesa").serialize(),
                success: function (data) {
                    $("#FormBuscarMesa").empty();
                    $("#FormBuscarMesa").html(data);
                },
                error: function () {
                    var mensaje = "Error durante la petición por AJAX";
                    $("#resultado").html('<div class="alert alert-danger text-center" role="alert">' + mensaje + '</div>');
                }
            });
        }
    });

});