/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$(document).ready(function () {

    $(".clases").change(function () {
        var dia = $(this).val();
        var checkeado = $(this).prop('checked');
        var disabled = (checkeado) ? false : true;
        $("#horaInicio" + dia).prop("disabled", disabled);
        $("#horaFin" + dia).prop("disabled", disabled);
        $("#aula" + dia).prop("disabled", disabled);
        $("#baja" + dia).prop("disabled", disabled);
        $("#crear" + dia).prop("disabled", disabled);
        $("#editar" + dia).prop("disabled", disabled);
    });

    $('#aula1').select2({
        placeholder: 'Seleccione una opcion',
        theme: "bootstrap",
        ajax: {
            url: "./app/aulas/vistas/ProcesarSeleccionarAulaDisponible.php",
            dataType: 'json',
            type: "POST",
            delay: 250,
            data: function (params) {
                return {
                    dia: 1,
                    desde: $("#horaInicio1").val(),
                    hasta: $("#horaFin1").val(),
                    nombre: params.term};
            },
            processResults: function (data) {
                return {results: data};
            },
            cache: true
        }
    });

    $('#aula2').select2({
        placeholder: 'Seleccione una opcion',
        theme: "bootstrap",
        ajax: {
            url: "./app/aulas/vistas/ProcesarSeleccionarAulaDisponible.php",
            dataType: 'json',
            type: "POST",
            delay: 250,
            data: function (params) {
                return {
                    dia: 2,
                    desde: $("#horaInicio2").val(),
                    hasta: $("#horaFin2").val(),
                    nombre: params.term};
            },
            processResults: function (data) {
                return {results: data};
            },
            cache: true
        }
    });

    $('#aula3').select2({
        placeholder: 'Seleccione una opcion',
        theme: "bootstrap",
        ajax: {
            url: "./app/aulas/vistas/ProcesarSeleccionarAulaDisponible.php",
            dataType: 'json',
            type: "POST",
            delay: 250,
            data: function (params) {
                return {
                    dia: 3,
                    desde: $("#horaInicio3").val(),
                    hasta: $("#horaFin3").val(),
                    nombre: params.term};
            },
            processResults: function (data) {
                return {results: data};
            },
            cache: true
        }
    });

    $('#aula4').select2({
        placeholder: 'Seleccione una opcion',
        theme: "bootstrap",
        ajax: {
            url: "./app/aulas/vistas/ProcesarSeleccionarAulaDisponible.php",
            dataType: 'json',
            type: "POST",
            delay: 250,
            data: function (params) {
                return {
                    dia: 4,
                    desde: $("#horaInicio4").val(),
                    hasta: $("#horaFin4").val(),
                    nombre: params.term};
            },
            processResults: function (data) {
                return {results: data};
            },
            cache: true
        }
    });

    $('#aula5').select2({
        placeholder: 'Seleccione una opcion',
        theme: "bootstrap",
        ajax: {
            url: "./app/aulas/vistas/ProcesarSeleccionarAulaDisponible.php",
            dataType: 'json',
            type: "POST",
            delay: 250,
            data: function (params) {
                return {
                    dia: 1,
                    desde: $("#horaInicio5").val(),
                    hasta: $("#horaFin5").val(),
                    nombre: params.term};
            },
            processResults: function (data) {
                return {results: data};
            },
            cache: true
        }
    });

    $('#aula6').select2({
        placeholder: 'Seleccione una opcion',
        theme: "bootstrap",
        ajax: {
            url: "./app/aulas/vistas/ProcesarSeleccionarAulaDisponible.php",
            dataType: 'json',
            type: "POST",
            delay: 250,
            data: function (params) {
                return {
                    dia: 6,
                    desde: $("#horaInicio6").val(),
                    hasta: $("#horaFin6").val(),
                    nombre: params.term};
            },
            processResults: function (data) {
                return {results: data};
            },
            cache: true
        }
    });

    $('.baja').click(function (evento) {
        evento.preventDefault();
        $("#modalBorrarClase").modal();
    });


});

