/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).ready(function () {

    $("table#tablaBuscarMesas").DataTable({
        dom: 'Bfrtip',
        responsive: true,
        language: {url: "./lib/js/Spanish.json"}
    });

    /* CARGA EL FORMULARIO DE MODIFICACION CUANDO SE PRESIONA EL BOTON EN LA TABLA */

    $('.editar').click(function () {
        var idMesa = $(this).attr("name");
        $.ajax({
            type: "POST",
            url: "./app/mesas/vistas/FormModificarMesa.php",
            data: "idMesa=" + idMesa,
            success: function (data) {
                $('#contenido').html(data);
            },
            error: function (data) {
                console.log(data);
                $("#contenido").html('<div class="alert alert-danger text-center" role="alert"><strong>No se procesó la petición<strong></div>');
            }
        });
    });

});
