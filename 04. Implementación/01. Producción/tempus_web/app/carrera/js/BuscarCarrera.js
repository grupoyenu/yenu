/** 
 * 
 * @author Oyarzo Mariela <marielaoyarzo89@gmail.com>
 * @author Quiroga Sandra <squiroga17@gmail.com>
 * @author Marquez Emanuel <e.m.a-13@hotmail.com>
 */
$(document).ready(function () {

    buscarCarreras();

    $("#formBuscarCarrera").submit(function (evento) {
        evento.preventDefault();
        $("#peticion").val("true");
        buscarCarreras();
    });

    $('#seccionInferior').on('click', '.detalle', function () {
        var codigo = $(this).attr("name");
        $.ajax({
            type: "POST",
            url: "./FormDetalleCarrera.php",
            data: "codigo=" + codigo,
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

    $('#seccionInferior').on('click', '.agregar', function () {
        var codigo = $(this).attr("name");
        $.ajax({
            type: "POST",
            url: "./FormAgregarAsignatura.php",
            data: "codigo=" + codigo,
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

});


function buscarCarreras() {
    $.ajax({
        type: "POST",
        url: "./ProcesarBuscarCarrera.php",
        data: $("#formBuscarCarrera").serialize(),
        success: function (data) {
            $("#seccionInferior").html(data);
            $("table#tablaBuscarCarreras").DataTable({
                dom: 'Bfrtip',
                buttons: [
                    {extend: 'pdfHtml5', download: 'open', title: ' Carreras ', exportOptions: {columns: [0, 1, 2]}},
                    {extend: 'excelHtml5', exportOptions: {columns: [0, 1, 2]}},
                    {extend: 'print', text: 'Imprimir', exportOptions: {columns: [0, 1, 2]}},
                    {extend: 'copy', text: 'Copiar'}
                ],
                responsive: true,
                language: {url: "../../lib/js/Spanish.json"}
            });
        },
        error: function (data) {
            console.log(data);
            var men = "<i class='fas fa-exclamation-triangle'><strong>No se procesó la petición</strong></i>";
            var div = '<div class="alert alert-danger text-center" role="alert">' + men + '</div>';
            $("#seccionInferior").html(div);
        }
    });
}