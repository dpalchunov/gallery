<!--Скрпты отвечающие за слайдер аватарок на главной странице-->

//объявляем глобальные переменные
//количество фотографий , которые можно перебирать на аватарке
var avas;
var avaCount;

var avaPosition=0;
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

function loadAvas() {
    $.ajax({
        type: "POST",
        url: "about_edit.php",
        data: {action:'get_avas_array'},
        async:false
    }).done(function (data) {
            avas = $.parseJSON(data);
            avaCount = avas.length;
            avaPosition = 1;
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
    destructor = destructor;

});

function setup_avas() {
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
}

function destructor() {
    $(".mc_el").remove();
}

