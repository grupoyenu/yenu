/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$(document).ready(function () {

    $('#seleccionarAsignatura').click(function (evento) {
        evento.preventDefault();
        $("#modalSeleccionarAsignatura").modal();
        $.ajax({
            type: "POST",
            url: "./app/asignaturas/vistas/ProcesarSeleccionarAsignaturaSinCursada.php",
            success: function (data) {
                $('#cuerpoModalAsignatura').html(data);
                $('#tablaSeleccionarAsignatura').dataTable();
            },
            error: function (data) {
                console.log(data);
                $('#cuerpoModal').html('<div class="alert alert-danger text-center" role="alert"><strong>No se procesó la petición<strong></div>');
            }
        });
    });

});

