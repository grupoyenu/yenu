/**
 * 
 * 
 * @author Oyarzo Mariela <marielaoyarzo89@gmail.com>
 * @author Quiroga Sandra <squiroga17@gmail.com>
 * @author Marquez Emanuel <e.m.a-13@hotmail.com>
 */

$(document).ready(function () {

    $('#formInformeAula').submit(function (evento) {
        evento.preventDefault();
        $.ajax({
            type: "POST",
            url: "./ProcesarInformeAula.php",
            data: $("#formInformeAula").serialize(),
            success: function (data) {
                $('#seccionInferior').html(data);
                $("table#tablaInformeAulas").DataTable({
                    dom: 'Bfrtip',
                    buttons: [
                        {extend: 'pdfHtml5', download: 'open', title: 'Informe de aulas'},
                        {extend: 'excelHtml5'},
                        {extend: 'print', text: 'Imprimir'},
                        {extend: 'copy', text: 'Copiar'}
                    ],
                    responsive: true,
                    language: {url: "../../lib/js/Spanish.json"}
                });
            },
            error: function (data) {
                console.log(data);
                var men = "<i class='fas fa-exclamation-triangle'><strong>No se procesó la petición</strong></i>";
                var div = "<div class='alert alert-danger text-center' role='alert'>" + men + "</div>";
                $("#seccionInferior").html(div);
            }
        });
    });

    $("#modulo").change(function () {
        var modulo = $(this).val();
        if (modulo === "CUR") {
            $("#disponibleCursada").prop("disabled", false);
            $("#dia").prop("disabled", false);
            $("#desde").prop("disabled", false);
            $("#hasta").prop("disabled", false);
            $("#disponibleMesa").prop("disabled", true);
            $("#fecha").prop("disabled", true);
            $("#horaMesa").prop("disabled", true);
        } else {
            $("#disponibleCursada").prop("disabled", true);
            $("#dia").prop("disabled", true);
            $("#desde").prop("disabled", true);
            $("#hasta").prop("disabled", true);
            $("#disponibleMesa").prop("disabled", false);
            $("#fecha").prop("disabled", false);
            $("#horaMesa").prop("disabled", false);
        }
    });

    $("#desde").change(function () {
        var hora = $(this).val().substring(0, 2);
        for (var i = 10; i < 24; i++) {
            if (i <= hora) {
                $("#hasta").find("option[value='" + i + ":00']").attr("disabled", "disabled");
                $("#hasta").find("option[value='" + i + ":30']").attr("disabled", "disabled");
            } else {
                $("#hasta").find("option[value='" + i + ":00']").removeAttr("disabled");
                $("#hasta").find("option[value='" + i + ":30']").removeAttr("disabled");
            }
        }
    });

});
