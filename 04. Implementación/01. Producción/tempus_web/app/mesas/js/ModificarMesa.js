/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$(document).ready(function () {


    /**
     * INICIALIZA EL SELECTOR DEL PRESIDENTE CON EL PLUGIN SELECT2.
     */
    $('select#presidente').select2({
        placeholder: 'Seleccione una opcion',
        theme: "bootstrap",
        ajax: {
            url: "./app/docentes/vistas/ProcesarSeleccionarDocente.php",
            dataType: 'json',
            type: "POST",
            delay: 250,
            data: function (params) {
                return {nombre: params.term};
            },
            processResults: function (data) {
                return {results: data};
            },
            cache: true
        }
    });
    
    /**
     * INICIALIZA EL SELECTOR DEL VOCAL PRIMERO CON EL PLUGIN SELECT2.
     */
    $('select#vocal1').select2({
        placeholder: 'Seleccione una opcion',
        theme: "bootstrap",
        ajax: {
            url: "./app/docentes/vistas/ProcesarSeleccionarDocente.php",
            dataType: 'json',
            type: "POST",
            delay: 250,
            data: function (params) {
                return {nombre: params.term};
            },
            processResults: function (data) {
                return {results: data};
            },
            cache: true
        }
    });
    
    /**
     * INICIALIZA EL SELECTOR DEL VOCAL SEGUNDO CON EL PLUGIN SELECT2.
     */
    $('select#vocal2').select2({
        placeholder: 'Seleccione una opcion',
        theme: "bootstrap",
        ajax: {
            url: "./app/docentes/vistas/ProcesarSeleccionarDocente.php",
            dataType: 'json',
            type: "POST",
            delay: 250,
            data: function (params) {
                return {nombre: params.term};
            },
            processResults: function (data) {
                return {results: data};
            },
            cache: true
        }
    });

    /**
     * INICIALIZA EL SELECTOR DEL SUPLENTE CON EL PLUGIN SELECT2.
     */
    $('select#suplente').select2({
        placeholder: 'Seleccione una opcion',
        theme: "bootstrap",
        ajax: {
            url: "./app/docentes/vistas/ProcesarSeleccionarDocente.php",
            dataType: 'json',
            type: "POST",
            delay: 250,
            data: function (params) {
                return {nombre: params.term};
            },
            processResults: function (data) {
                return {results: data};
            },
            cache: true
        }
    });
    
    /**
     * INICIALIZA EL SELECTOR DEL AULA PARA EL PRIMER LLAMADO CON EL PLUGIN SELECT2.
     */
    $('select#aula1').select2({
        placeholder: 'Seleccione una opcion',
        theme: "bootstrap",
        ajax: {
            url: "./app/aulas/vistas/ProcesarSeleccionarAula.php",
            dataType: 'json',
            type: "POST",
            delay: 250,
            data: function (params) {
                return {nombre: params.term};
            },
            processResults: function (data) {
                return {results: data};
            },
            cache: true
        }
    });
    
    /**
     * INICIALIZA EL SELECTOR DEL AULA PARA EL SEGUNDO LLAMADO CON EL PLUGIN SELECT2.
     */
    $('select#aula2').select2({
        placeholder: 'Seleccione una opcion',
        theme: "bootstrap",
        ajax: {
            url: "./app/aulas/vistas/ProcesarSeleccionarAula.php",
            dataType: 'json',
            type: "POST",
            delay: 250,
            data: function (params) {
                return {nombre: params.term};
            },
            processResults: function (data) {
                return {results: data};
            },
            cache: true
        }
    });

    /**
     * SE CONFIRMA LA MODIFICACION DEL TRIBUNAL.
     */
    $('.modificarTribunal').click(function () {
        $.ajax({
            type: "POST",
            url: "./app/mesas/vistas/ProcesarModificarTribunal.php",
            data: $("#formModificarTribunal").serialize(),
            success: function (data) {
                $('#seccionResultado').html(data);
            },
            error: function (data) {
                console.log(data);
                $("#seccionResultado").html('<div class="alert alert-danger text-center" role="alert"><strong>No se procesó la petición</strong></div>');
            }
        });
    });

    /**
     * SE CONFIRMA LA MODIFICACION DEL PRIMER LLAMADO.
     */
    $('#formModificarLlamado1').submit(function () {
        $.ajax({
            type: "POST",
            url: "./app/mesas/vistas/ProcesarModificarLlamado.php",
            data: $("#formModificarLlamado1").serialize(),
            success: function (data) {
                $('#seccionResultado').html(data);
            },
            error: function (data) {
                console.log(data);
                $("#seccionResultado").html('<div class="alert alert-danger text-center" role="alert"><strong>No se procesó la petición</strong></div>');
            }
        });
    });

    /**
     * SE CONFIRMA LA MODIFICACION DEL SEGUNDO LLAMADO
     */
    $('#formModificarLlamado2').submit(function () {
        $.ajax({
            type: "POST",
            url: "./app/mesas/vistas/ProcesarModificarLlamado.php",
            data: $("#formModificarLlamado2").serialize(),
            success: function (data) {
                $('#seccionResultado').html(data);
            },
            error: function (data) {
                console.log(data);
                $("#seccionResultado").html('<div class="alert alert-danger text-center" role="alert"><strong>No se procesó la petición</strong></div>');
            }
        });
    });

});

