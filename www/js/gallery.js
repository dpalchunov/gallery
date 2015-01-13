<!--Скрпты отвечающие за догрузку нжней части страницы-->

var mouseoverLeftColumnWrap = false;
var nextPageNum = 1;
var getNextPInWork = 0;
var allPicturesLoaded = false;
var returnedPageData = '';
var detailsShow;
var rateShow;
var img_state_idle = 1,
    img_state_dragging = 2,
    img_state_persist_delay = 3
var fullScreenPics = [];
var picIterator = 0;
var nextPictureInWork = 0;
var needShowPicAfterLoad = false;



function setImagesMousehandler() {
    $('.sketch').unbind('mouseover');
    $('.sketch').bind('mouseover', smallImageMouseOverHandler);
}

function smallImageMouseOverHandler() {
    var all_td_space = $(this);
    var details = all_td_space.find('[class=details]');
    window.clearTimeout(detailsShow);
    if (details.css('display') == 'none' || details.height() == 0) {
        pic_width = $(this).width();
        all_td_space_width = $(all_td_space).width();
        details.width(pic_width);
        details.css('height', '25%');
        details.slideDown(400);

    }
    detailsShow = window.setTimeout(function () {
        closeAllAnnotations();
    }, 3000);


    var rate = all_td_space.find('[class=rate]');
    window.clearTimeout(rateShow);
    if (rate.css('display') == 'none' || rate.height() == 0) {
        pic_width = $(this).width();
        all_td_space_width = $(all_td_space).width();
        rate.width(pic_width);
        rate.css('height', '17px');
        rate.slideDown(400);

    }
    rateShow = window.setTimeout(function () {
        closeAllAnnotations();
    }, 3000);
}

    function closeAllAnnotations() {
    $('[class=details]').each(function (index, element) {
        if ($(element).height() > 0) {
            $(element).fadeOut(400);
        }
    });
    }

    function setAllDetailsPlace() {
        var details = $('*').filter(function (index) {
            var itIsDetails = $(this).hasClass('details');
            var heightBiggerZero = ($(this).height() > 0);
            return (itIsDetails && heightBiggerZero);
        })
        setDetailsPlace(details);
    }

    function setDetailsPlace(details_array) {
        details_array.each(function (index, element) {
            var all_td_space = $(element).parent();
            var pic_width = all_td_space.find('img[class1=small_image]').width();
            var all_td_space_width = all_td_space.width();
            $(element).width(pic_width - 50);
            $(element).css('left', (all_td_space_width - pic_width + 50) / 2 + 'px');
        });
    }

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
        if (h+t > sk_h) {
            sk_h = h+t
        }
        $(v).height(h);
        $(v).position({
                my: "left top",
                at: "left+" + l_percent*100 + "% top+" + t,
                of: "#sketches",
                collision: "none"
            });
    });
    var footer_h = 80;
    $(sk).height(sk_h + footer_h);
    $("#all_space_wrap").height(Math.round(sk_h + footer_h));
  //  console.log(sk_h + footer_h);

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


function closeFullScreenGalleryClickHandler() {
    hideFullScreenGallery();
}

function hideFullScreenGallery() {
    $(document.documentElement).css('overflow', 'scroll');
    $('#fullScreenPic').hide();
    $('div[class=fullScreenGallery]').hide();
}

function changeFullScreenPic(sketch) {
    var p = {path:$(sketch).attr("picpath"),ratio:$(sketch).attr("ratio")};
    replaceCurPictureByNext(p.path);
    picIterator = fullScreenPics.map(function(e) {return e.path;}).indexOf(p.path);
    getNextPicInfo();
}

<!--Скрипты полноэкранной галереи-->
$(function () {
    $('#fullScreenGalleryRightSide').bind('click', closeFullScreenGalleryClickHandler);
    $('#fullScreenGalleryLeftSide').bind('click', backFullScreenGalleryClickHandler);
    $('.fullScreenGalleryNaviButton').bind('mouseover', fullScreenGalleryNaviButtonMouseOverHandler);
    $('.fullScreenGalleryNaviButton').bind('mouseout', fullScreenGalleryNaviButtonMouseOutHandler);
    $('#fullScreenPicContainer').bind('click', fullScreenPicClickHandler);
    $('#fullScreenPicContainer').bind('load', fullScreenPicLoadHandler);
    locateFullScreenGallaryControls();
  //  centerFullScreenPic();
})


$(document).keydown(function (e) {
    switch (e.which) {
        case 37: // left
            $('#fullScreenGalleryLeftSide').click();
            break;

        case 38: // up
            break;

        case 39: // right
            $('#fullScreenPicContainer').click();
            break;

        case 40: // down
            break;

        case 27: // esc
            $('#fullScreenGalleryRightSide').click();
            break;

        default:
            return; // exit this handler for other keys
    }
    e.preventDefault();
});


function fullScreenPicLoadHandler() {
    locateFullScreenGallaryControls();
    centerFullScreenPic();
    showfullScreenPicIfNeeded();

}

function showfullScreenPicIfNeeded() {
    if (needShowPicAfterLoad == 1) {
        $('#fullScreenPicContainer').show();
        needShowPicAfterLoad = 0;
    }
}
function fullScreenGalleryNaviButtonMouseOverHandler() {
    $(this).stop().animate({opacity: '1.0'}, 300);
    $(this).css('cursor', 'pointer');
}

function fullScreenGalleryNaviButtonMouseOutHandler() {
    $(this).stop().animate({opacity: '0.2'}, 200);
}

$(window).resize(function () {
    locateFullScreenGallaryControls();
    centerFullScreenPic();
});

function locateFullScreenGallaryControls() {
    var scrollTopString = $(window).scrollTop() + 'px';
    $('#fullScreenGalleryRightSide').css(
        'background-position', '100% ' + scrollTopString
    );
    $('#fullScreenGalleryLeftSide').css(
        'background-position', '0% ' + scrollTopString
    );
}

function centerFullScreenPic() {
    var winRatio = $(window).height()/($(window).width()*0.80);
    var imgRatio = (getCurPicInfo().ratio);
    if (imgRatio > winRatio) {
        $("#fullScreenPicContainer").height($(window).height());
        $("#fullScreenPicContainer").width($("#fullScreenPicContainer").height()/imgRatio);
    } else {
        $("#fullScreenPicContainer").width($(window).width()*0.80);
        $("#fullScreenPicContainer").height($("#fullScreenPicContainer").width()*imgRatio);
    }


    $('#fullScreenPicContainer').css({
        position: 'absolute',
        left: ($(window).width() - $('#fullScreenPicContainer').outerWidth()) / 2,
        top: $(window).scrollTop() + ($(window).height() - $('#fullScreenPicContainer').outerHeight()) / 2,
        display: 'block'
    });
}

function fullScreenPicClickHandler() {
    nextPicture();
}
function backFullScreenGalleryClickHandler() {
    previousPicture();
}

function getCurPicInfo() {
    return getCur(fullScreenPics,picIterator);
}

function getNextPicInfo() {
    var res = getNext(fullScreenPics,picIterator);
    var nextP = res.res;
    picIterator = res.i;
    return nextP;
}
function getPrePicInfo() {
    var res = getPre(fullScreenPics,picIterator);
    var nextP = res.res;
    picIterator = res.i;
    return nextP;
}

function getCur(a,i) {
    return a[i];
}
function getNext(a,i) {
    var next = getCur(a,i);
    var new_pos = fwd(a,i);
    return {res:next,i:new_pos};
}
function getPre(a,i) {
    var new_pos = bkw(a,i);
    var next = getCur(a,new_pos);
    return {res:next,i:new_pos};
}
function fwd(a,i) {
    if(a.length-1 == i) {
        return 0 ;
    } else {
        i ++;
        return i;
    }

}

function bkw(a,iterator) {
    if( 0== iterator) {
        var new_pos = a.length-1
        return new_pos;
    } else {
        iterator --;
        return iterator;
    }
}
//функция получает следующую картинку в полноэкранной галерее
function nextPicture() {
    if (nextPictureInWork == 0) {
        //флаг позволяет запускать функцию сключительно последовательно
        nextPictureInWork = 1;
        //отображаем указатель загрузки
        $("#upBlock").css('display', 'block');
        var nextPicPath = getNextPicInfo().path;
        replaceCurPictureByNext(nextPicPath);
        nextPictureInWork = 0;

    }
}

//функция получает предыдущую картинку в полноэкранной галерее
function previousPicture() {
    if (nextPictureInWork == 0) {
        //флаг позволяет запускать функцию сключительно последовательно
        nextPictureInWork = 1;
        //отображаем указатель загрузки
        $("#upBlock").css('display', 'block');
        var nextPicPath = getPrePicInfo().path;
        replaceCurPictureByNext(nextPicPath);
        nextPictureInWork = 0;
    }
}

function replaceCurPictureByNext(picPath) {
    $("#fullScreenPicContainer").css("background-image","url(" + picPath + ")");
}


function rewritePageByPageNum(pageNum) {
    var allParamsString = makePictureGetterParametersStringForPageGet(pageNum);
    $.post("getPicturePage.php", allParamsString,
        //функция обработки полученных данных
        function (data) {
            if (trim(data) != '') {
                $("#sketches").html(data);
                $(".sketch").each(function(i,e) {
                    fullScreenPics.push( {path:$(e).attr("picPath"),ratio:$(e).attr("ratio")});
                });
                 console.log(getCurPicInfo());
                dragAndResize();
                setImagesMousehandler();
                setImagesClickhandler();

            } else {
                $("#sketches").html("no data");
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
};


function setImagesClickhandler() {
    $('.sketch').unbind('click');
    $('.sketch').bind('click', smallImageClickHandler);
}


function smallImageClickHandler() {

    changeFullScreenPic(this);
    showFullScreenGallery();
}


function showFullScreenGallery() {

    $(document.documentElement).css('overflow', 'hidden');
    $('div[class=fullScreenGallery]').height($('#sketches').height() + $("#header").height() + $("#footer").height()+80);

    $('div[class=fullScreenGallery]').show();
    $('#fullScreenPicContainer').show();
    locateFullScreenGallaryControls();
    centerFullScreenPic();
}

function hideFullScreenGallery() {
    $(document.documentElement).css('overflow', 'scroll');
    $('#fullScreenPicContainer').hide();
    $('div[class=fullScreenGallery]').hide();
}






