/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).ready(function () {


    $("#modulo").change(function () {
        var modulo = $(this).val();
        if (modulo === "CUR") {
            $("#disponibleCursada").prop("disabled", false);
            $("#dia").prop("disabled", false);
            $("#desde").prop("disabled", false);
            $("#hasta").prop("disabled", false);
            $("#disponibleMesa").prop("disabled", true);
            $("#horaMesa").prop("disabled", true);
        } else {
            $("#disponibleCursada").prop("disabled", true);
            $("#dia").prop("disabled", true);
            $("#desde").prop("disabled", true);
            $("#hasta").prop("disabled", true);
            $("#disponibleMesa").prop("disabled", false);
            $("#horaMesa").prop("disabled", false);
        }
    });
});
