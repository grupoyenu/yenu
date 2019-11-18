/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$(document).ready(function () {

    $("table#tablaBuscarCursadas").DataTable({
        dom: 'Bfrtip',
        responsive: true,
        language: {url: "./lib/js/Spanish.json"}
    });

    $(".detalle").click(function () {
        $("#mdcCodigoCarrera").val($(this).parents("tr").find('td:eq(0)').text());
        $("#mdcNombreCarrera").val($(this).parents("tr").find('td:eq(1)').text());
        $("#mdcNombreAsignatura").val($(this).parents("tr").find('td:eq(2)').text());
        $("#mdcLunes").val($(this).parents("tr").find('td:eq(3)').text());
        $("#mdcMartes").val($(this).parents("tr").find('td:eq(4)').text());
        $("#mdcMiercoles").val($(this).parents("tr").find('td:eq(5)').text());
        $("#mdcJueves").val($(this).parents("tr").find('td:eq(6)').text());
        $("#mdcViernes").val($(this).parents("tr").find('td:eq(7)').text());
        $("#mdcSabado").val($(this).parents("tr").find('td:eq(8)').text());
        $("#ModalDetalleCursada").modal({});
    });

    $(".editar").click(function () {
        var idCarrera = $(this).attr("name");
        var idAsignatura = $(this).attr("id");
        $.ajax({
            type: "POST",
            url: "./app/cursadas/vistas/FormModificarCursada.php",
            data: "idCarrera=" + idCarrera + "&idAsignatura=" + idAsignatura,
            success: function (data) {
                $('#contenido').html(data);
            },
            error: function (data) {
                console.log(data);
                $("#contenido").html('<div class="alert alert-danger text-center" role="alert">No se procesó la petición</div>');
            }
        });
    });

    $(".borrar").click(function (evento) {
        evento.preventDefault();
        $("#modalIdCarrera").val($(this).attr("name"));
        $("#modalIdAsignatura").val($(this).attr("id"));
        $("#ModalBorrarCursada").modal({backdrop: 'static', keyboard: false});
    });

    $('#btnBorrarCursada').click(function () {
        $.ajax({
            type: "POST",
            url: "./app/cursadas/vistas/ProcesarBorrarCursada.php",
            data: $("#formBorrarCursada").serialize(),
            success: function (data) {
                $('#cuerpoModalBorrar').html(data);
                $('#btnBorrarCursada').hide();
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

