/** 
 * 
 * @author Oyarzo Mariela <marielaoyarzo89@gmail.com>
 * @author Quiroga Sandra <squiroga17@gmail.com>
 * @author Marquez Emanuel <e.m.a-13@hotmail.com>
 */
$(document).ready(function () {

    var codigo = $("#codigo").val();

    $('select#asignatura').select2({
        placeholder: 'Seleccione una opcion',
        theme: "bootstrap",
        minimumInputLength: 3,
        maximumSelectionLength: 50,
        ajax: {
            url: "../../asignatura/vista/ProcesarSeleccionarAsignaturaCarrera.php",
            dataType: 'json',
            type: "POST",
            delay: 250,
            data: function (params) {
                return {nombre: params.term, codigoCarrera: codigo};
            },
            processResults: function (data) {
                return {results: data};
            }
        }
    });

    $("#formAgregarAsignatura").submit(function (evento) {
        evento.preventDefault();
        $.ajax({
            type: "POST",
            dataType: 'json',
            url: "./ProcesarAgregarAsignatura.php",
            data: $("#formAgregarAsignatura").serialize(),
            success: function (data) {
                $('#seccionResultado').html(data[0]['resultado']);
                if (data[0]['exito'] === true) {
                    $("#formAgregarAsignatura")[0].reset();
                }
            },
            error: function (data) {
                console.log(data);
                var men = "<i class='fas fa-exclamation-triangle'><strong>No se procesó la petición</strong></i>";
                var div = "<div class='alert alert-danger text-center' role='alert'>" + men + "</div>";
                $("#seccionResultado").html(div);
            }
        });
    });

});

