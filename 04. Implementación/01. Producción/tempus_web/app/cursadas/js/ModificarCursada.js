/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$(document).ready(function () {


    $('.baja').click(function (evento) { 
        evento.preventDefault();
        $("#modalBorrarClase").modal();
    });

    $('.seleccionarAula').click(function (evento) {
        evento.preventDefault();
        var dia = $(this).attr("name");
        var horaInicio = $("select#horaInicio" + dia + " option:selected").text();
        var horaFin = $("select#horaFin" + dia + " option:selected").text();
        $("#modalSeleccionarAula").modal();
        $.ajax({
            type: "POST",
            url: "./app/aulas/vistas/ProcesarSeleccionarAulaDisponible.php",
            data: "dia=" + dia + "&desde=" + horaInicio + "&hasta=" + horaFin,
            success: function (data) {
                $('#cuerpoModalAula').html(data);
                $('#tablaSeleccionarAula').dataTable();
            },
            error: function (data) {
                console.log(data);
                $('#cuerpoModal').html("ERROR");
            }
        });
    });

    $("#cuerpoModalAula").on("click", ".elegirAula", function () {
        var dia = $(this).val();
        var sector = $(this).parents("tr").find("td").eq(1).html();
        var nombre = $(this).parents("tr").find("td").eq(2).html();
        $("#idAula" + dia).val($(this).attr("name"));
        $("#aula" + dia).val(sector + " " + nombre);
        $("#modalSeleccionarAula").modal("toggle");
    });


});

