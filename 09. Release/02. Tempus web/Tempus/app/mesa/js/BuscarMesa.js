/** 
 * 
 * @author Oyarzo Mariela <marielaoyarzo89@gmail.com>
 * @author Quiroga Sandra <squiroga17@gmail.com>
 * @author Marquez Emanuel <e.m.a-13@hotmail.com>
 */
$(document).ready(function () {

    buscarMesasExamen();

    $("#formBuscarMesa").submit(function (evento) {
        evento.preventDefault();
        $("#peticion").val("true");
        buscarMesasExamen();
    });

    /* 
     * CARGA EL FORMULARIO DE MODIFICACION CUANDO SE PRESIONA EL BOTON EN LA TABLA.
     * Se obtiene el identificador de la mesa que se encuentra cargado en el boton
     * y se envia al procesar para que cargue el formulario de modificacion en el
     * div de contenido.
     */
    $('#seccionInferior').on('click', '.editar', function () {
        var idPlan = $(this).attr("name");
        $.ajax({
            type: "POST",
            url: "./FormModificarMesa.php",
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

    /* 
     * CARGA Y ABRE EL MODAL CON LOS DETALLES DE LA MESA CUANDO SE PRESIONA EL BOTON EN LA TABLA.
     * Se obtiene el numero de columnas de la tabla para establecer la cantidad de llamados
     * de la mesa y los elementos a mostrar por pantalla.
     * */

    $('#seccionInferior').on('click', '.detalle', function () {
        var idPlan = $(this).attr("name");
        $.ajax({
            type: "POST",
            url: "./FormDetalleMesa.php",
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

    /*
     * ABRE EL MODAL DE CONFIRMACION CUANDO SE PRESIONA EL BOTON DE ELIMINAR EN LA TABLA.
     * Se obtiene el identificador de la mesa de examen que se encuentra en el boton
     * y se carga en el formulario que luego se envia por AJAX al procesar. Luego,
     * se muestra el modal por pantalla.
     * */
    $('#seccionInferior').on('click', '.borrar', function (evento) {
        evento.preventDefault();
        var nombreLargoAsignatura = $(this).parents("tr").find('td:eq(4)').text();
        $("#modalIdPlan").val($(this).attr("name"));
        $("#nombreRegistroBorrar").text(nombreLargoAsignatura + ": ");
        $("#ModalBorrarMesa").modal({});
    });

    /*
     * SE CONFIRMA LA ELIMINACION DE LA MESA AL PRESIONAR EL BOTON DEL MODAL.
     * Se obtienen los datos que se cargaron en el formulario de eliminacion y
     * se envian al procesar. El resultado de la operacion se muestra por pantalla
     * dentro del modal.
     * */
    $('#btnBorrarMesa').click(function () {
        $.ajax({
            type: "POST",
            url: "./ProcesarBorrarMesa.php",
            data: $("#formBorrarMesa").serialize(),
            success: function (data) {
                $('#cuerpoModalBorrar').html(data);
                $('#btnBorrarMesa').hide();
                $('#btnCancelarBorrarMesa').hide();
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
        var table = $('#tablaBuscarMesas').DataTable();
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

    /* PERMITE QUE NO SE OCULTE LOS ELEMENTOS DEL DROPDOWN*/
    $('.dropdown-menu').on('click', function (e) {
        e.stopPropagation();
    });

});


function buscarMesasExamen() {

    $.ajax({
        type: "POST",
        url: "./ProcesarBuscarMesa.php",
        data: $("#formBuscarMesa").serialize(),
        success: function (data) {
            $("#seccionInferior").html(data);
            incializarTabla();
        },
        error: function (data) {
            console.log(data);
            var men = '<i class="fas fa-exclamation-triangle"><strong>No se procesó la petición</strong></i>';
            var div = '<div class="alert alert-danger text-center" role="alert">' + men + '</div>';
            $("#seccionInferior").html(div);
        }
    });
}

function incializarTabla() {
    var columnas = $("#tablaBuscarMesas tr").length;
    if (columnas > 11) {
        $("table#tablaBuscarMesas").DataTable({
            dom: 'Bfrtip',
            responsive: true,
            language: { url: "../../../lib/js/Spanish.json" },
            buttons: [
                {
                    extend: 'pdfHtml5',
                    orientation: 'landscape',
                    download: 'open',
                    title: 'TEMPUS Mesas de examen',
                    exportOptions: { columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 12, 13, 14, 15] }
                },
                {
                    extend: 'excelHtml5',
                    title: 'TEMPUS Mesas de examen',
                    exportOptions: { columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 12, 13, 14, 15] }
                },
                {
                    extend: 'print',
                    text: 'Imprimir',
                    title: 'TEMPUS Mesas de examen',
                    exportOptions: { columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 12, 13, 14, 15] },
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
    } else {
        $("table#tablaBuscarMesas").DataTable({
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'pdfHtml5',
                    orientation: 'landscape',
                    download: 'open',
                    title: ' Mesas de examen ',
                    exportOptions: { columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10] }
                },
                { extend: 'excelHtml5', exportOptions: { columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10] } },
                { extend: 'print', text: 'Imprimir', exportOptions: { columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10] } },
                { extend: 'copy', text: 'Copiar' }
            ],
            responsive: true,
            language: { url: "./lib/js/Spanish.json" }
        });
    }
}