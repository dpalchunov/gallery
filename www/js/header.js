var routes = {
    about_href: {href:"./about.php/",page_name:'about.php'},
    gallery_href: {href:"./gallery.php/",page_name:'gallery.php'},
    buy_href: {href:"./contacts.php/",page_name:'contacts.php'}
};

$(document).ready(function () {
    $('.menu_href').each(function (i, e) {
        $(e).bind('click', reload);
    });
});


function reload() {
    var id = $(this).attr("id");
    history.pushState({},'',routes[id].page_name);
    $('.menu_button.active').removeClass('active');
    $(this).parent().addClass('active');
    $.post(routes[id].href, {part: "head_content_and_styles"}).done(function (data) {
        $("head").html(data);
        $.ajax({
            type: "POST",
            url: routes[id].href,
            data: {part: "styles"},
            async: false
        }).done(function (data) {
                var links = $.parseJSON(data);
                console.log(links);
//                $.each(links, function (i, e) {
//                    var l = document.createElement("link");
//                    l.rel = "stylesheet";
//                    l.type = "text/css";
//                    l.href = "./css/" + e + "?t=" + Date.now();
//                    //document.head.appendChild(l);
//                });
                $.ajax({
                    type: "POST",
                    url: routes[id].href,
                    data: {part: "body"},
                    async: false
                }).done(function (body) {
                        $("#body_wrapper").html(body);
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
            });
    });


}

