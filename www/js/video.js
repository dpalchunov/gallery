
$(document).ready(function () {
    destructor = destructor;

    var $window = $(window),
        $stickyEl = $('#outline'),
        elTop = $stickyEl.offset().top;

    $window.scroll(function() {
        $stickyEl.toggleClass('sticky', $window.scrollTop() > elTop);
    });
    initVideoPlayer();
    setImagesMousehandler();
    setImagesClickhandler();

});

function initVideoPlayer() {
    var first_video = $('.grid_list_cell.video');
    if  (first_video != null) {
        $('.webPlayer').videoPlayer({
            name: 'now or never',
            media: {
                m4v: $(first_video).attr('video_path') ,
                poster: $(first_video).attr('thumb_url')
            },
            backgroundColor: "#000",
            size: {
                width: '100%',
                height: 'auto'
            },

            // These go directly to jPlayer object, allowing you to rewrite any player setting
            loadstart: function() {
                //alert('Video loading started!');
            }

        });
    }


}

function setImagesMousehandler() {
    var p = $('.video');
    var details = p.find('[class=details]');
    p.unbind('mouseenter');
    p.bind('mouseenter', smallImageMouseOverHandler);

    p.unbind('mouseleave');
    p.bind('mouseleave', mleave);

}

function smallImageMouseOverHandler(event) {
    if (event.target.className == "grid_list_cell video") {
        var pic = $(this);
        var details = pic.find('[class=details]');
        details.css('height', $(pic).height());
        details.fadeIn("fast",function() {
        });
    }


}

function mleave() {
    hideDetails($(this));
};

function hideDetails(p) {
    var details = p.find('[class=details]');
    details.hide();
}

function destructor() {
    $(".mc_el").remove();
}

function setImagesClickhandler() {

    $('.video').unbind('click');
    $('.video').bind('click', smallImageClickHandler);
}


function smallImageClickHandler() {
    var p = $("#uniqueContainer-1").jPlayer("setMedia",{
        m4v: $(this).attr("video_path"),
        poster: $(this).attr("thumb_url")
    });
}




