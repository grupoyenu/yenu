/** 
 * Este archivo JavaScript se encarga de controlar los eventos de FormBuscarAula.php
 * y de realizar las validaciones correspondientes antes que el formulario sea 
 * enviado al servidor. Se comunica con procesaBorrarAula.php y procesaModificarAula.js 
 * a traves de AJAX. 
 * 
 * @author Oyarzo Mariela 
 * @author Quiroga Sandra
 * @author Marquez Emanuel
 */
$(document).ready(function () {

    $("table#tablaBuscarAulas").DataTable({
        dom: 'Bfrtip',
        responsive: true,
        language: {url: "./lib/js/Spanish.json"}
    });

    /* CARGA EL FORMULARIO DE MODIFICACION CUANDO SE PRESIONA EL BOTON EN LA TABLA */

    $('.editar').click(function () {
        var idAula = $(this).attr("name");
        $.ajax({
            type: "POST",
            url: "./app/aulas/vistas/formModificarAula.php",
            data: "idAula=" + idAula,
            success: function (data) {
                $('#contenido').html(data);
            },
            error: function (data) {
                console.log(data);
                $("#contenido").html('<div class="alert alert-danger text-center" role="alert"><strong>No se procesó la petición<strong></div>');
            }
        });
    });

    /* ABRE EL MODAL PARA CONFIRMAR LA BAJA */

    $('.baja').click(function () {
        var sector = $(this).parents("tr").find("td").eq(0).html();
        var nombre = $(this).parents("tr").find("td").eq(1).html();
        $("#modalIdAula").val($(this).attr("name"));
        $("#modalDetalle").text("Presione CONFIRMAR para borrar el aula " + nombre + " del sector " + sector);
        $("#modalBorrarAula").modal({backdrop: 'static', keyboard: false});
    });

});