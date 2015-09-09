var destructor = function() {

};

var after_change_labels = function() {

};

var routes = {
    greeting_href: {href:"greeting.php",page_name:'greeting.php',title: 'Greeting'},
    video_href: {href:"video.php",page_name:'video.php',title: 'Video'},

    band_href: {href:"band.php",page_name:'band.php',title: 'Band'},
    music_href: {href:"music.php",page_name:'music.php',title: 'Music'},
    lyrics_href: {href:"lyrics.php",page_name:'lyrics.php',title: 'Lyrics'},
    contact_href: {href:"contact.php",page_name:'contact.php',title: 'Contact'},
    photo_href: {href:"photo.php",page_name:'photo.php',title: 'Photo'},

    home_href: {href:"home.php",page_name:'home.php',title: 'Home'},
    about_href: {href:"about.php",page_name:'about.php',title: 'About'},
    gallery_href: {href:"gallery.php",page_name:'gallery.php',title: 'Gallery'},
    buy_href: {href:"contacts.php",page_name:'contacts.php',title: 'Contacts'},
    edit_exposition_href: {href:"gallery_expo_edit.php",page_name:'gallery_expo_edit.php',title: 'Gallery_expo_edit'},
    edit_gallery_href: {href:"gallery_edit.php",page_name:'gallery_edit.php',title: 'Gallery_edit'},
    edit_video_href: {href:"video_edit.php",page_name:'video_edit.php',title: 'Video_edit'},
    edit_songs_href: {href:"songs_edit.php",page_name:'songs_edit.php',title: 'Songs_edit'},
    edit_about_href: {href:"about_edit.php",page_name:'about_edit.php',title: 'About_edit'},
    edit_welcome_href: {href:"wellcome_edit.php",page_name:'wellcome_edit.php',title: 'Wellcome_edit'}
};


window.loaded_body = "";
window.body_loaded = null;
window.styles_loaded = null;
window.styles_arrays_loaded_cnt=0;
window.script_arrays_loaded_cnt=0;
window.script_arrays_loaded = false;
window.styles_arrays_loaded = false;

$(document).ready(function () {


    load_style_arrays();
    load_scripts_arrays();

    progressInit();
    centerLoading();
    initMenuHandlers();
    sticky_player();

});

function sticky_player() {
    var $window = $(window),
        $stickyEl = $('#outline'),
        elTop = $stickyEl.offset().top;

    $window.scroll(function() {
        $stickyEl.toggleClass('sticky', $window.scrollTop() > elTop);
    });
}


function initMenuHandlers() {
    if (window.script_arrays_loaded && window.styles_arrays_loaded) {
        wellcomeInit();
        $('.menu_href,.a_href').each(function (i, e) {
            $(e).bind('click', reloadHandler);
        });
        $('.lang_changer_href').bind('click', change_lang);
    } else {
        setTimeout(initMenuHandlers,500);
    }

}

function progressInit() {
    var h = 5;
    var l = 1;

    $("#header").bind("mouseenter",function(e) {
        $("#inline").height(h);
        $("#progress").height(h);
        $("#progress_time_time").css("color","grey");
        $("#track_count_count").css("color","grey");
    });
    $("#header").bind("mouseleave",function(e) {
        $("#inline").height(l);
        $("#progress").height(l);
        $("#progress_time_time").css("color","black")
        $("#track_count_count").css("color","black")
    });
    $("#outline").bind("mouseenter",function(e) {
        $("#inline").height(h);
        $("#progress").height(h);
        $("#progress_time_time").css("color","grey")
        $("#track_count_count").css("color","grey")
    });
    $("#outline").bind("mouseleave",function(e) {
        $("#inline").height(l);
        $("#progress").height(l);
        $("#progress_time_time").css("color","black")
        $("#track_count_count").css("color","black")
    });

}

function headerNameClickHandler() {
    destructor();
    reload($("#greeting_href"));
    $("#header").hide();
    $("#footer").hide();
}

function wellcomeInit() {
    $('#header_name').bind('click', headerNameClickHandler);
}

function change_lang() {
    $.ajax({
        type: "POST",
        shouldRetry: 3,
        url: 'change_lang.php',
        data: {},
        async:false,
        cache:false
    });
    change_labels();

}

function change_labels() {
    var href =routes[$('.menu_href.active').first().attr('id')].href;
    var part = "header_labels";
    $.ajax({
        type: "POST",
        shouldRetry: 3,
        url: href,
        data: {part: part},
        async:false
    }).done(function (data,y,jqXHR) {
            if (part != jqXHR.getResponseHeader('part')) {
                change_labels();
                return;
            }
            try {
                var labels = $.parseJSON(data);
                console.log(labels);
            } catch(e) {
                console.error(href + ":" + header_labels + " " + e.message);
            }
            $.each(labels,function (k,v) {
                $('[label="' + k + '"]').html(v);
            })
            after_change_labels();
        });
}

function reloadHandler() {
    destructor();
    reload($(this));
}

function reload(hrefObj) {
    console.log('start_reload');
    centerLoading();
    $("#loader").show();
    var dst = hrefObj.attr("dst");
    window.loaded_body = "";
    window.body_loaded = false;
    window.styles_loaded = false;

    try {
        history.pushState({},'',routes[dst].page_name);
    } catch(e) {
        //console.log(e.message);
    }

    $('.active').removeClass('active');
    hrefObj.addClass('active');
    document.title = routes[dst].title;
    //unload current style
    $('link[class="page_style"]').remove();

    load_body(dst);
    var styles = routes[dst].styles;
    var len = styles.length;
    if (len == 0) {
        window.styles_loaded = true;
        replace_body_load_scripts(dst);
    }  else {
        var loaded_cnt = 0;
        $.each(styles, function (i, e) {
            var l = document.createElement("link");
            l.rel = "stylesheet";
            l.type = "text/css";
            l.href = "./css/" + e + "?t=" + Date.now();
            var c = document.createAttribute("class");
            c.value = "page_style";
            l.setAttributeNode(c);
            document.getElementsByTagName('head')[0].appendChild(l);
            $(l).load(function() {
                loaded_cnt ++;
                if (loaded_cnt == len) {
                    window.styles_loaded = true;
                    replace_body_load_scripts(dst);
                }
            });
        });

    }

}


function centerLoading() {
    $('#loader').css('top',$(window).scrollTop());

}

function load_style_arrays() {
    var key,len = 0;
    for(key in routes) {
        if(routes.hasOwnProperty(key)) {
            len++;
        }
    }
    $.each(routes,function(route_i,route) {
        load_style_array(route,len);
    });
}

function load_style_array(route,len) {
    var part = "page_styles";
    $.ajax({
        type: "POST",
        shouldRetry: 3,
        url: route.href,
        data: {part: part},
        async: true
    }).done(function (data,y,jqXHR) {
            if (part != jqXHR.getResponseHeader('part')) {
                load_style_array(route,len);
                return;
            }

            window.styles_arrays_loaded_cnt ++;
            try {
                var styles = $.parseJSON(data);
                route.styles =  styles;
            }  catch(e) {
                //console.error("parse error on " + route.href + " " + data);

            }
            if (window.styles_arrays_loaded_cnt == len) {
                window.styles_arrays_loaded = true;
            }
        })
}

function load_scripts_arrays() {
    var key,len = 0;
    for(key in routes) {
        if(routes.hasOwnProperty(key)) {
            len++;
        }
    }
    $.each(routes,function(route_i,route) {
        load_scripts_array(route,len);
    });
}

function load_scripts_array(route,len) {
    var part = "scripts";
    $.ajax({
        type: "POST",
        shouldRetry: 3,
        url: route.href,
        data: {part: "scripts"},
        async: true
    }).done(function (data,y,jqXHR) {
            if (part != jqXHR.getResponseHeader('part')) {
                load_scripts_array(route,len);
                return;
            }
            window.script_arrays_loaded_cnt ++;
            try {
                var scripts = $.parseJSON(data);
                route.scripts =  scripts;
            }  catch(e) {

            }
            if (window.script_arrays_loaded_cnt == len) {
                window.script_arrays_loaded = true;
            }
        })
}

function load_body(id) {
    //console.log('start_load_body');
    var part = "body";
    $.ajax({
        type: "POST",
        shouldRetry: 3,
        url: routes[id].href,
        data: {part: "body"},
        async: true
    }).done(function (body,y,jqXHR) {
            if (part != jqXHR.getResponseHeader('part')) {
                //console.log(' ie fail');
                load_body(id);
                return;
            }
            //console.log(' ie good')
            window.body_loaded = true;
            window.loaded_body = body;
            replace_body_load_scripts(id);
        });

}

function load_scripts(id) {
    var scripts = routes[id].scripts;
    $.each(scripts, function (i, e) {
        var src =  "./js/" + e + "?t=" + Date.now();
        $.ajax({
            type: "GET",
            shouldRetry: 3,
            url: src,
            async: false
        });
    });
}

function replace_body_load_scripts(id) {
    if (window.body_loaded && window.styles_loaded)  {
        $(".mc_el").remove();
        $("#footer").before(window.loaded_body);
        $("#loader").hide();
        load_scripts(id);
        window.body_loaded = null;
        window.styles_loaded = null;
    }
}