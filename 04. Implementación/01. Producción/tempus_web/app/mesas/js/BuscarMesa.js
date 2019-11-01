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
    
    $(".detalle").click(function () {
        $("#mdmCodigoCarrera").val($(this).parents("tr").find('td:eq(0)').text());
        $("#mdmNombreCarrera").val($(this).parents("tr").find('td:eq(1)').text());
        $("#mdmNombreAsignatura").val($(this).parents("tr").find('td:eq(2)').text());
        $("#mdmPresidente").val($(this).parents("tr").find('td:eq(3)').text());
        $("#mdmVocal1").val($(this).parents("tr").find('td:eq(4)').text());
        $("#mdmVocal2").val($(this).parents("tr").find('td:eq(5)').text());
        $("#mdmSuplente").val($(this).parents("tr").find('td:eq(6)').text());
        $("#mdmFechaPrimero").val($(this).parents("tr").find('td:eq(7)').text());
        $("#mdmHoraPrimero").val($(this).parents("tr").find('td:eq(8)').text());
        $("#mdmSectorPrimero").val($(this).parents("tr").find('td:eq(9)').text());
        $("#mdmAulaPrimero").val($(this).parents("tr").find('td:eq(10)').text());
        $("#mdmEdicionPrimero").val($(this).parents("tr").find('td:eq(11)').text());
        $("#ModalDetalleMesa").modal({});
    });

});
