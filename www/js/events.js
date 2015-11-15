//объявляем глобальные переменные
//количество фотографий , которые можно перебирать на аватарке
var avas;
var avaCount;

var avaPosition=0;
//время анимации смены аватарки
var animateTime = 120;


//content-tools code
function initContentTools() {
    var editor;
    editor = ContentTools.EditorApp.get();
    editor.init('*[data-editable]', 'data-name');
    ContentTools.StylePalette.add([
        new ContentTools.Style('Content header', 'content_header', ['p']),
        new ContentTools.Style('Content text', 'content', ['p'])
    ]);

    editor.bind('save', function (regions) {
        var name, payload;

        // Set the editor as busy while we save our changes
        this.busy(true);

        // Collect the contents of each region into a FormData instance
        payload = new FormData();
        for (name in regions) {
            if (regions.hasOwnProperty(name)) {
                payload.append(name, regions[name]);
            }
        }
        payload.append("action","save_events");
        console.log(payload);
        // Send the update content to the server to be saved

        centerLoading();
        $('#loader').show();

        $.ajax({
            url: "events_page.php",
            cache: false,
            type: "POST",
            shouldRetry: 3,
            data: payload,
            ProcessData:false,
            processData: false,
            contentType: false
        }).done(function (msg) {

                editor.busy(false);
                new ContentTools.FlashUI('ok');
                $('#loader').hide();
            })
            .fail(function (msg) {
                editor.busy(false);
                new ContentTools.FlashUI('no');
                $('#loader').hide();
            });





    });
}

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
    initContentTools();
    destructor = destructor;

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

