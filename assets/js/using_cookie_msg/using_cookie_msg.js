var cookie_name = "agree_using_cookie";
var cookie_value = "jaakkoord";
var cookie_exdays = 7;

function setCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
    var expires = "expires=" + d.toUTCString();
    document.cookie = cname + "=" + cvalue + "; " + expires;
}

function getCookie(cname) {
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for (var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}

function is_ok()
{
    setCookie(cookie_name, cookie_value, cookie_exdays);
}

function show_using_cookie_msg()
{
    var value_cookie = getCookie(cookie_name);
    if (value_cookie == cookie_value) {
        $('#using_cookie_msg').hide();
    } else {
        var html_string ="<div class='alert alert-warning alert-dismissible fade in' ><button type='button' onclick=is_ok() class='close' data-dismiss='alert' aria-label='Close'><span>&times;</span></button><strong>Wij gebruiken cookies om uw gebruikerservaring te verbeteren. </strong> <a href='#' class='alert-link'>meer informatie</a></div>";
        $('#using_cookie_msg').html(html_string);
    }
}


$(function () {
    show_using_cookie_msg();
});