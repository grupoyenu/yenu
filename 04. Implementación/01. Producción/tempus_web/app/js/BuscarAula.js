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

    var idaula = null;
    /* Inicializa la tabla con DataTable */

    $("table#tablaAulas").DataTable({
        dom: 'Bfrtip',
        responsive: true,
        buttons: [
            {
                extend: 'copy',
                text: 'Copiar',
                exportOptions: {
                    columns: [0, 1],
                    search: 'applied',
                    order: 'applied'
                }
            },
            {
                extend: 'print',
                text: 'Imprimir',
                exportOptions: {
                    columns: [0, 1],
                    search: 'applied',
                    order: 'applied'
                }
            },
            { 
                extend: 'excelHtml5', 
                text: 'Save as Excel' },
            {
                text: 'PDF',
                extend: 'pdfHtml5',
                filename: 'tempus_aulas',
                pageSize: 'A4', //A3 , A5 , A6 , legal , letter
                exportOptions: {
                    columns: [0, 1],
                    search: 'applied',
                    order: 'applied'
                },
                customize: function (doc) {
                    doc.content.splice(0, 1);
                    var now = new Date();
                    var jsDate = now.getDate() + '-' + (now.getMonth() + 1) + '-' + now.getFullYear();
                    doc.pageMargins = [40, 50, 40, 50];
                    doc.defaultStyle.fontSize = 11;
                    doc.styles.tableHeader.fontSize = 11;
                    doc['header'] = (function () {
                        return {
                            columns: [
                                {
                                    alignment: 'left',
                                    text: 'Listado de aulas',
                                    fontSize: 13,
                                    margin: [10, 0]
                                },
                                {
                                    alignment: 'right',
                                    fontSize: 13,
                                    text: 'UNPA-UARG'
                                }
                            ],
                            margin: 20
                        }
                    });
                    doc['footer'] = (function (page, pages) {
                        return {
                            columns: [{
                                    alignment: 'left',
                                    text: ['Creado con TEMPUS: ', {text: jsDate.toString()}]
                                },
                                {
                                    alignment: 'right',
                                    text: ['pagina ', {text: page.toString()}, ' de ', {text: pages.toString()}]
                                }],
                            margin: 20
                        }
                    });
                    var objLayout = {};
                    objLayout['hLineWidth'] = function (i) {
                        return .5;
                    };
                    objLayout['vLineWidth'] = function (i) {
                        return .5;
                    };
                    objLayout['hLineColor'] = function (i) {
                        return '#aaa';
                    };
                    objLayout['vLineColor'] = function (i) {
                        return '#aaa';
                    };
                    objLayout['paddingLeft'] = function (i) {
                        return 4;
                    };
                    objLayout['paddingRight'] = function (i) {
                        return 4;
                    };
                    doc.content[0].layout = objLayout;
                    doc.content[0].table.widths = Array(doc.content[0].table.body[0].length + 1).join('*').split('');
                }
            }],
        language: {url: "./app/js/Spanish.json"}
    });
    /* Abre el modal de confirmacion para eliminar aula */

    $('img.borrarAula').click(function () {
        idaula = $(this).attr('name');
        $("#mdBorrar").modal();
    });
    /* Solicitud AJAX para procesar la eliminacion */

    $('#btnConfirmarEliminacion').click(function () {
        $.ajax({
            type: "POST",
            url: "./app/vistas/procesaBorrarAula.php",
            dataType: 'json',
            data: "idaula=" + idaula,
            success: function (data) {
                $("#FormBuscarAula").empty();
                $("#FormBuscarAula").html(data[0]['div']);
            },
            error: function (data) {
                console.log(data);
                imprimirAlerta("No se procesó la petición por un error interno");
            }
        });
        $("#mdBorrar").modal("toggle");
    });
    /* Solicitud AJAX para cargar el formulario de modificacion */

    $('img.modificarAula').click(function () {
        var idaula = $(this).attr('name');
        $.ajax({
            type: "POST",
            url: "./app/vistas/FormModificarAula.php",
            data: "idaula=" + idaula,
            success: function (data) {
                $("#FormBuscarAula").empty();
                $("#FormBuscarAula").html(data);
            },
            error: function (data) {
                console.log(data);
                imprimirAlerta("No se procesó la petición por un error interno");
            }
        });
    });
    /* Solicitud AJAX para cargar el formulario de informe */

    $('img.informeAula').click(function () {
        var idaula = $(this).attr('name');
        $.ajax({
            type: "POST",
            url: "./app/vistas/FormInformeAula.php",
            data: "idaula=" + idaula,
            success: function (data) {
                $("#FormBuscarAula").empty();
                $("#FormBuscarAula").html(data);
            },
            error: function (data) {
                console.log(data);
                imprimirAlerta("No se procesó la petición por un error interno");
            }
        });
    });
    /* Imprime un alerta en el div resultado */

    function imprimirAlerta(mensaje) {
        $("#resultado").empty();
        var div = '<div class="alert alert-danger text-center" role="alert">' + mensaje + '</div>';
        $("#resultado").html(div);
    }


});