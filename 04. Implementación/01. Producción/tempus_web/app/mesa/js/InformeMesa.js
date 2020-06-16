/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).ready(function () {

    $('#formInformeMesa').submit(function (evento) {
        evento.preventDefault();
        $.ajax({
            type: "POST",
            url: "./ProcesarInformeMesa.php",
            data: $("#formInformeMesa").serialize(),
            success: function (data) {
                $('#seccionInferior').html(data);
                $("table#tablaInformeMesas").DataTable({
                    dom: 'Bfrtip',
                    responsive: true,
                    language: {url: "./lib/js/Spanish.json"}
                });
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
