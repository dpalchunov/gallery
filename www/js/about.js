<!--Скрпты отвечающие за слайдер аватарок на главной странице-->

//объявляем глобальные переменные
//количество фотографий , которые можно перебирать на аватарке
var avaCount;

var avaPosition;
//время анимации смены аватарки
var animateTime = 120;


function getCurAvaPath() {
    return avas[avaPosition - 1];
}

function getNextAvaPath() {

    if (avaPosition == avaCount) {
        avaPosition = 1;
    } else {
        avaPosition++;
    }
    return avas[avaPosition - 1];
}

function getPrevAvaPath() {
    if (avaPosition == 1) {
        avaPosition = avaCount;
    } else {
        avaPosition--;
    }
    return avas[avaPosition - 1];
}

function initAvaArray() {
    avaCount = avas.length;
    avaPosition = 1;
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
    initAvaArray();
    if (avaCount > 1) {
        $("#ava_img").click(function () {
            var nextAvaPath = getNextAvaPath();
            //сначала убираем DIV
            $("#ava_img").animate({width: 'toggle'},
                animateTime,
                function () {
                    //по окончании анимации исчезновения
                    //установка нового background-image
                    $("#ava_img").attr("src", nextAvaPath);

                }
            );
            avaAnimation();
        });
        $("#ava_img").attr("src", getCurAvaPath());
    } else if (avaCount == 1) {
        $("#ava_img").attr("src", getCurAvaPath());
    } else {
        $("#slider").hide();
    }
});
<!--Конец скрптов отвечающих за слайдер аватарок на главной странице-->

<!-- Скрипт отвечающий для страничку приветствия, которая отображается один раз при первом посещении сайта-->

$(document).ready(function () {
    $('#greeting').bind('click', greetingClickHandler);
    $.cookie("greetingWasShown", "true");
});
function greetingClickHandler() {
    $('#greeting').fadeOut(400);
    $('#wrapper').show();
}
<!-- Конец. Скрипт отвечающий для страничку приветствия, которая отображается один раз при первом посещении сайта-->

<!-- Скрипт отвечающий за клик на header Kristina Strunkova-->
$(document).ready(function () {
    $('#header_name').bind('click', headerNameClickHandler);
});

function headerNameClickHandler() {
    $.cookie("greetingWasShown", null);
    window.location = 'about.php';
}
<!-- Конец. Скрипт отвечающий за клин на header Kristina Strunkova-->