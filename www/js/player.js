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

    var currentTrack = 1;

	// Local copy of jQuery selectors, for performance.
	var	my_jPlayer = $("#player"),
        progress = $("#progress");
	// Initialize the play state text
	// Instance jPlayer
	my_jPlayer.jPlayer({
		ready: function () {
            $(this).jPlayer("setMedia",{
                title:playList[currentTrack].title,
                mp3: playList[currentTrack].mp3
            });//.jPlayer("play",40);
            $("#track_count_count").text("[" + (getCurrentInd()+1) + "/" + playList.length + "]");
		},
        loadeddata: function(event){ // calls after setting the song duration
            songDuration = event.jPlayer.status.duration;

        },
		timeupdate: function(event) {
            $("#progress_time_time").text($.jPlayer.convertTime( event.jPlayer.status.currentTime));
            var v = parseFloat(event.jPlayer.status.currentPercentAbsolute).toPrecision(3) + "%";
            progress.width(v);
		},
		swfPath: "./swf",
		cssSelectorAncestor: "#player_controls",
		supplied: "mp3",
		wmode: "window",
        smoothPlayBar:true
	});

    $("#inline").bind("click",function(event) {
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
    })

    $("#next").bind("click",function(e) {
        currentTrack++;
        $("#track_count_count").text("[" + (getCurrentInd()+1) + "/" + playList.length + "]");
        playcurrent();
    });

    $("#prev").bind("click",function(e) {
        if (my_jPlayer.data().jPlayer.status.currentTime < 2) {
            currentTrack--;
            $("#track_count_count").text("[" + (getCurrentInd()+1) + "/" + playList.length + "]");
        }
        playcurrent();
    });

    function playcurrent() {
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