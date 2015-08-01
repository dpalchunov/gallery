var nextPageNum = 1;
var getNextPInWork = 0;
var allPicturesLoaded = false;
var returnedPageData = '';
var detailsShow;
var fullScreenPics = [];
var picIterator = 0;
var nextPictureInWork = 0;
var needShowPicAfterLoad = false;



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


$(document).ready(function () {
    mainInit();

    destructor = destructor;
});

function mainInit() {
    refreshPictures();
    binds();
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
    var bi = $( '#big_image' )[0];
    console.log("getting ratio ");
    var ratio = bi.naturalHeight/bi.naturalWidth;
    console.log("got ratio " + ratio);
    var imgRatio = (ratio);
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
    $("#big_image").unbind("load")
    $("#big_image").load(function() {
        console.log("loaded " + picPath);
        centerFullScreenPic();
        $('#resampled_image').hide();
        resize_image( $( '#big_image' )[0],$("#fullScreenPicContainer").width(),$("#fullScreenPicContainer").height(), $( '#resampled_image' )[0] );
    });
    $("#big_image").attr("src",picPath);
    console.log("src changed to " + picPath);

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
    hideDetails($(this));
    centerLoading();
    $('#loader').show();
    changeFullScreenPic(this);
    showFullScreenGallery();
}


function showFullScreenGallery() {

    $(document.documentElement).css('overflow', 'hidden');
    $('#fullScreenGallery').height($('#main_content').height() + $("#header").height() + $("#footer").height()+200);

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


function setImagesMousehandler() {
    var p = $('.picture');
    var details = p.find('[class=details]');
    p.unbind('mouseenter');
    p.bind('mouseenter', smallImageMouseOverHandler);

    p.unbind('mouseleave');
    p.bind('mouseleave', mleave);

}

function smallImageMouseOverHandler(event) {
    if (event.target.className == "grid_list_cell picture") {
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







