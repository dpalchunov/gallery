
$(document).ready(function () {
    destructor = destructor;
    mainInit();
});


function destructor() {
    $(".mc_el").remove();
}

function mainInit() {
    initListCLickHandlers();
    setFirstLyrics();
}

function initListCLickHandlers() {
    $(".song").bind("click",function(event) {
        var lyrics = $(this).attr("song_lyrics");
        $("#song_lyrics").html(lyrics);
    });
}

function setFirstLyrics() {
        var lyrics = $(".song").first().attr("song_lyrics");
        $("#song_lyrics").html(lyrics);

}



