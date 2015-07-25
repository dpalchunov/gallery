
$(document).ready(function () {
    alert("jkl");

    destructor = destructor;

    var $window = $(window),
        $stickyEl = $('#outline'),
        elTop = $stickyEl.offset().top;

    $window.scroll(function() {
        $stickyEl.toggleClass('sticky', $window.scrollTop() > elTop);
    });
    setSongsHandlers();
    setPlayButtonHandler();
    setRefsToSongs();

});

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



