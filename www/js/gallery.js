var mouseoverLeftColumnWrap = false;
var nextPageNum = 1;
var getNextPInWork = 0;
var allPicturesLoaded = false;
var returnedPageData = '';
var detailsShow;
var rateShow;
var fullScreenPics = [];
var picIterator = 0;
var nextPictureInWork = 0;
var needShowPicAfterLoad = false;
var arrow_color = '#121212';
var bg_color = '#464646';



function setImagesMousehandler() {
    $('.picture').unbind('mouseover');
    $('.picture').bind('mouseover', smallImageMouseOverHandler);
}

function smallImageMouseOverHandler() {
    var all_td_space = $(this);
    var details = all_td_space.find('[class=details]');
    window.clearTimeout(detailsShow);
    if ((details.css('display') == 'none' || details.height() == 0) && details.find("p").html() != '' ) {
        pic_width = $(this).width();
        all_td_space_width = $(all_td_space).width();
        details.width(pic_width);
        details.css('height', '25%');
        details.slideDown(400);

    }
    detailsShow = window.setTimeout(function () {
        closeAllAnnotations(400);
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
        closeAllAnnotations(400);
    }, 3000);
}

function closeAllAnnotations(ms) {
$('[class=details]').each(function (index, element) {
    if ($(element).height() > 0) {
        $(element).fadeOut(ms);
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
    var action = "get_pic_count_by_filter";
    $.post("content_helper.php", "action=" + action + "&" + $("#filter_form").serialize(),
        function (data,x,jqXHR) {
            if (action != jqXHR.getResponseHeader('action')) {
                setPicturesCountByFilter();
                return;
            }
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
    mainInit();
    destructor = destructor;
    $(window).resize(function() {closeAllAnnotations(0); dragAndResize();});

});



function setSongsHandlers()  {
    var songs =  $(".song");
    $.each(songs, function(i,v) {
        $(v).bind("click",function() {
            var cur_is_active = $(this).hasClass("active");
            setCurrentPassive();
            if (cur_is_active) {
                window.my_jPlayer.jPlayer("pause");
            } else {
                window.currentTrack  = window.playList.map(function(e) {return e.mp3;}).indexOf($(this).attr("song_path"));
                setCounterText();
                changeToCurrent();
                setCurrentActive();
                window.my_jPlayer.jPlayer("play");
            }



        });
    });
}

function setRefsToSongs() {
    var song_controls = $(".song");
    $.each(window.playList, function(i,v) {
        var song = song_controls.filter(function() {
            return $(this).attr('song_path') == v.mp3;
        });
        v.songRef = song;
    });
}

function mainInit() {
    setWindowScrollHandler();
    turnOffReturner();
    refreshPictures();
    binds();
}

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
        var l = Math.round(l);
        var t = Math.round(t);
        $(v).css("position","absolute");
        $(v).css("left",l_percent*100 + "%");
        $(v).css("top",t);
    });


    var footer_h = 80;
    $(sk).height(sk_h + footer_h);
    $("#all_space_wrap").height(Math.round(sk_h + footer_h));


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
    //каждый bind - это новый вызов одной и той же функции
    $('#left_column_wrap,#arrow_pic').unbind("click");
    $('#left_column_wrap,#arrow_pic').bind("click", leftColumnWrapClickHandler)
    if (mouseoverLeftColumnWrap) {
        //$('#arrow_pic').css('background-image', "url('../images/returner/up77.svg')");

        $('#left_column_wrap').css('opacity', 0);
        $('#arrow_pic').css('background-color', arrow_color);
    } else {
        $('#arrow_pic').css('background-image', "url()");
        $('#left_column_wrap').css('opacity', 1);
        $('#arrow_pic').css('background-color', bg_color);
    }
    $('#left_column_wrap,#arrow_pic').hover(function () {

            showArrow();
        },
        function () {
            hideArrow();
        });

}

function showArrow() {
    $('#left_column_wrap').css('opacity', 0);
    $('#arrow_pic').css('background-color', arrow_color);
 //   $('#arrow_pic').css('background-image', "url('../images/returner/up77.svg')");

    mouseoverLeftColumnWrap = true;
}

function hideArrow() {
    $('#left_column_wrap').css('opacity', 1);
    $('#arrow_pic').css('background-color', bg_color);

    mouseoverLeftColumnWrap = false;
}

function turnOffReturner() {
    $('#left_column_wrap,#arrow_pic').unbind('click');
    $('#left_column_wrap').css('opacity', 1);
    $('#arrow_pic').css('background-color', bg_color);
    $('#arrow_pic').css('background-image', 'none');

    $('#left_column_wrap,#arrow_pic').hover(function () {
            $(this).css('opacity', 1);
            mouseoverLeftColumnWrap = true;
            $('#arrow_pic').css('background-color', bg_color);
        },
        function () {
            $(this).css('opacity', 1);
            mouseoverLeftColumnWrap = false;
            $('#arrow_pic').css('background-color', bg_color);
        });
}


function refreshPictures() {
    allPicturesLoaded = false;
    nextPageNum = 1;
    showFirstPage();

}


function closeFullScreenGalleryClickHandler() {
    hideFullScreenGallery();
    $('#loader').hide();
}

function hideFullScreenGallery() {
    $(document.documentElement).css('overflow', 'scroll');
    $('#fullScreenPic').hide();
    $('#fullScreenGallery').hide();
}

function changeFullScreenPic(sketch) {
    var p = {path:$(sketch).attr("picpath"),ratio:$(sketch).attr("ratio")};
    picIterator = fullScreenPics.map(function(e) {return e.path;}).indexOf(p.path);
    replaceCurPictureByNext(p.path);
}

function binds () {
    $('#fullScreenGalleryRightSide').bind('click', closeFullScreenGalleryClickHandler);
    $('#fullScreenGalleryLeftSide').bind('click', backFullScreenGalleryClickHandler);
    $('.fullScreenGalleryNaviButton').bind('mouseover', fullScreenGalleryNaviButtonMouseOverHandler);
    $('.fullScreenGalleryNaviButton').bind('mouseout', fullScreenGalleryNaviButtonMouseOutHandler);
    $('#fullScreenPicContainer').bind('click', fullScreenPicClickHandler);
    $('#fullScreenPicContainer').bind('load', fullScreenPicLoadHandler);

}

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
    var winRatio = $(window).height()*0.95/($(window).width()*0.80);
    var imgRatio = (getCur_pics().ratio);
    if (imgRatio > winRatio) {


        $("#fullScreenPicContainer").height($(window).height()*0.95);
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


function getCur_pics() {
    return fullScreenPics[picIterator];
}
function fetch_pics() {
    fwd_pics();
    return getCur_pics();
}
function fetch_prev_pics() {
    bkw_pics();
    return getCur_pics();
}
function fwd(a,i) {
    var new_pos;
    if(a.length-1 == i) {
        new_pos =  0 ;
    } else {
        i ++;
        new_pos =  i;
    }
    return  new_pos;

}

function bkw(a,iterator) {
    var res;
    if( 0== iterator) {
        var new_pos = a.length-1
        res =  new_pos;
    } else {
        iterator --;
        res = iterator;
    }

    return res;
}

function fwd_pics() {
    picIterator = fwd(fullScreenPics,picIterator);
}

function bkw_pics() {
    picIterator = bkw(fullScreenPics,picIterator);
}

//функция получает следующую картинку в полноэкранной галерее
function nextPicture() {
    if (nextPictureInWork == 0) {
        //флаг позволяет запускать функцию сключительно последовательно
        nextPictureInWork = 1;
        //отображаем указатель загрузки
        centerLoading();
        $('#loader').show();
        var nextPicPath = fetch_pics().path;
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
        centerLoading();
        $('#loader').show();
        var nextPicPath = fetch_prev_pics().path;
        replaceCurPictureByNext(nextPicPath);
        nextPictureInWork = 0;
    }
}

function replaceCurPictureByNext(picPath) {
    $("#big_image").attr("src",picPath);
    centerFullScreenPic();
    $('#resampled_image').hide();
    resize_image( $( '#big_image' )[0],$("#fullScreenPicContainer").width(),$("#fullScreenPicContainer").height(), $( '#resampled_image' )[0] );
}


function rewritePageByPageNum(pageNum) {
    var action = "get_pic_page";
    var allParamsString = makePictureGetterParametersStringForPageGet(pageNum,action);
    $.post("content_helper.php", allParamsString,
        //функция обработки полученных данных
        function (pic_data,x,jqXHR) {
            if (action != jqXHR.getResponseHeader('action')) {
                rewritePageByPageNum(pageNum);
                return;
            }
            $.ajax({
                type: "POST",
                shouldRetry: 3,
                url: 'content_helper.php',
                data: {action:"get_song_page"}
            }).done(function (song_data) {
                    var data =  pic_data + song_data;
                    if (trim(data) != '') {
                        $("#sketches").html(data);
                        $(".picture").each(function(i,e) {
                            fullScreenPics.push( {path:$(e).attr("picPath"),ratio:$(e).attr("ratio")});
                        });
                        dragAndResize();
                        setSongsHandlers();
                        setRefsToSongs();
                        setImagesMousehandler();
                        setImagesClickhandler();
                    } else {
                        $("#sketches").html("no data");
                    }
                })
        }
    )
    nextPageNum++;
}



function makePictureGetterParametersStringForPageGet(pageNum,action) {
    var checkboxesValueString = $("#filter_form").serialize();
    var pageNumString = "pageNum=" + pageNum;

    var allParamsString = pageNumString + "&" +  "action="+ action +  "&" +  checkboxesValueString;
    return allParamsString;
};


function setImagesClickhandler() {
    $('.picture').unbind('click');
    $('.picture').bind('click', smallImageClickHandler);
}


function smallImageClickHandler() {
    centerLoading();
    $('#loader').show();
    changeFullScreenPic(this);
    showFullScreenGallery();
}


function showFullScreenGallery() {

    $(document.documentElement).css('overflow', 'hidden');
    $('#fullScreenGallery').height($('#sketches').height() + $("#header").height() + $("#footer").height()+200);

    $('#fullScreenGallery').show();
    $('#fullScreenPicContainer').show();
    locateFullScreenGallaryControls();
    centerFullScreenPic();
}

function hideFullScreenGallery() {
    $(document.documentElement).css('overflow', 'scroll');
    $('#fullScreenPicContainer').hide();
    $('#fullScreenGallery').hide();
    $('#resampled_image').attr("src",'');
    $('#big_image').attr("src",'');
}

function resize_image( src, dst_w,dst_h,dst, type, quality ) {
    var tmp = new Image(),
        canvas, context, cW, cH;

    type = type || 'image/jpeg';
    quality = quality || 0.92;

    cW = src.naturalWidth;
    cH = src.naturalHeight;

    tmp.src = src.src;
    $(dst).load(function() {
        $('#resampled_image').show();
    });
    tmp.onload = function() {
        canvas = document.createElement( 'canvas' );
        cW /= 2;
        cH /= 2;

        if ( cW < dst_w ) cW = dst_w;
        if ( cH < dst_h ) cH = dst_h;

        canvas.width = cW;
        canvas.height = cH;
        context = canvas.getContext( '2d' );
        context.drawImage( tmp, 0, 0, cW, cH );

        dst.src = canvas.toDataURL( type, quality );

        if ( cW <= dst_w || cH <= dst_h ) {
            $(dst).load(function() {
                $('#loader').hide();
            });
            return;
        }
        tmp.src = dst.src;
    }

}

function destructor() {
    $(".mc_el").remove();
}







