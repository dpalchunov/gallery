$(document).ready(function () {
    $('#greeting').bind('click', greetingClickHandler);
    $.cookie("greetingWasShown", "true");
    $("#header").hide();
});
function greetingClickHandler() {
    reload($("#about_href"));
    $("#header").show();
}