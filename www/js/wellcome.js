$(document).ready(function () {
    $.cookie("greetingWasShown", "true");
    $("#header").hide();
    $("#outline").hide();
    $(".slideshow_element").cycle(
        {
            fx:"scrollHorz",
            speed:500,
            timeout:4000
        }

    );
    initHandlers();
});

function initHandlers() {
    if (window.script_arrays_loaded && window.styles_arrays_loaded) {
        $('#greeting').bind('click', greetingClickHandler);
    } else {
        setTimeout(initHandlers,500);
    }

}

function greetingClickHandler() {
    $('.slideshow_element').cycle('destroy');
    $('.slideshow_element').remove();
    reload($("#about_href"));
    $("#header").show();
    $("#outline").show();
}
