/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).ready(function () {

    incializarTabla();

    function incializarTabla() {
        var columnas = $("#tablaBuscarMesas tr").length;
        if (columnas > 11) {
            $("table#tablaBuscarMesas").DataTable({
                dom: 'Bfrtip',
                buttons: [
                    {extend: 'pdfHtml5',
                        orientation: 'landscape',
                        download: 'open',
                        title: ' Mesas de examen ',
                        exportOptions: {columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 12, 13, 14, 15]}
                    },
                    {extend: 'excelHtml5', exportOptions: {columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 12, 13, 14, 15]}},
                    {extend: 'print', text: 'Imprimir'},
                    {extend: 'copy', text: 'Copiar'}
                ],
                responsive: true,
                language: {url: "./lib/js/Spanish.json"}
            });
        } else {
            $("table#tablaBuscarMesas").DataTable({
                dom: 'Bfrtip',
                buttons: [
                    {extend: 'pdfHtml5',
                        orientation: 'landscape',
                        download: 'open',
                        title: ' Mesas de examen ',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10]
                        }
                    },
                    {extend: 'excelHtml5', exportOptions: {columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10]}},
                    {extend: 'print', text: 'Imprimir'},
                    {extend: 'copy', text: 'Copiar'}
                ],
                responsive: true,
                language: {url: "./lib/js/Spanish.json"}
            });
        }
    }

    /* 
     * CARGA EL FORMULARIO DE MODIFICACION CUANDO SE PRESIONA EL BOTON EN LA TABLA.
     * Se obtiene el identificador de la mesa que se encuentra cargado en el boton
     * y se envia al procesar para que cargue el formulario de modificacion en el
     * div de contenido.
     */
    $('.editar').click(function () {
        var idMesa = $(this).attr("name");
        $.ajax({
            type: "POST",
            url: "./app/mesas/vistas/FormModificarMesa.php",
            data: "idMesa=" + idMesa,
            success: function (data) {
                $('#contenido').html(data);
            },
            error: function (data) {
                console.log(data);
                $("#contenido").html('<div class="alert alert-danger text-center" role="alert"><strong>No se procesó la petición<strong></div>');
            }
        });
    });

    /* 
     * CARGA Y ABRE EL MODAL CON LOS DETALLES DE LA MESA CUANDO SE PRESIONA EL BOTON EN LA TABLA.
     * Se obtiene el numero de columnas de la tabla para establecer la cantidad de llamados
     * de la mesa y los elementos a mostrar por pantalla.
     * */

    $(".detalle").click(function () {
        var columnas = $("#tablaBuscarMesas tr").length;
        $("#mdmCodigoCarrera").val($(this).parents("tr").find('td:eq(0)').text());
        $("#mdmNombreCarrera").val($(this).parents("tr").find('td:eq(1)').text());
        $("#mdmNombreAsignatura").val($(this).parents("tr").find('td:eq(2)').text());
        $("#mdmPresidente").val($(this).parents("tr").find('td:eq(3)').text());
        $("#mdmVocal1").val($(this).parents("tr").find('td:eq(4)').text());
        $("#mdmVocal2").val($(this).parents("tr").find('td:eq(5)').text());
        $("#mdmSuplente").val($(this).parents("tr").find('td:eq(6)').text());
        $("#mdmFechaPrimero").val($(this).parents("tr").find('td:eq(7)').text());
        $("#mdmHoraPrimero").val($(this).parents("tr").find('td:eq(8)').text());
        $("#mdmSectorPrimero").val($(this).parents("tr").find('td:eq(9)').text());
        $("#mdmAulaPrimero").val($(this).parents("tr").find('td:eq(10)').text());
        $("#mdmEdicionPrimero").val($(this).parents("tr").find('td:eq(11)').text());
        if (columnas > 11) {
            $("#mdmFechaSegundo").val($(this).parents("tr").find('td:eq(7)').text());
            $("#mdmHoraSegundo").val($(this).parents("tr").find('td:eq(8)').text());
            $("#mdmSectorSegundo").val($(this).parents("tr").find('td:eq(9)').text());
            $("#mdmAulaSegundo").val($(this).parents("tr").find('td:eq(10)').text());
            $("#mdmEdicionSegundo").val($(this).parents("tr").find('td:eq(11)').text());
        }
        $("#ModalDetalleMesa").modal({});
    });

    /*
     * ABRE EL MODAL DE CONFIRMACION CUANDO SE PRESIONA EL BOTON DE ELIMINAR EN LA TABLA.
     * Se obtiene el identificador de la mesa de examen que se encuentra en el boton
     * y se carga en el formulario que luego se envia por AJAX al procesar. Luego,
     * se muestra el modal por pantalla.
     * */
    $(".borrar").click(function (evento) {
        evento.preventDefault();
        $("#modalIdMesa").val($(this).attr("name"));
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
            url: "./app/mesas/vistas/ProcesarBorrarMesa.php",
            data: $("#formBorrarMesa").serialize(),
            success: function (data) {
                $('#cuerpoModalBorrar').html(data);
                $('#btnBorrarMesa').hide();
                $('#btnRefrescarPantalla').show();
            },
            error: function (data) {
                console.log(data);
                $("#cuerpoModal").html('<div class="alert alert-danger text-center" role="alert"><strong>No se procesó la petición</strong></div>');
            }
        });
    });

    /*
     * ACTUALIZA LA PANTALLA LUEGO QUE SE ELIMINA UNA MESA DE EXAMEN.
     * Cuando se realiza el proceso de eliminacion de la mesa de examen, se 
     * refresca la pantalla para que ya no se observe la mesa de examen en la tabla
     * con los demas resultados.
     */
    $("#btnRefrescarPantalla").click(function () {
        setTimeout(function () {
            location.reload();
        }, 600);
    });

});
