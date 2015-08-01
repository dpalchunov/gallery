
$(document).ready(function () {

    destructor = destructor;

    var $window = $(window),
        $stickyEl = $('#outline'),
        elTop = $stickyEl.offset().top;

    $window.scroll(function() {
        $stickyEl.toggleClass('sticky', $window.scrollTop() > elTop);
    });

    if (window.my_jPlayer.data().jPlayer == undefined) {
        initPlayer();
    }

    initPlayerFunctions();

});

function initPlayerFunctions() {
    setSongsHandlers();
    setPlayButtonHandler();
    setRefsToSongs();
    mapVarsToControls();
    setControlStates();
    initPlayerControls();
}

function mapVarsToControls() {
    window.mini_progress = $("#mini_progress");
    window.mini_inline = $("#mini_inline");
    window.player_mini_button = $("#player_mini_button");
    window.track_count_count = $("#track_count_count");
    window.progress_time_time = $("#progress_time_time");
    window.next_ctrl = $("#next");
    window.prev = $("#prev");
}

function setControlStates() {

    if (window.my_jPlayer.data().jPlayer.status.paused) {
        setMiniPlayerButtonPaused();
        setCurrentPassive();
    } else {
        setMiniPlayerButtonPlaying();
        setCurrentActive();
    }
    updateTimeAndCount();
    setTitle();


}

function initPlayerControls() {
    window.mini_inline.bind("click",function(event) {
        progress_click_handler(window.mini_inline,event);
    });

    window.next_ctrl.bind("click",next);

    window.prev.bind("click",function(e) {
        if (window.my_jPlayer.data().jPlayer.status.currentTime < 2) {
            setCurrentPassive();
            window.currentTrack--;
            setCounterText();
        }
        changeToCurrent();
    });
}

function setTitle() {
    window.my_jPlayer.jPlayer( "option", "cssSelector", {title: "#song_title"} );
    $("#song_title").text(window.playList[getCurrentInd()].title);

}

function updateTimeAndCount() {
    var cur_time = window.my_jPlayer.data().jPlayer.status.currentTime;
    $("#progress_time_time").text($.jPlayer.convertTime(cur_time));
    var v = parseFloat(window.my_jPlayer.data().jPlayer.status.currentPercentAbsolute).toPrecision(3) + "%";
    window.progress.width(v);
    window.mini_progress.width(v);
    $("#track_count_count").text("[" + (getCurrentInd()+1) + "/" + window.playList.length + "]");
}


function setPlayButtonHandler() {
    $("#player_mini_button").bind("click",function() {
        if ($("#player_mini_button").hasClass("playing") ) {
            window.my_jPlayer.jPlayer("play");
        }  else {
            window.my_jPlayer.jPlayer("pause");
        }

    });
}



function setSongsHandlers()  {
    var songs =  $(".song");
    $.each(songs, function(i,v) {
        $(v).bind("click",function() {
            var cur_is_active = $(this).hasClass("active");
            setCurrentPassive();
            if (cur_is_active) {
                window.my_jPlayer.jPlayer("pause");
            } else {
                window.currentTrack  = window.playList.map(function(e) {return e.mp3;}).indexOf($(this).attr("song_path"));
                setCounterText();
                changeToCurrent();
                setCurrentActive();
                window.my_jPlayer.jPlayer("play");
            }



        });
    });
}

function setRefsToSongs() {
    var song_controls = $(".song");
    $.each(window.playList, function(i,v) {
        var song = song_controls.filter(function() {
            return $(this).attr('song_path') == v.mp3;
        });
        v.songRef = song;
    });
}



function destructor() {
    $(".mc_el").remove();
}



