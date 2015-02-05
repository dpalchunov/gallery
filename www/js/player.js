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
		timeupdate: function(event) {
            var v = parseFloat(event.jPlayer.status.currentPercentAbsolute).toPrecision(3) + "%";
            console.log(v);
            progress.width(v);
		},
		swfPath: "./swf",
		cssSelectorAncestor: "#player_controls",
		supplied: "mp3",
		wmode: "window",
        smoothPlayBar:true
	});

});