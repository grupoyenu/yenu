/** 
 * Este archivo JavaScript se encarga de controlar los eventos de FormBuscarAula.php
 * y de realizar las validaciones correspondientes antes que el formulario sea 
 * enviado al servidor. Se comunica con procesaBorrarAula.php y procesaModificarAula.js 
 * a traves de AJAX. 
 * 
 * @author Oyarzo Mariela <marielaoyarzo89@gmail.com>
 * @author Quiroga Sandra <squiroga17@gmail.com>
 * @author Marquez Emanuel <e.m.a-13@hotmail.com>
 */
$(document).ready(function () {

    buscarAulas();

    $("#formBuscarAula").submit(function (evento) {
        evento.preventDefault();
        $("#peticion").val("true");
        buscarAulas();
    });

    /* CARGA EL FORMULARIO DE MODIFICACION CUANDO SE PRESIONA EL BOTON EN LA TABLA */

    $('#seccionInferior').on('click', '.editar', function () {
        var idAula = $(this).attr("name");
        $.ajax({
            type: "POST",
            url: "./FormModificarAula.php",
            data: "idAula=" + idAula,
            success: function (data) {
                $('#contenido').html(data);
            },
            error: function (data) {
                console.log(data);
                var men = '<i class="fas fa-exclamation-triangle"><strong>No se procesó la petición</strong></i>';
                var div = '<div class="alert alert-danger text-center" role="alert">' + men + '</div>';
                $("#seccionInferior").html(div);
            }
        });
    });

    /* ABRE EL MODAL PARA CONFIRMAR LA BAJA */
    $('#seccionInferior').on('click', '.borrar', function (evento) {
        evento.preventDefault();
        $("#modalIdAula").val($(this).attr("name"));
        $("#modalBorrarAula").modal({backdrop: 'static', keyboard: false});
    });

    /* CARGA EL FORMULARIO DE MODIFICACION CUANDO SE PRESIONA EL BOTON EN LA TABLA */

    $('#seccionInferior').on('click', '.detalle', function () {
        var idAula = $(this).attr("name");
        var sector = $(this).parents("tr").find('td:eq(0)').text();
        var nombre = $(this).parents("tr").find('td:eq(1)').text();
        $.ajax({
            type: "POST",
            url: "./FormDetalleAula.php",
            data: "idAula=" + idAula + "&sector=" + sector + "&nombre=" + nombre,
            success: function (data) {
                $('#contenido').html(data);
            },
            error: function (data) {
                console.log(data);
                var men = '<i class="fas fa-exclamation-triangle"><strong>No se procesó la petición</strong></i>';
                var div = '<div class="alert alert-danger text-center" role="alert">' + men + '</div>';
                $("#seccionInferior").html(div);
            }
        });
    });

    $('#btnBorrarAula').click(function () {
        $.ajax({
            type: "POST",
            url: "./ProcesarBorrarAula.php",
            data: $("#formBorrarAula").serialize(),
            success: function (data) {
                $('#cuerpoModalBorrar').html(data);
                $('#btnBorrarAula').hide();
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

function buscarAulas() {
    $.ajax({
        type: "POST",
        url: "./ProcesarBuscarAula.php",
        data: $("#formBuscarAula").serialize(),
        success: function (data) {
            $("#seccionInferior").html(data);
            $("table#tablaBuscarAulas").DataTable({
                dom: 'Bfrtip',
                buttons: [
                    {extend: 'pdfHtml5', download: 'open', title: 'Aulas ', exportOptions: {columns: [0, 1, 2, 3]}},
                    {extend: 'excelHtml5', exportOptions: {columns: [0, 1, 2, 3]}},
                    {extend: 'print', text: 'Imprimir'},
                    {extend: 'copy', text: 'Copiar'}
                ],
                responsive: true,
                language: {url: "../../lib/js/Spanish.json"}
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