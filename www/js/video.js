
$(document).ready(function () {


    destructor = destructor;

    var $window = $(window),
        $stickyEl = $('#outline'),
        elTop = $stickyEl.offset().top;

    $window.scroll(function() {
        $stickyEl.toggleClass('sticky', $window.scrollTop() > elTop);
    });
    initVideoPlayer();

});

function initVideoPlayer() {
    $("#uniqueContainer-2").jPlayer({
        ready: function () {
            $(this).jPlayer("setMedia", {
                title: "Now or never",
                m4v: "video/Now or never.m4v",
                poster: "images/gallary/20150425101034.jpeg"
            });
        },
        cssSelectorAncestor: "",
        swfPath: "./player/swf",
        supplied: "m4v",
        useStateClassSkin: true,
        autoBlur: false,
        smoothPlayBar: true,
        keyEnabled: true,
        remainingDuration: true,
        toggleDuration: true,
        size: {
            width: "100%",
            height: "auto"
        },
        cssSelector: {
            videoPlay: ".video-play",
            play: ".play",
            pause: ".pause",
            seekBar: ".seekBar",
            playBar: ".playBar",
            volumeBar: ".currentVolume",
            volumeBarValue: ".currentVolume .curvol",
            currentTime: ".time.current",
            duration: ".time.duration",
            fullScreen: ".fullScreen",
            restoreScreen: ".fullScreenOFF",
            gui: ".controls",
            noSolution: ".noSolution"
        }
    });
}


function destructor() {
    $(".mc_el").remove();
}



