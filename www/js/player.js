$(document).ready(function(){
    loadPlayList();
    window.songDuration = 0;
    window.currentTrack = 0;



    $("#music_ask_yes").click(function() {
        $("#dialog").hide();
        $("#player").jPlayer("play");
    });


    $("#music_ask_no").click(function() {
        $("#dialog").hide();
    });


	// Local copy of jQuery selectors, for performance.
	window.my_jPlayer = $("#player"),
    window.progress = $("#progress");
	// Initialize the play state text
	// Instance jPlayer
	window.my_jPlayer.jPlayer({
		ready: function () {
            var track_number = 0;
            if (check_audio_cookies()) {
                try {
                    var time = Math.floor(parseFloat($.cookie('track_time')));
                    window.currentTrack = $.cookie('track_number');
                    $(this).jPlayer("setMedia",{
                        title:window.playList[getCurrentInd()].title,
                        mp3: window.playList[getCurrentInd()].mp3
                    });
                    if (($.cookie('paused') == "true")) {
                        $(this).jPlayer("pause",time)
                    } else {
                        $(this).jPlayer("play",time );
                    }
                } catch(e) {
                    //console.error('audio player cookies load failure');
                    $(this).jPlayer("setMedia",{
                        title:window.playList[getCurrentInd()].title,
                        mp3: window.playList[getCurrentInd()].mp3
                    }).jPlayer("play");
                }

            } else {
                $(this).jPlayer("setMedia",{
                    title:window.playList[getCurrentInd()].title,
                    mp3: window.playList[getCurrentInd()].mp3
                }).jPlayer("play");
                setTimeout(function() {check_is_tablet();},300);
            }

            $.cookie("track_number", getCurrentInd(), {expires:365});
            $("#track_count_count").text("[" + (getCurrentInd()+1) + "/" + window.playList.length + "]");
            check_is_tablet();
		},
        loadeddata: function(event){ // calls after setting the song duration
            window.songDuration = event.jPlayer.status.duration;
        },
		timeupdate: function(event) {
            var cur_time = event.jPlayer.status.currentTime;
            $.cookie("track_time", cur_time, {expires:365});
            $("#progress_time_time").text($.jPlayer.convertTime(cur_time));
            var v = parseFloat(event.jPlayer.status.currentPercentAbsolute).toPrecision(3) + "%";
            window.progress.width(v);
		},
        pause: function() {
            console.log("pause_event");
            setCurrentPassive();
            $.cookie("paused", "true", {expires:365});
        },
        ended: function(){
            next();
            window.my_jPlayer.jPlayer("play");
        },
        play: function() {
            console.log("play_event");
            window.start_playing = false;
            $.cookie("paused", "false",{expires:365});
            setCurrentActive();

        },
		swfPath: "./player/swf",
		cssSelectorAncestor: "#player_controls",
		supplied: "mp3",
		wmode: "window",
        smoothPlayBar:true
	});


    $("#header,#inline").bind("click",function(event) {
        var left_border = $("#inline").offset().left;
        var right_border = left_border + $("#inline").width();
        var t = event.target.id;
        if ((t == "header"  || t == "nav_menu" || t == "player_controls" || t == "inline"  || t == "progress") && event.clientX > left_border && event.clientX < right_border) {
            progress_click_handler(event);
        };
    });


    $("#next").bind("click",next);


    $("#prev").bind("click",function(e) {
        if (window.my_jPlayer.data().jPlayer.status.currentTime < 2) {
            setCurrentPassive();
            window.currentTrack--;
            setCounterText();
        }
        changeToCurrent();
    });



});

function next() {
    setCurrentPassive();
    window.currentTrack++;
    setCounterText();
    changeToCurrent();

}

function check_audio_cookies() {
    return  ( $.cookie('track_number') != null) &&
        ($.cookie('track_time') != null) &&
        ($.cookie('paused') != null);
}

$("#inline").bind("click",progress_click_handler);

function progress_click_handler(event) {
    var x = $("#inline").offset().left;
    var delta = event.clientX - x;
    var w = $("#inline").width();
    var pos = delta/w;
    var new_time = pos*window.songDuration;
    if (window.my_jPlayer.data().jPlayer.status.paused) {
        window.my_jPlayer.jPlayer("pause",new_time);
    } else {
        window.my_jPlayer.jPlayer("pause").jPlayer("play",new_time);
    }
}

function loadPlayList() {
    $.ajax({
        type: "POST",
        shouldRetry: 3,
        url: "content_helper.php",
        data: {action: "get_play_list"},
        async:false
    }).done(function (data) {
            try {
                window.playList = $.parseJSON(data);
            } catch(e) {
                //console.error(href + ":" + header_labels + " " + e.message);
            }
        });
}


function setCounterText() {
    $("#track_count_count").text("[" + (getCurrentInd()+1) + "/" + window.playList.length + "]");
}

function changeToCurrent() {
    $.cookie("track_number", getCurrentInd(), {expires:365});
    var wasPaused = window.my_jPlayer.data().jPlayer.status.paused;
    var cur = getCurrentInd();
    var p = window.my_jPlayer.jPlayer("setMedia",{
        title:window.playList[cur].title,
        mp3: window.playList[cur].mp3
    });
    if (!wasPaused || window.start_playing) {
        window.start_playing = true;
        p.jPlayer("play");
    }

}

function getCurrentInd() {
    var l = window.playList.length;
    var offset = Math.floor(window.currentTrack/l)*l;
    var movedCurrent = window.currentTrack - offset;
    return movedCurrent%l;
}

function check_is_tablet() {
    if (navigator.userAgent.match(/Android/i) ||
        navigator.userAgent.match(/webOS/i) ||
        navigator.userAgent.match(/iPhone/i) ||
        navigator.userAgent.match(/iPad/i) ||
        navigator.userAgent.match(/iPod/i) ||
        navigator.userAgent.match(/BlackBerry/i) ||
        navigator.userAgent.match(/Windows Phone/i) ||
        navigator.userAgent.match(/ZuneWP7/i)
        ) {

        $("#dialog").css('display','table');
        $("#dialog").show();
    }
}

function setCurrentActive() {
    window.playList[getCurrentInd()].songRef.addClass("active");
}

function setCurrentPassive() {
    window.playList[getCurrentInd()].songRef.removeClass("active");
}