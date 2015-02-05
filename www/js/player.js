$(document).ready(function(){
	// Local copy of jQuery selectors, for performance.
	var	my_jPlayer = $("#player"),
        progress = $("#progress");
	// Initialize the play state text
	// Instance jPlayer
	my_jPlayer.jPlayer({
		ready: function () {
            $(this).jPlayer("setMedia",{
                title:"1.mp3",
                mp3: './mp3/1.mp3'
            });//.jPlayer("play",40);
		},
        loadeddata: function(event){ // calls after setting the song duration
            songDuration = event.jPlayer.status.duration;
        },
		timeupdate: function(event) {
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
        my_jPlayer.jPlayer("pause").jPlayer("play",new_time);
    })

});