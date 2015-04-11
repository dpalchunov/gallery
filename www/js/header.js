var destructor = function() {

} ;

var routes = {
    greeting_href: {href:"greeting.php",page_name:'greeting.php'},
    about_href: {href:"about.php",page_name:'about.php'},
    gallery_href: {href:"gallery.php",page_name:'gallery.php'},
    buy_href: {href:"contacts.php",page_name:'contacts.php'},
    edit_exposition_href: {href:"gallery_expo_edit.php",page_name:'gallery_expo_edit.php'},
    edit_gallery_href: {href:"gallery_edit.php",page_name:'gallery_edit.php'},
    edit_about_href: {href:"about_edit.php",page_name:'about_edit.php'},
    edit_welcome_href: {href:"wellcome_edit.php",page_name:'wellcome_edit.php'}
};

var loaded_body = "";
var body_loaded = null;
var styles_loaded = null;
var styles_arrays_loaded_cnt=0;
var script_arrays_loaded_cnt=0;
var script_arrays_loaded = false;
var styles_arrays_loaded = false;

$(document).ready(function () {
    load_style_arrays();
    load_scripts_arrays();

    progressInit();
    centerLoading();
    initMenuHandlers();


});


function initMenuHandlers() {
    if (window.script_arrays_loaded && window.styles_arrays_loaded) {
        wellcomeInit();
        $('.menu_href,.a_href').each(function (i, e) {
            $(e).bind('click', reloadHandler);
        });
        $('#lang_changer_href').bind('click', change_lang);
    } else {
        setTimeout(initMenuHandlers,500);
    }

}

function progressInit() {
    $("#header").bind("mouseenter",function(e) {
        $("#inline").height(9);
        $("#progress_time_time").css("color","grey");
        $("#track_count_count").css("color","grey");
    });
    $("#header").bind("mouseleave",function(e) {
        $("#inline").height(3);
        $("#progress_time_time").css("color","black")
        $("#track_count_count").css("color","black")
    });
    $("#outline").bind("mouseenter",function(e) {
        $("#inline").height(9);
        $("#progress_time_time").css("color","grey")
        $("#track_count_count").css("color","grey")
    });
    $("#outline").bind("mouseleave",function(e) {
        $("#inline").height(3);
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
        url: 'change_lang.php',
        data: {},
        success:function(output, status, xhr) {
            //reload($('.menu_button.active').children().first());
        },
        async:false,
        cache:false
    });
    $.ajax({
        type: "POST",
        url: routes[$('.menu_button.active').children().first().attr('id')].href,
        data: {part: "header_labels"},
        async:false
    }).done(function (data) {
            var labels = $.parseJSON(data);

            $.each(labels,function (k,v) {
                $('#' + k).html(v);
            })
        });

}

function reloadHandler() {
    destructor();
    reload($(this));
}

function reload(hrefObj) {
    centerLoading();
    $("#loader").show();
    var id = hrefObj.attr("id");
    window.loaded_body = "";
    window.body_loaded = false;
    window.styles_loaded = false;

    try {
        history.pushState({},'',routes[id].page_name);
    } catch(e) {
        console.log(e.message);
    }

    $('.menu_button.active').removeClass('active');
    hrefObj.parent().addClass('active');
    //unload current style
    $('link[class="page_style"]').remove();

    load_body(id);
    var styles = routes[id].styles;
    var len = styles.length;
    if (len == 0) {
        window.styles_loaded = true;
        replace_body_load_scripts(id);
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
                    replace_body_load_scripts(id);
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
        $.ajax({
            type: "POST",
            url: route.href,
            data: {part: "page_styles"},
            async: true
        }).done(function (data) {
                window.styles_arrays_loaded_cnt ++;
                try {
                    var styles = $.parseJSON(data);
                    route.styles =  styles;
                }  catch(e) {

                }
                if (window.styles_arrays_loaded_cnt == len) {
                    window.styles_arrays_loaded = true;
                }
            })
    });
}

function load_scripts_arrays() {
    var key,len = 0;
    for(key in routes) {
        if(routes.hasOwnProperty(key)) {
            len++;
        }
    }
    $.each(routes,function(route_i,route) {
        $.ajax({
            type: "POST",
            url: route.href,
            data: {part: "scripts"},
            async: true
        }).done(function (data) {
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
    });
}

function load_body(id) {
    $.ajax({
        type: "POST",
        url: routes[id].href,
        data: {part: "body_and_footer"},
        async: true
    }).done(function (body) {
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
            url: src,
            async: false
        });
    });
}

function replace_body_load_scripts(id) {
    if (window.body_loaded && window.styles_loaded)  {
        $(".mc_el").remove();

        $("body").append(window.loaded_body);
        $("#loader").hide();
        load_scripts(id);
        window.body_loaded = null;
        window.styles_loaded = null;
    }
}