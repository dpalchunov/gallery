$(document).ready(function () {
    wellcomeInit();
});
function headerNameClickHandler() {
    $.cookie("greetingWasShown", null);
    window.location = 'about.php';
}

function wellcomeInit() {
    $('#header_name').bind('click', headerNameClickHandler);
}
