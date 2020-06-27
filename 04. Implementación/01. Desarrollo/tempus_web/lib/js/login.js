
/*
 * Utiliza el correo electronico de GMAIL para hacer el acceso al sistema. Con
 * el fin de evitar el bucle infinito cuando la cuenta no esta registrada, se
 * define la variable email previo. Solo cuando difiere la cuenta GMAIL del 
 * email anterior se realiza el envio del formulario (evita bucle).
 */

function onSignIn(googleUser) {
    var profile = googleUser.getBasicProfile();
    var url = '/TempusV7/index.php';
    var emailPrevio = $("#intentoIngresar").val();
    if (profile.getEmail() !== emailPrevio) {
        $.redirectPost(url,
                {"email": profile.getEmail(),
                    "nombre": profile.getName(),
                    "imagen": profile.getImageUrl(),
                    "googleid": profile.getId()});
    }
}

// jquery extend function
$.extend({
    redirectPost: function (location, args) {

        alert($("#intentoIngresar").val());
        var form = $('<form></form>');
        form.attr("method", "post");
        form.attr("action", location);
        $.each(args, function (key, value) {
            var field = $('<input></input>');
            field.attr("type", "hidden");
            field.attr("name", key);
            field.attr("value", value);
            form.append(field);
        });
        $(form).appendTo('body').submit();
    }
});