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

$(document).ready(function () {
    $('.menu_href,.a_href').each(function (i, e) {
        $(e).bind('click', reloadHandler);
    });
    $('#lang_changer_href').bind('click', change_lang);
    wellcomeInit();
    progressInit();
    centerLoading();
    load_style_arrays();
});

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
                $('#' + k).text(v);
            })
        });

}

function reloadHandler() {
    destructor();
    reload($(this));
}

function reload(hrefObj) {
    var id = hrefObj.attr("id");
    history.pushState({},'',routes[id].page_name);
    $('.menu_button.active').removeClass('active');
    hrefObj.parent().addClass('active');
    //unload current style
    $('link[class="page_style"]').remove();
    var styles = routes[id].styles;
    var len = styles.length;
    if (len == 0) {
        load_body_and_scripts(id);
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
            document.head.appendChild(l);
            $(l).load(function() {
                loaded_cnt ++;
                if (loaded_cnt == len) {
                    load_body_and_scripts(id);
                }
            });
        });

    }

}

function load_body_and_scripts(id) {
    $.ajax({
        type: "POST",
        url: routes[id].href,
        data: {part: "body_and_footer"},
        async: false
    }).done(function (body) {
            $(".mc_el").remove();

            $("body").append(body);
            //load scripts
            $.ajax({
                type: "POST",
                url: routes[id].href,
                data: {part: "scripts"},
                async: false
            }).done(function (data) {
                    var scripts = $.parseJSON(data);
                    $.each(scripts, function (i, e) {
                        var s = document.createElement("script");
                        s.type = "text/javascript";
                        var src =  "./js/" + e + "?t=" + Date.now();
                        $.ajax({
                            type: "GET",
                            url: src,
                            async: false
                        });
                    });

                });
        });
}

function centerLoading() {
    $('#loader').css('top',$(window).scrollTop());

}

function load_style_arrays() {
    $.each(routes,function(route_i,route) {
        $.ajax({
            type: "POST",
            url: route.href,
            data: {part: "page_styles"},
            async: false
        }).done(function (data) {
                try {
                    var styles = $.parseJSON(data);
                    route.styles =  styles;
                }  catch(e) {

                }
            })
    });
}
