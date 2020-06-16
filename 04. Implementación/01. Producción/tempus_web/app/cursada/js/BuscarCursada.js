/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$(document).ready(function () {

    buscarCursada();

    $("#formBuscarCursada").submit(function (evento) {
        evento.preventDefault();
        $("#peticion").val("true");
        buscarCursada();
    });

    $('#seccionInferior').on('click', '.detalle', function () {
        var nombreCortoCarrera = $(this).parents("tr").find('td:eq(1)').text();
        var nombreLargoCarrera = $(this).parents("tr").find('td:eq(2)').text();
        var nombreCortoAsignatura = $(this).parents("tr").find('td:eq(3)').text();
        var nombreLargoAsignatura = $(this).parents("tr").find('td:eq(4)').text();
        $("#mdcCodigoCarrera").val($(this).parents("tr").find('td:eq(0)').text());
        $("#mdcNombreCarrera").val(nombreLargoCarrera + " (" + nombreCortoCarrera + ")");
        $("#mdcNombreAsignatura").val(nombreLargoAsignatura + " (" + nombreCortoAsignatura + ")");
        $("#mdcAnio").val($(this).parents("tr").find('td:eq(5)').text() + "° año");
        $("#mdcLunes").val($(this).parents("tr").find('td:eq(6)').text());
        $("#mdcMartes").val($(this).parents("tr").find('td:eq(12)').text());
        $("#mdcMiercoles").val($(this).parents("tr").find('td:eq(18)').text());
        $("#mdcJueves").val($(this).parents("tr").find('td:eq(24)').text());
        $("#mdcViernes").val($(this).parents("tr").find('td:eq(30)').text());
        $("#mdcSabado").val($(this).parents("tr").find('td:eq(36)').text());
        $("#ModalDetalleCursada").modal({});
    });

    $('#seccionInferior').on('click', '.editar', function () {
        var idPlan = $(this).attr("name");
        $.ajax({
            type: "POST",
            url: "./FormModificarCursada.php",
            data: "idPlan=" + idPlan,
            success: function (data) {
                $('#contenido').html(data);
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
        $("#modalIdPlan").val($(this).attr("name"));
        $("#ModalBorrarCursada").modal({backdrop: 'static', keyboard: false});
    });

    $('#btnBorrarCursada').click(function () {
        $.ajax({
            type: "POST",
            url: "./ProcesarBorrarCursada.php",
            data: $("#formBorrarCursada").serialize(),
            success: function (data) {
                $('#cuerpoModalBorrar').html(data);
                $('#btnBorrarCursada').hide();
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


function buscarCursada() {
    $.ajax({
        type: "POST",
        url: "./ProcesarBuscarCursada.php",
        data: $("#formBuscarCursada").serialize(),
        success: function (data) {
            $("#seccionInferior").html(data);
            $("table#tablaBuscarCursadas").DataTable({
                dom: 'Bfrtip',
                buttons: [
                    {extend: 'pdfHtml5',
                        orientation: 'landscape',
                        download: 'open',
                        title: ' Horarios de cursada '
                    },
                    {extend: 'excelHtml5'},
                    {extend: 'print',
                        text: 'Imprimir',
                        customize: function (win) {
                            $(win.document.body).css('font-size', '10pt');
                            $(win.document.body).find('table')
                                    .addClass('compact')
                                    .css('font-size', 'inherit');
                        }
                    },
                    {extend: 'copy', text: 'Copiar'}
                ],
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

