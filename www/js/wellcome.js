$(document).ready(function () {
    $('#greeting').bind('click', greetingClickHandler);
    $.cookie("greetingWasShown", "true");
    $("#header").hide();
    $(".slideshow_element").cycle(
        {
            fx:"scrollHorz",
            speed:500,
            timeout:4000
        }

    );

});
function greetingClickHandler() {
    $('.cycle-slideshow').cycle('destroy');
    reload($("#about_href"));
    $("#header").show();
}
