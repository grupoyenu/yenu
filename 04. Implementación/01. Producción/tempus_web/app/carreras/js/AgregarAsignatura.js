/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$(document).ready(function () {

    var codigo = $("#codigo").val();

    alert(codigo);

    $('select#asignatura').select2({
        placeholder: 'Seleccione una opcion',
        theme: "bootstrap",
        minimumInputLength: 3,
        ajax: {
            url: "./app/asignaturas/vistas/ProcesarSeleccionarAsignaturaCarrera.php",
            dataType: 'json',
            type: "POST",
            delay: 250,
            data: function (params) {
                return {nombre: params.term, codigoCarrera: $("#codigo").val()};
            },
            processResults: function (data) {
                return {results: data};
            },
            cache: true
        }
    });

    $("#formAgregarAsignatura").submit(function (evento) {
        evento.preventDefault();
        $.ajax({
            type: "POST",
            dataType: 'json',
            url: "./app/carreras/vistas/ProcesarAgregarAsignatura.php",
            data: $("#formAgregarAsignatura").serialize(),
            success: function (data) {
                if (data[0]['exito'] === true) {
                    $('#seccionCentral').html(data[0]['div']);
                    $("#seccionInferior").empty();
                } else {
                    $('#seccionCentral').html(data[0]['div']);
                }
            },
            error: function (data) {
                console.log(data);
                $("#seccionCentral").html('<div class="alert alert-danger text-center" role="alert">No se procesó la petición</div>');
            }
        });
    });

});