/** 
 * 
 * @author Oyarzo Mariela <marielaoyarzo89@gmail.com>
 * @author Quiroga Sandra <squiroga17@gmail.com>
 * @author Marquez Emanuel <e.m.a-13@hotmail.com>
 */
$(document).ready(function () {

    buscarAsignaturas();

    $("#formBuscarAsignatura").submit(function (evento) {
        evento.preventDefault();
        $("#peticion").val("true");
        buscarAsignaturas();
    });

    $('#seccionInferior').on('click', '.detalle', function () {
        var id = $(this).attr("name");
        $.ajax({
            type: "POST",
            url: "./FormDetalleAsignatura.php",
            data: "id=" + id,
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

});

function buscarAsignaturas() {
    $.ajax({
        type: "POST",
        url: "./ProcesarBuscarAsignatura.php",
        data: $("#formBuscarAsignatura").serialize(),
        success: function (data) {
            $("#seccionInferior").html(data);
            $("table#tablaBuscarAsignaturas").DataTable({
                dom: 'Bfrtip',
                buttons: [
                    {extend: 'pdfHtml5',
                        download: 'open',
                        title: ' Asignaturas ',
                        exportOptions: {columns: [0, 1, 2]}},
                    {extend: 'excelHtml5',
                        exportOptions: {columns: [0, 1]}},
                    {extend: 'print',
                        text: 'Imprimir',
                        exportOptions: {columns: [0, 1]}},
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