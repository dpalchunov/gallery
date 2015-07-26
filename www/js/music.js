
$(document).ready(function () {

    destructor = destructor;
    setSongsHandlers();
    setPlayButtonHandler();
    setRefsToSongs();
    setControlStates();

});

function setControlStates() {
    window.mini_progress = $("#mini_progress");
    window.mini_inline = $("#mini_inline");
    window.player_mini_button = $("#player_mini_button");
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



