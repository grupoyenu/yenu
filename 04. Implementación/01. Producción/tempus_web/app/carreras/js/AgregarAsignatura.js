/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$(document).ready(function () {

    var codigo = $("#codigo").val();

    $('select#asignatura').select2({
        placeholder: 'Seleccione una opcion',
        theme: "bootstrap",
        minimumInputLength: 3,
        maximumSelectionLength: 50,
        ajax: {
            url: "./app/asignaturas/vistas/ProcesarSeleccionarAsignaturaCarrera.php",
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

    $('select#asignatura').change(function () {
        var opcion = $(this).find(":selected").val();
        if (opcion.substring(0, 1) === "_") {
            var nombre = $(this).find(":selected").text();
            var mensaje = "La asignatura '" + nombre + "' será verificada y creada";
            $("#seccionResultado").html('<div class="alert alert-info text-center" role="alert"><strong>' + mensaje + '</strong></div>');
        } else {
            $("#seccionResultado").empty();
        }
    });

    $("#formAgregarAsignatura").submit(function (evento) {
        evento.preventDefault();
        var asignatura = $('select#asignatura').find(":selected").val();
        if (asignatura !== "NO") {
            $("#nombreAsignatura").val($('select#asignatura').find(":selected").text());
            $.ajax({
                type: "POST",
                dataType: 'json',
                url: "./app/carreras/vistas/ProcesarAgregarAsignatura.php",
                data: $("#formAgregarAsignatura").serialize(),
                success: function (data) {
                    $('#seccionResultado').html(data[0]['resultado']);
                    if (data[0]['exito'] === true) {
                        $("#formAgregarAsignatura")[0].reset();
                    }
                },
                error: function (data) {
                    console.log(data);
                    $("#seccionResultado").html('<div class="alert alert-danger text-center" role="alert">No se procesó la petición</div>');
                }
            });
        } else {
            var mensaje = "Se debe seleccionar o indicar una asignatura";
            $("#seccionResultado").html('<div class="alert alert-danger text-center" role="alert"><strong>' + mensaje + '</strong></div>');
        }
    });

});

