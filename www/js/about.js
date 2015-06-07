//объявляем глобальные переменные
//количество фотографий , которые можно перебирать на аватарке
var avas;
var avaCount;

var avaPosition=0;
//время анимации смены аватарки
var animateTime = 120;


function getCurAvaPath() {
    return avas[window.avaPosition - 1];
}

function getNextAvaPath() {

    if (window.avaPosition == window.avaCount) {
        window.avaPosition = 1;
    } else {
        window.avaPosition++;
    }
    return window.avas[window.avaPosition - 1];
}

function getPrevAvaPath() {
    if (window.avaPosition == 1) {
        window.avaPosition = window.avaCount;
    } else {
        window.avaPosition--;
    }
    return window.avas[window.avaPosition - 1];
}

function loadAvas() {
    var action = "get_avas_array";
    $.ajax({
        method: "POST",
        shouldRetry: 3,
        url: "about_edit.php",
         data: {action:action},
        async:false
    }).done(function(data,y,jqXHR) {
            if (action != jqXHR.getResponseHeader('action')) {
                loadAvas();
                return;
            }
            try {
                window.avas = $.parseJSON(data);
            } catch(e) {
                //console.error("response parse error while post about_edit.php:get_avas_array");
            }
            window.avaCount = window.avas.length;
            window.avaPosition = 1;
            setup_avas();
        });
}

function avaAnimation() {
    //прячем тень
    $("#shaddow").animate({opacity: 'hide'}, animateTime);
    //показываем DIV заново
    $("#ava_img").animate({width: 'toggle'}, animateTime);
    //показываем тень
    $("#shaddow").animate({opacity: 'show'}, animateTime);
}


$(document).ready(function () {
    loadAvas();

    $(".slideshow_element").cycle(
        {
            fx:"scrollHorz",
            speed:500,
            timeout:4000
        }

    );

    destructor = destructor;

    var $window = $(window),
        $stickyEl = $('#outline'),
        elTop = $stickyEl.offset().top;

    $window.scroll(function() {
        $stickyEl.toggleClass('sticky', $window.scrollTop() > elTop);
    });

    init_video();

});

function setup_avas() {
    if (window.avaCount > 1) {
        $("#ava_img").click(function () {
            var nextAvaPath = getNextAvaPath();
            //сначала убираем DIV
            $("#ava_img").animate({height: 'toggle'},
                animateTime,
                function () {
                    $("#ava_img").attr("src", nextAvaPath);

                }
            );
            avaAnimation();
        });
        $("#ava_img").attr("src", getCurAvaPath());
    } else if (window.avaCount == 1) {
        $("#ava_img").attr("src", getCurAvaPath());

    } else {
        $("#slider").hide();

    }
}

function destructor() {
    $(".mc_el").remove();
}

function init_video() {
    $("#about_video").jPlayer({
        size: {height:"auto",width:"100%"},
        ready: function () {

            $(this).jPlayer("setMedia",{

                title:"first_video",
                m4v: "./video/Now or never.m4v",

            }).jPlayer("play").jPlayer("pause");
        },
        swfPath: "./player/swf",
        supplied: "m4v",
        wmode: "window",
        smoothPlayBar:true
    });
}




