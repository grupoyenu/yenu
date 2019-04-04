/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$(document).ready(function () {

    $("table#tablaMesasExamen").DataTable({
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
                    search: 'applied',
                    order: 'applied'
                }
            },
            {
                extend: 'excelHtml5',
                text: 'Save as Excel'},
            {
                text: 'PDF',
                extend: 'pdfHtml5',
                filename: 'tempus_mesas',
                orientation: 'landscape',
                pageSize: 'LEGAL',
                exportOptions: {
                    search: 'applied',
                    order: 'applied'
                },
                customize: function (doc) {
                    doc.content.splice(0, 1);
                    var now = new Date();
                    var jsDate = now.getDate() + '-' + (now.getMonth() + 1) + '-' + now.getFullYear();
                    doc.pageMargins = [30, 50, 30, 50];
                    doc.defaultStyle.fontSize = 10;
                    doc.styles.tableHeader.fontSize = 10;
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

    $('#btnBorrarMesa').click(function (event) {
        event.preventDefault();
        if (!$("input[name='radioMesas']").is(":checked")) {
            $("#modalSeleccione").modal();
        } else {
            $("#mdBorrar").modal();
        }
    });

    $('#btnConfirmarEliminacion').click(function () {
        $.ajax({
            type: "POST",
            url: "./app/vistas/procesaBorrarMesa.php",
            data: $("#formBuscarMesa").serialize(),
            success: function (data) {
                $("#resultado").empty();
                $("#resultado").html(data);
            },
            error: function () {
                var mensaje = "Error durante la petición por AJAX";
                $("#resultado").html('<div class="alert alert-danger text-center" role="alert">' + mensaje + '</div>');
            }
        });
        $("#mdBorrar").modal('toggle');
    });

    $('#btnModificarMesa').click(function (event) {
        event.preventDefaul();
        if (!$("input[name='radioMesas']").is(":checked")) {
            $("#modalSeleccione").modal();
        } else {
            $.ajax({
                type: "POST",
                url: "./app/vistas/FormModificarMesa.php",
                data: $("#formBuscarMesa").serialize(),
                success: function (data) {
                    $("#FormBuscarMesa").empty();
                    $("#FormBuscarMesa").html(data);
                },
                error: function () {
                    var mensaje = "Error durante la petición por AJAX";
                    $("#resultado").html('<div class="alert alert-danger text-center" role="alert">' + mensaje + '</div>');
                }
            });
        }
    });

});