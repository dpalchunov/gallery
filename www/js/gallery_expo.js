<!--Скрпты отвечающие за догрузку нжней части страницы-->

var mouseoverLeftColumnWrap = false;
var nextPageNum = 1;
var getNextPInWork = 0;
var allPicturesLoaded = false;
var returnedPageData = '';



function showFirstPage() {
    if (getNextPInWork == 0) {
        //флаг позволяет запускать функцию сключительно последовательно
        returnedPageData = '';
        rewritePageByPageNum(nextPageNum);
        setPicturesCountByFilter();
        getNextPInWork = 0;
    }
}

function setPicturesCountByFilter() {
    $.post("pic_helper.php", "action=get_pic_count_by_filter&" + $("#filter_form").serialize(),
        function (data) {
            if (trim(data) != '') {
                picturesCountByFilter = data;
            }
        }
    );
}

function trim(str) {
    str = str.replace(/^\s+/, '');
    for (var i = str.length; --i >= 0;) {
        if (/\S/.test(str.charAt(i))) {
            str = str.substring(0, i + 1);
            break;
        }
    }
    return str;
}



function setWindowScrollHandler() {
    $(window).bind('scroll', onScrollfunct);
}

function leftColumnWrapClickHandler() {
    //выключаем обработчик скрола
    $(window).unbind('scroll');
    $('body,html').animate({scrollTop: 0}, 400, setWindowScrollHandler);
    turnOffReturner();
    return false;
}

$(document).ready(function () {
    var scrH = $(window).height();
    var scrHP = $("#container").height();
    setWindowScrollHandler();
    /* чтобы сразу правильно была выставлена переменная mouseoverLeftColumnWrap*/
    turnOffReturner();
    refreshPictures();
    destructor = destructor;
});

function dragAndResize() {
    var images = $(".ui-widget-content");
    var sk = $("#sketches");
    var sk_w = sk.width();
    var sk_h = 0;


    $.each(images, function(i,v) {
        var l_percent = parseFloat($(v).attr("left"));
        var t_ratio = parseFloat($(v).attr("top"));
        var l = l_percent*sk_w;
        var t = t_ratio*l;
        var w = $(v).width();
        var r = $(v).attr("ratio");
        var h = w*r;
        $(v).height(h);
        if (h+t > sk_h) {
            sk_h = h+t
        }

        $(v).resizable({
               // containment: "parent",
                aspectRatio: true,
                stop:function( event, ui ) {
                    save($(v));
                }

            }).draggable({
                    containment:"parent",
                    stop:function( event, ui ) {
                            save($(v));
                    },
                    scroll:true
            }).position({
                my: "left top",
                at: "left+" + l_percent*100 + "% top+" + t,
                of: "#sketches",
                collision: "none"
            });
        $(v).css("position","absolute");
    });

    $(sk).height(sk_h);
    $(sk).resizable({
        stop: function(event,ui) {
            $("#all_space_wrap").height(ui.size.height + $(sk).position().top + 500);
        },
        handles: "s"
    });
    $("#all_space_wrap").height(sk_h + $(sk).position().top + 500 );
}

function save(e) {
    var sk = e.parent();
    var h = e.height();
    var t = e.offset().top - sk.offset().top;
    var l = e.offset().left - sk.offset().left;
    var w = e.width();
    var l_percent = l/sk.width();
    var w_percent = w/sk.width()*100;
    var t_ratio = t/l;
    var r = h/w;
    var pic_id = e.attr("pic_id");

    $.ajax({
        type: "POST",
        shouldRetry: 3,
        url: "gallery_edit.php",
        data: {action:"expo_save",pic_id:pic_id,ratio:r,width:w_percent,left:l_percent,top:t_ratio}
    })
        .done(function (msg) {
            //console.log(msg);
        });
}

function onScrollfunct() {

    var leftH = $("#main_content").height() - $(window).height() - $(this).scrollTop();

    // показать / не показать стрелку возврата
    if ($(this).scrollTop() > 100) {
        turnOnReturner();
    } else {
        turnOffReturner();
    }
}


function turnOnReturner() {
    $('#arrow_pic').css('background-image', "url('../images/returner/arrow.png')");
    //каждый bind - это новый вызов одной и той же функции
    $('#left_column_wrap').unbind("click")
    $('#left_column_wrap').bind("click", leftColumnWrapClickHandler)
    if (mouseoverLeftColumnWrap) {
        $('#left_column_wrap').css('opacity', 0);
        $('#arrow_pic').css('background-color', '#A8A8A8');
    }
    $('#left_column_wrap').hover(function () {
            $(this).css('opacity', 0);
            $('#arrow_pic').css('background-color', '#A8A8A8');
            $('#arrow_pic').css('background-image', "url('../images/returner/arrow.png')");

            mouseoverLeftColumnWrap = true;
        },
        function () {
            $(this).css('opacity', 1);
            $('#arrow_pic').css('background-color', '#000');

            mouseoverLeftColumnWrap = false;
        });
}

function turnOffReturner() {
    $('#left_column_wrap').unbind('click');
    $('#left_column_wrap').css('opacity', 1);
    $('#arrow_pic').css('background-color', '#000');
    $('#arrow_pic').css('background-image', 'none');

    $('#left_column_wrap').hover(function () {
            $(this).css('opacity', 1);
            mouseoverLeftColumnWrap = true;
        },
        function () {
            $(this).css('opacity', 1);
            mouseoverLeftColumnWrap = false;
        });
}


function refreshPictures() {
    allPicturesLoaded = false;
    nextPageNum = 1;
    showFirstPage();

}

function rewritePageByPageNum(pageNum) {
    var allParamsString = makePictureGetterParametersStringForPageGet(pageNum);
    $.post("pic_helper.php", allParamsString,
        //функция обработки полученных данных
        function (data) {
            console.log(data);
            if (trim(data) != '') {
                $("#sketches").html(data);
                dragAndResize();
                var s_images = $(".small_image");
                $.each(s_images, function(i,v) {
                    $(v).hide();

                });
            } else {
                $("#sketches").html("no data");
            }
        }
    )
    nextPageNum++;
}

function makePictureGetterParametersStringForPageGet(pageNum) {
    var checkboxesValueString = $("#filter_form").serialize();
    var pageNumString = "pageNum=" + pageNum;

    var allParamsString = pageNumString + "&" +  "action=get_pic_page"+  "&" +  checkboxesValueString;
    return allParamsString;
}

function destructor() {
    $('.cropper-invisible').remove();
    $(".mc_el").remove();
}





