/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$(document).ready(function () {

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

    $("#btnSeleccionarAsignatura").click(function (evento) {
        evento.preventDefault();
        $("#ModalSeleccionarAsignatura").modal({});
        $.ajax({
            type: "POST",
            url: "./app/asignaturas/vistas/ProcesarSeleccionarAsignatura.php",
            success: function (data) {
                $("#cuerpoModal").html(data);
            },
            error: function (data) {
                console.log(data);
                $("#cuerpoModal").html('<div class="alert alert-danger text-center" role="alert">No se procesó la petición</div>');
            }
        });
    });

    /*
     $("#asignaturas").change(function () {
     
     });*/

    $('#asignatura').bind('input', function () {
        var options = $("#asignaturas")[0].options;
        $("#idasignatura").val("");
        for (var i = 0; i < options.length; i++) {
            if (options[i].value === $(this).val()) {
                $("#idasignatura").val(options[i].getAttribute("data-id"));
                break;
            }
        }
    });

});