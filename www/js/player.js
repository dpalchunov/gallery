$(document).ready(function(){
	var playList = [{
                        title:"1.mp3",
                        mp3: './mp3/1.mp3'
                    },
                    {
                        title:"2.mp3",
                        mp3: './mp3/2.mp3'
                    },
                    {
                        title:"3.mp3",
                        mp3: './mp3/3.mp3'
                    },
                    {
                        title:"4.mp3",
                        mp3: './mp3/4.mp3'
                    },
                    {
                        title:"5.mp3",
                        mp3: './mp3/5.mp3'
                    }];
    var currentTrack = 0;
	// Local copy of jQuery selectors, for performance.
	var	my_jPlayer = $("#player"),
        progress = $("#progress");
	// Initialize the play state text
	// Instance jPlayer
	my_jPlayer.jPlayer({
		ready: function () {
            var track_number = 0;
            if (check_audio_cookies()) {
                try {
                    var time = Math.floor(parseFloat($.cookie('track_time')));
                    currentTrack = $.cookie('track_number');
                    $(this).jPlayer("setMedia",{
                        title:playList[currentTrack].title,
                        mp3: playList[currentTrack].mp3
                    });
                    if (($.cookie('paused') == "true")) {
                        $(this).jPlayer("pause",time)
                    } else {
                        $(this).jPlayer("play",time );
                    }
                } catch(e) {
                    console.error('audio player cookies load failure');
                    $(this).jPlayer("setMedia",{
                        title:playList[currentTrack].title,
                        mp3: playList[currentTrack].mp3
                    }).jPlayer("play");
                }

            } else {
                $(this).jPlayer("setMedia",{
                    title:playList[currentTrack].title,
                    mp3: playList[currentTrack].mp3
                }).jPlayer("play");
            }

            $.cookie("track_number", getCurrentInd(), {expires:365});
            $("#track_count_count").text("[" + (getCurrentInd()+1) + "/" + playList.length + "]");
		},
        loadeddata: function(event){ // calls after setting the song duration
            songDuration = event.jPlayer.status.duration;

        },
		timeupdate: function(event) {
            var cur_time = event.jPlayer.status.currentTime;
            $.cookie("track_time", cur_time, {expires:365});
            $("#progress_time_time").text($.jPlayer.convertTime(cur_time));
            var v = parseFloat(event.jPlayer.status.currentPercentAbsolute).toPrecision(3) + "%";
            progress.width(v);
		},
        pause: function(event) {
            $.cookie("paused", "true", {expires:365});
        },
        ended: function(event){
            next();
            my_jPlayer.jPlayer("play");
        },
        play: function(event) {
            $.cookie("paused", "false",{expires:365});
        },
		swfPath: "./swf",
		cssSelectorAncestor: "#player_controls",
		supplied: "mp3",
		wmode: "window",
        smoothPlayBar:true
	});

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
        var new_time = pos*songDuration;
        if (my_jPlayer.data().jPlayer.status.paused) {
            my_jPlayer.jPlayer("pause",new_time);
        } else {
            my_jPlayer.jPlayer("pause").jPlayer("play",new_time);
        }
    }


    $("#header").bind("click",function(event) {
        console.log(event.target.id);
        var left_border = $("#inline").offset().left;
        var right_border = left_border + $("#inline").width();
        var t = event.target.id;
        if ((t == "header"  || t == "nav_menu" || t == "player_controls") && event.clientX > left_border && event.clientX < right_border) {
            progress_click_handler(event);
        }

    });


    $("#next").bind("click",next);

    function next() {
        currentTrack++;
        $("#track_count_count").text("[" + (getCurrentInd()+1) + "/" + playList.length + "]");
        playcurrent();
    }

    $("#prev").bind("click",function(e) {
        if (my_jPlayer.data().jPlayer.status.currentTime < 2) {
            currentTrack--;
            $("#track_count_count").text("[" + (getCurrentInd()+1) + "/" + playList.length + "]");
        }
        playcurrent();
    });

    function playcurrent() {
        $.cookie("track_number", getCurrentInd(), {expires:365});
        var wasPaused = my_jPlayer.data().jPlayer.status.paused;
        var cur = getCurrentInd();
        var p = my_jPlayer.jPlayer("setMedia",{
            title:playList[cur].title,
            mp3: playList[cur].mp3
        });
        if (!wasPaused) {
            p.jPlayer("play");
        }

    }

    function getCurrentInd() {
        var l = playList.length;
        var offset = Math.floor(currentTrack/l)*l;
        var movedCurrent = currentTrack - offset;
        var ind = movedCurrent%l;
        return ind;
    }

});