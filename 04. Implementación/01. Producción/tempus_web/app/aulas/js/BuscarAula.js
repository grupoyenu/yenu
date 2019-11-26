/** 
 * Este archivo JavaScript se encarga de controlar los eventos de FormBuscarAula.php
 * y de realizar las validaciones correspondientes antes que el formulario sea 
 * enviado al servidor. Se comunica con procesaBorrarAula.php y procesaModificarAula.js 
 * a traves de AJAX. 
 * 
 * @author Oyarzo Mariela 
 * @author Quiroga Sandra
 * @author Marquez Emanuel
 */
$(document).ready(function () {

    $("table#tablaBuscarAulas").DataTable({
        dom: 'Bfrtip',
        buttons: [
            {extend: 'pdfHtml5', download: 'open', title: 'Aulas ', exportOptions: {columns: [0, 1, 2, 3]}},
            {extend: 'excelHtml5', exportOptions: {columns: [0, 1, 2, 3]}},
            {extend: 'print', text: 'Imprimir'},
            {extend: 'copy', text: 'Copiar'}
        ],
        responsive: true,
        language: {url: "./lib/js/Spanish.json"}
    });

    /* CARGA EL FORMULARIO DE MODIFICACION CUANDO SE PRESIONA EL BOTON EN LA TABLA */

    $('.editar').click(function () {
        var idAula = $(this).attr("name");
        $.ajax({
            type: "POST",
            url: "./app/aulas/vistas/FormModificarAula.php",
            data: "idAula=" + idAula,
            success: function (data) {
                $('#contenido').html(data);
            },
            error: function (data) {
                console.log(data);
                $("#contenido").html('<div class="alert alert-danger text-center" role="alert"><strong>No se procesó la petición<strong></div>');
            }
        });
    });

    /* ABRE EL MODAL PARA CONFIRMAR LA BAJA */

    $(".borrar").click(function (evento) {
        evento.preventDefault();
        $("#modalIdAula").val($(this).attr("name"));
        $("#modalBorrarAula").modal({backdrop: 'static', keyboard: false});
    });

    /* CARGA EL FORMULARIO DE MODIFICACION CUANDO SE PRESIONA EL BOTON EN LA TABLA */

    $('.detalle').click(function () {
        var idAula = $(this).attr("name");
        var sector = $(this).parents("tr").find('td:eq(0)').text();
        var nombre = $(this).parents("tr").find('td:eq(1)').text();
        $.ajax({
            type: "POST",
            url: "./app/aulas/vistas/FormDetalleAula.php",
            data: "idAula=" + idAula + "&sector=" + sector + "&nombre=" + nombre,
            success: function (data) {
                $('#contenido').html(data);
            },
            error: function (data) {
                console.log(data);
                $("#contenido").html('<div class="alert alert-danger text-center" role="alert"><strong>No se procesó la petición<strong></div>');
            }
        });
    });

    $('#btnBorrarAula').click(function () {
        $.ajax({
            type: "POST",
            url: "./app/aulas/vistas/ProcesarBorrarAula.php",
            data: $("#formBorrarAula").serialize(),
            success: function (data) {
                $('#cuerpoModalBorrar').html(data);
                $('#btnBorrarAula').hide();
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