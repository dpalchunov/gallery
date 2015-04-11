

$(document).ready(function () {
    destructor = destructor;

    $(".cont_href").hover(function(){
            var e = $("#" + $(this).attr("bro"));
            e.css("background-position","0 -40px");
            $(this).css("color","white");
    },
    function(){
        var e = $("#" + $(this).attr("bro"));
        e.css("background-position","0 0");
        $(this).css("color","grey");
    });

    $(".image_tc").hover(function(){
            var e = $("#" + $(this).attr("bro"));
            e.css("color","white");
            $(this).css("background-position","0 -40px");
        },
        function(){
            var e = $("#" + $(this).attr("bro"));
            e.css("color","grey");
            $(this).css("background-position","0 0px");
        });



});

function destructor() {
    $(".mc_el").remove();
}

