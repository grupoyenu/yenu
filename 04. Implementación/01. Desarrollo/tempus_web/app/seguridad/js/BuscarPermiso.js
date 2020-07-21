
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
        var nombre = $(this).parents("tr").find('td:eq(0)').text();
        $("#modalIdPermiso").val($(this).attr("name"));
        $("#nombreRegistroBorrar").text(nombre + ": ");
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
                $('#btnCancelarBorrarPermiso').hide();
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

});

function buscarPermisos() {
    $.ajax({
        type: "POST",
        url: "./ProcesarBuscarPermiso.php",
        data: $("#formBuscarPermiso").serialize(),
        success: function (data) {
            $("#seccionInferior").html(data);
            $("table#tablaBuscarPermisos").DataTable({
                dom: 'Bfrtip',
                responsive: true,
                language: {url: "../../../lib/js/Spanish.json"},
                buttons: [
                    {extend: 'pdfHtml5',
                        download: 'open',
                        exportOptions: {columns: [0, 1]},
                        title: 'TEMPUS Permisos'
                    },
                    {extend: 'excelHtml5',
                        exportOptions: {columns: [0, 1]},
                        title: 'TEMPUS Permisos'},
                    {extend: 'print',
                        text: 'Imprimir',
                        exportOptions: {columns: [0, 1]},
                        customize: function (win) {
                            $(win.document.body).css('font-size', '12pt');
                            $(win.document.body).find('table')
                                    .addClass('compact')
                                    .css('font-size', 'inherit');
                        }
                    },
                    {extend: 'copy', text: 'Copiar'}
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