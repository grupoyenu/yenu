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
        var idPlan = $(this).attr("name");
        $.ajax({
            type: "POST",
            url: "./FormDetalleCursada.php",
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

    $('#seccionInferior').on('click', '.agregar', function () {
        var idPlan = $(this).attr("name");
        $.ajax({
            type: "POST",
            url: "./FormAgregarClase.php",
            data: "idPlan=" + idPlan,
            success: function (data) {
                $('#contenido').html(data);
            },
            error: function (data) {
                console.log(data);
                var men = "<i class='fas fa-exclamation-triangle'><strong>No se procesó la petición</strong></i>";
                var div = '<div class="alert alert-danger text-center" role="alert">' + men + '</div>';
                $("#seccionInferior").html(div);
            }
        });
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
        var nombreLargoAsignatura = $(this).parents("tr").find('td:eq(4)').text();
        $("#modalIdPlan").val($(this).attr("name"));
        $("#nombreRegistroBorrar").text(nombreLargoAsignatura + ": ");
        $("#ModalBorrarCursada").modal({ backdrop: 'static', keyboard: false });
    });

    $('#btnBorrarCursada').click(function () {
        $.ajax({
            type: "POST",
            url: "./ProcesarBorrarCursada.php",
            data: $("#formBorrarCursada").serialize(),
            success: function (data) {
                $('#cuerpoModalBorrar').html(data);
                $('#btnBorrarCursada').hide();
                $('#btnCancelarBorrarCursada').hide();
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


    $('#seccionInferior').on('change', '.col_checkbox', function () {
        var clase = $(this).val();
        var table = $('#tablaBuscarCursadas').DataTable();
        var col = table.columns('.' + clase);
        if ($(this).prop('checked')) {
            $('.' + clase).show();
            col.nodes().flatten().to$().show();
        } else {
            $('.' + clase).hide();
            col.nodes().flatten().to$().hide();
        }

        /* SE VERIFICA CANTIDAD DE CHECKBOX TILDADOS */
        var checked = $('input:checkbox:checked').length;
        if (checked > 1) {
            $('input:checkbox:checked').each(function () {
                $(this).removeAttr("disabled");
            });
        } else {
            $('input:checkbox:checked').each(function () {
                $(this).attr("disabled", true);
            });
        }
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
                responsive: true,
                language: { url: "../../../lib/js/Spanish.json" },
                buttons: [
                    {
                        extend: 'pdfHtml5',
                        orientation: 'landscape',
                        download: 'open',
                        title: 'TEMPUS Horarios de cursada'
                    },
                    {
                        extend: 'excelHtml5',
                        title: 'TEMPUS Horarios de cursada'
                    },
                    {
                        extend: 'print',
                        text: 'Imprimir',
                        title: 'TEMPUS Horarios de cursada',
                        customize: function (win) {
                            $(win.document.body).css('font-size', '10pt');
                            $(win.document.body).find('table')
                                .addClass('compact')
                                .css('font-size', 'inherit');
                        }
                    },
                    { extend: 'copy', text: 'Copiar' }
                ]
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

