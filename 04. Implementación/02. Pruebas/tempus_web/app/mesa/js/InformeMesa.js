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
                    language: {url: "../../../lib/js/Spanish.json"},
                    buttons: [
                        {extend: 'pdfHtml5',
                            orientation: 'landscape',
                            download: 'open',
                            title: 'TEMPUS Informe de Mesas de examen',
                            exportOptions: {columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 12, 13, 14, 15]}
                        },
                        {extend: 'excelHtml5',
                            title: 'TEMPUS Informe de Mesas de examen',
                            exportOptions: {columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 12, 13, 14, 15]}
                        },
                        {extend: 'print',
                            text: 'Imprimir',
                            title: 'TEMPUS Informe de Mesas de examen',
                            exportOptions: {columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 12, 13, 14, 15]},
                            customize: function (win) {
                                $(win.document.body).css('font-size', '10pt');
                                $(win.document.body).find('table')
                                        .addClass('compact')
                                        .css('font-size', 'inherit');
                            }
                        },
                        {extend: 'copy', text: 'Copiar'}
                    ]
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
