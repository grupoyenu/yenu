
function onSignIn(googleUser) {
    var profile = googleUser.getBasicProfile();
    var url = '/TempusV7/index.php';
    $.redirectPost(url, 
        {"email": profile.getEmail(), 
         "nombre": profile.getName(), 
         "imagen": profile.getImageUrl(), 
         "googleid": profile.getId()});
}

// jquery extend function
$.extend({
    redirectPost: function (location, args) {
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