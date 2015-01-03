<!--Скрпты отвечающие за догрузку нжней части страницы-->

var mouseoverLeftColumnWrap = false;
var nextPageNum = 1;
var getNextPInWork = 0;
var allPicturesLoaded = false;
var returnedPageData = '';
var img_state_idle = 1,
    img_state_dragging = 2,
    img_state_persist_delay = 3




//функция получает следующую страницу
function getNextP() {
    if (getNextPInWork == 0) {
        //флаг позволяет запускать функцию сключительно последовательно
        getNextPInWork = 1;
        returnedPageData = '';
        appendPageByPageNum(nextPageNum);
        getNextPInWork = 0;
    }
}

function showFirstPage() {
    if (getNextPInWork == 0) {
        //флаг позволяет запускать функцию сключительно последовательно
        getNextPInWork = 1;
        returnedPageData = '';
        rewritePageByPageNum(nextPageNum);
        setPicturesCountByFilter();
        getNextPInWork = 0;
    }
}

function setPicturesCountByFilter() {
    $.post("getPicturesCountByFilter.php", $("#filter_form").serialize(),
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
    dragAndResize();
    //showFilterContentInPanel();
});

function dragAndResize() {
    var images = $(".ui-widget-content");
    var sk = $("#sketches");
    var sk_l = sk.offset().left;
    var sk_t = sk.offset().top;
    var sk_w = sk.width();

    $.each(images, function(i,v) {
        var l_percent = parseFloat($(v).attr("left"));
        var t_ratio = parseFloat($(v).attr("top"));
        var l = l_percent*sk_w;
        var t = t_ratio*l;
        $(v).offset({top:sk_t + t,left:sk_l + l});

        var w = $(v).width();
        var r = $(v).attr("ratio");
        $(v).height(w*r);

        $(v).resizable(
            {   aspectRatio: true,
                stop:function( event, ui ) {
                save($(v));

            }}).draggable(
                {stop:function( event, ui ) {
                save($(v));
        }});


    });
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
        url: "gallery_expo_save.php",
        data: {pic_id:pic_id,ratio:r,width:w_percent,left:l_percent,top:t_ratio}
    })
        .done(function (msg) {
            console.log(msg);
        });
}

function turnOnReturner() {
    //каждый bind - это новый вызов одной и той же функции
    $('#left_column_wrap').unbind("click")
    $('#left_column_wrap').bind("click", leftColumnWrapClickHandler)
    if (mouseoverLeftColumnWrap) {
        $('#left_column_wrap').css('opacity', 0);
        $('#arrow_pic').css('background-color', '#7e7e7e');
    }
    $('#left_column_wrap').hover(function () {
            $(this).css('opacity', 0);
            $('#arrow_pic').css('background-color', '#7e7e7e');
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
    $('#left_column_wrap').hover(function () {
            $(this).css('opacity', 1);
            mouseoverLeftColumnWrap = true;
        },
        function () {
            $(this).css('opacity', 1);
            mouseoverLeftColumnWrap = false;
        });
}

function setLeftColumnWrapHeightEquilToMain() {
    if ((typeof $('#page_wrap').css("height")) != "undefined") {
        pageWrapHeight = $("#page_wrap").css('height');
        pageWrapHeight.replace(/[^-\d\.]/g, '');
        $("#left_column_wrap").css('height', parseInt(pageWrapHeight));
    }
}

function refreshPictures() {
    allPicturesLoaded = false;
    nextPageNum = 1;
    showFirstPage();

}

function rewritePageByPageNum(pageNum) {
    var allParamsString = makePictureGetterParametersStringForPageGet(pageNum);
    $.post("getPicturePage.php", allParamsString,
        //функция обработки полученных данных
        function (data) {
            if (trim(data) != '') {
                $("#sketches").html(data);
                dragAndResize();
                var s_images = $(".small_image");
                $.each(s_images, function(i,v) {
                    $(v).hide();

                });
            } else {
                $("#sketches").html("<tr><td colspan=3 padding=25px>&nbsp &nbsp &nbsp &nbsp &nbsp{{{$no_results}}}</td></tr>");
                showFooter();
            }
        }
    )
    nextPageNum++;
}

function makePictureGetterParametersStringForPageGet(pageNum) {
    var checkboxesValueString = $("#filter_form").serialize();
    var pageNumString = "pageNum=" + pageNum;

    var allParamsString = pageNumString + "&" + checkboxesValueString;
    return allParamsString;
}





