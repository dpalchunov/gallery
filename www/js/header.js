var routes = {
    about_href: "./about.php/",
    gallery_href: "./gallery.php/",
    buy_href: "./contacts.php/"
};

$(document).ready(function () {
    $('.menu_href').each(function (i, e) {
        $(e).bind('click', reload);
    });
    //alert('header_ready');

});


function reload() {
    var id = $(this).attr("id");
    $.post(routes[id], {part: "head_content"}).done(function (data) {
        $("head").html(data);

        $.ajax({
            type: "POST",
            url: routes[id],
            data: {part: "styles"},
            async: false
        }).done(function (data) {
                var links = $.parseJSON(data);
                console.log(links);
                $.each(links, function (i, e) {
                    var l = document.createElement("link");
                    l.rel = "stylesheet";
                    l.type = "text/css";
                    l.href = "./css/" + e + "?t=" + Date.now();
                    document.head.appendChild(l);
                });
                $.ajax({
                    type: "POST",
                    url: routes[id],
                    data: {part: "body"},
                    async: false
                }).done(function (body) {
                        $.ajax({
                            type: "POST",
                            url: routes[id],
                            data: {part: "header"},
                            async: false
                        }).done(function (header) {
                                $("body").html(header + body);

                                $.ajax({
                                    type: "POST",
                                    url: routes[id],
                                    data: {part: "scripts"},
                                    async: false
                                }).done(function (data) {
                                        var scripts = $.parseJSON(data);
                                        var last = scripts.length - 1;
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
    });


}

