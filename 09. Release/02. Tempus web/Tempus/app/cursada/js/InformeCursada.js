/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$(document).ready(function () {

    $('#formInformeCursada').submit(function (evento) {
        evento.preventDefault();
        $.ajax({
            type: "POST",
            url: "./ProcesarInformeCursada.php",
            data: $("#formInformeCursada").serialize(),
            success: function (data) {
                $('#seccionInferior').html(data);
                $("table#tablaInformeCursadas").DataTable({
                    dom: 'Bfrtip',
                    responsive: true,
                    language: {url: "./lib/js/Spanish.json"},
                    buttons: [
                        {extend: 'pdfHtml5',
                            orientation: 'landscape',
                            download: 'open',
                            title: 'TEMPUS Informe de Horarios de cursada'
                        },
                        {extend: 'excelHtml5',
                            title: 'TEMPUS Informe de Horarios de cursada'},
                        {extend: 'print',
                            text: 'Imprimir',
                            title: 'TEMPUS Informe de Horarios de cursada',
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
                var men = '<strong>No se procesó la petición</strong>';
                var div = '<div class="alert alert-danger text-center" role="alert">' + men + '</div>';
                $("#seccionInferior").html(div);
            }
        });
    });
});

