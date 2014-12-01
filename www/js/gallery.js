<!--Скрпты отвечающие за догрузку нжней части страницы-->

var mouseoverLeftColumnWrap = false;
var thisPageNum = 10;
var nextPageNum = 1;
var curPic_num = 1;
var getNextPInWork = 0;
var nextPictureInWork = 0;
var previousPictureInWork = 0;
var picturesCount = 100;
var allPicturesLoaded = false;
var returnedPageData = '';
var foldClassificatorTimer;
var classificatorClearingProcess = false;
var needShowPicAfterLoad = 0;
var picturesCountByFilter = 0;
var detailsShow;
var rateShow;

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

function appendPageByPageNum(pageNum) {

    var allParamsString = makePictureGetterParametersStringForPageGet(pageNum);
    nextPageNum++;
    $.post("getPicturePage.php", allParamsString,
        //функция обработки полученных данных
        function (data) {
            if (trim(data) != '') {
                hideFooter();
                var rows = $(data);
                $("#sketches_table_body").append(rows);
                setImagesClickhandler();
                setImagesMousehandler();
                setDetailsAndRateClickhandler();
                setLeftColumnWrapHeightBiggerThanMain();
                checkEndOfPage();
                setAllDetailsPlace();
            }
        }
    );
}

function rewritePageByPageNum(pageNum) {
    var allParamsString = makePictureGetterParametersStringForPageGet(pageNum);
    $.post("getPicturePage.php", allParamsString,
        //функция обработки полученных данных
        function (data) {
            if (trim(data) != '') {
                hideFooter();
                $("#sketches_table_body").html(data);
                setImagesClickhandler();
                setDetailsAndRateClickhandler();
                setImagesMousehandler();
                setLeftColumnWrapHeightBiggerThanMain();
                checkEndOfPage();
            } else {
                $("#sketches_table_body").html("<tr><td colspan=3 padding=25px>&nbsp &nbsp &nbsp &nbsp &nbsp{{{$no_results}}}</td></tr>");
                showFooter();
            }
        }
    )
    nextPageNum++;
}

function checkEndOfPage() {
    var allParamsString = makePictureGetterParametersStringForPageGet(nextPageNum);
    $.post("getPicturePage.php", allParamsString,
        function (data) {
            if (trim(data) == '') {
                allPicturesLoaded = true;
                showFooter();
                setLeftColumnWrapHeightEquilToMain();
            }
        }
    );
}


function setImagesClickhandler() {
    $('img[class1=small_image]').unbind('click');
    $('img[class1=small_image]').bind('click', smallImageClickHandler);
}

function setDetailsAndRateClickhandler() {
    $('div[class=details],div[class=rate]').unbind('click').bind('click', detailsAndRateClickHandler);
}

function detailsAndRateClickHandler() {
    $(this).parent().find('img[class1=small_image]').click();
}


function setImagesMousehandler() {
    $('img[class1=small_image]').unbind('mouseover');
    $('img[class1=small_image]').bind('mouseover', smallImageMouseOverHandler);
}

function smallImageMouseOverHandler() {
    var all_td_space = $(this).parent();
    var details = all_td_space.find('[class=details]');
    window.clearTimeout(detailsShow);
    if (details.css('display') == 'none' || details.height() == 0) {
        pic_width = $(this).width();
        all_td_space_width = $(all_td_space).width();
        details.width(pic_width);
        details.css('left', (all_td_space_width - pic_width) / 2 + 'px');
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
        rate.css('left', (all_td_space_width - pic_width) / 2 + 'px');
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


    $('[class=rate]').each(function (index, element) {
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


function makePictureGetterParametersStringForPageGet(pageNum) {
    var checkboxesValueString = $("#filter_form").serialize();
    var pageNumString = "pageNum=" + pageNum;

    var allParamsString = pageNumString + "&" + checkboxesValueString;
    return allParamsString;
}

function makePictureGetterParametersStringForPictureGet(pageNum) {
    var checkboxesValueString = $("#filter_form").serialize();
    var picNumString = "picNum=" + pageNum;
    var allParamsString = picNumString + "&" + checkboxesValueString;
    return allParamsString;
}


function onScrollfunct() {

    var leftH = $("#main_content").height() - $(window).height() - $(this).scrollTop();

    if (leftH < 300 & !allPicturesLoaded) {
        getNextP();
        setImagesClickhandler();
        setDetailsAndRateClickhandler();
        setImagesMousehandler();
    } else {
        setLeftColumnWrapHeightEquilToMain();
    }

    // показать / не показать стрелку возврата
    if ($(this).scrollTop() > 100) {
        turnOnReturner();
    } else {
        turnOffReturner();
    }
}


function setWindowScrollHandler() {
    $(window).bind('scroll', onScrollfunct);
}

function unsetWindowScrollHandler() {
    $(window).unbind('scroll');
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
    //showFilterContentInPanel();
});


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


function setLeftColumnWrapHeightBiggerThanMain() {
    if ((typeof $('#page_wrap').css("height")) != "undefined") {
        pageWrapHeight = $("#page_wrap").css('height');
        pageWrapHeight.replace(/[^-\d\.]/g, '');
        $("#left_column_wrap").css('height', parseInt(pageWrapHeight) + 10000);

    }
}


function setLeftColumnWrapHeightEquilToMain() {
    if ((typeof $('#page_wrap').css("height")) != "undefined") {
        pageWrapHeight = $("#page_wrap").css('height');
        pageWrapHeight.replace(/[^-\d\.]/g, '');
        $("#left_column_wrap").css('height', parseInt(pageWrapHeight));
    }
}

//функция отображает футер в самом низу страницы
function showFooter() {
    //устанавливаем положение footer

    if ((typeof ($('#header').css("height")) != "undefined") && (typeof ($('#main_content').css("height")) != "undefined")) {
        $("#footer").css('display', 'block');
    }
}

function hideFooter() {
    //устанавливаем положение footer

    if ((typeof ($('#header').css("height")) != "undefined") && (typeof ($('#main_content').css("height")) != "undefined")) {
        $("#footer").css('display', 'none');
    }
}
<!--Конец скрптов отвечающих за догрузку нжней части страницы-->

<!--Cкрпты отвечающие за чекбоксы на странице и их враперы-->
$(function () {
    $("input:checkbox").live("change", checkboxClickHandler);
    $('div[class=classificator_header]').bind('click', classificatorHeaderClickHandler);
    $('div[class=clear_btn]').bind('click', clearBtnClickHandler);
    $('div[id=classificators]').bind('mouseleave', classificatorsMOutHandler);
    $('div[id=classificators]').bind('mouseover', classificatorsMOverHandler);
    $('div[class=checkbox_wrapper]').hover(classificatorValueMouseIn, classificatorValueMouseOut);
    $('div[class=checkbox_wrapper]').bind('click', classificatorWrapperClickHandler);

});

function closeFullScreenGalleryClickHandler() {
    hideFullScreenGallery();
    $("#fullScreenPicContanier").html('');
}

function smallImageClickHandler() {

    changeFullScreenPic(this);
    showFullScreenGallery();
}


function showFullScreenGallery() {

    $(document.documentElement).css('overflow', 'hidden');
    /*$('div[class=fullScreenGallery]').css('top',$('body').scrollTop());*/
    $('div[class=fullScreenGallery]').css('height', $('#all_space_wrap').css('height'));

    $('div[class=fullScreenGallery]').show();
    $('#fullScreenPic').show();
    locateFullScreenGallaryControls();
    centerFullScreenPic();
}

function hideFullScreenGallery() {
    $(document.documentElement).css('overflow', 'scroll');
    $('#fullScreenPic').hide();
    $('div[class=fullScreenGallery]').hide();
}

function changeFullScreenPic(sourceSmallPic) {
    curPic_num = parseInt(sourceSmallPic.getAttribute('sequence_number'));
    replaceCurPictureByNext(curPic_num);
}
function classificatorWrapperClickHandler() {
    $(':checkbox', this).each(function () {
        this.checked = !this.checked;
    });
    $(':checkbox', this).change();
}

function clearBtnClickHandler() {
    classificatorClearingProcess = true;
    $('div[class=classificator_body][classificator_id=' + ($(this).parent().attr('classificator_id')) + ']')
        .find(':checkbox')
        .each(function (index, element) {
            element.checked = false;
            setFakeCheckboxStyleTurnedOff(element);
        });
    turnOffClassificatorHeader($(this).parent().get(0));
    refreshPictures();
}

function getHypotetheticallyAffectedCheckboxes(clickedCheckbox) {
    var checkboxes = [clickedCheckbox];
    var childrens = getChildrens(clickedCheckbox);
    var parents = getParents(clickedCheckbox);
    checkboxes = checkboxes.concat(childrens);
    checkboxes = checkboxes.concat(parents);
    return checkboxes;
}

function getChildrens(checkbox) {
    var checkboxes = [];
    var name = checkbox.getAttribute("name");
    $('input[parent="' + name + '"]').each(function (index, element) {
        checkboxes.push(element);
        var childrens = getChildrens(element);
        checkboxes = checkboxes.concat(childrens);
    })
    return checkboxes;
}

function getParents(checkbox) {
    var checkboxes = [];
    var parentName = checkbox.getAttribute("parent");
    var parent = $('input[name="' + parentName + '"]').get(0);
    if (parent != null) {
        checkboxes.push(parent);
        var parents = getParents(parent);
        checkboxes = checkboxes.concat(parents);
    }
    return checkboxes;
}


function classificatorValueMouseIn() {
    $('div[class=fake_checkbox]', this).addClass('fake_checkbox_hover').removeClass('fake_checkbox');
}

function classificatorValueMouseOut() {
    $('div[class=fake_checkbox_hover]', this).addClass('fake_checkbox').removeClass('fake_checkbox_hover');
}

function classificatorsMOutHandler() {
    foldClassificatorTimer = setTimeout(function () {
        hideClassificatorsContent();
    }, 3000);
}
function classificatorsMOverHandler() {
    clearTimeout(foldClassificatorTimer);
}

function checkboxClickHandler(mes) {
    checkboxesSetProcess(this);
}

function checkboxesSetProcess(checkbox) {
    checkbox.setAttribute('display_style', 'black')
    setChildrensState(checkbox.getAttribute("name"));
    setParentState(checkbox.getAttribute("parent"));
    refreshPictures();
    hypotetheticallyAffectedCheckboxes = getHypotetheticallyAffectedCheckboxes(checkbox);
    setFakeCheckboxesStyle(hypotetheticallyAffectedCheckboxes);
    setClassificatorHeaderStyle($('div[class=classificator_header][classificator_id=' + checkbox.getAttribute("classificator_id") + ']').get(0));
}

function DEPRICATED_setAllFakeCheckboxesStyle() {
    $(':checkbox').each(function (index, element) {
        var currentTime = +new Date();
//				console.info('setAllFakeCheckboxesStyle ' + currentTime);
        setFakeCheckboxStyle(element)
    });
}

function setFakeCheckboxesStyle(checkboxes) {
    $(checkboxes).each(function (index, element) {
        var currentTime = +new Date();
//				console.info('setAllFakeCheckboxesStyle ' + currentTime);
        setFakeCheckboxStyle(element)
    });
}

function setAllClassificatorsStyle() {
    $('div[class=classificator_header]').each(function (index, element) {
        var currentTime = +new Date();
//						    console.info('setAllClassificatorsStyle ' + currentTime);						    
        setClassificatorHeaderStyle(element)
    });
}

function setClassificatorHeaderStyle(header) {
    //alert($('div[class=classificator_body][classificator_id=' + header.getAttribute('classificator_id') + ']').attr('class'))
    allCheckboxesUnchecked = true;
    $('div[class=classificator_body][classificator_id=' + header.getAttribute('classificator_id') + ']')
        .find('[type=checkbox]')
        .each(function (index, element) {
            if (element.checked) {
                allCheckboxesUnchecked = false
            }
        });
    if (allCheckboxesUnchecked == true) {
        turnOffClassificatorHeader(header);
    } else {
        turnOnClassificatorHeader(header);
    }
}

function turnOnClassificatorHeader(header) {
    $(header).css('color', '#fff');
    $(header).find('div[class=clear_btn]').show();
}

function turnOffClassificatorHeader(header) {
    $(header).css('color', '#ccc');
    $(header).find('div[class=clear_btn]').hide();
}

function setFakeCheckboxStyle(checkbox) {
    $('[checkbox_id=' + checkbox.getAttribute("id") + ']').find('img').hide();
    if (checkbox.checked) {
        if (checkbox.getAttribute("display_style") == "black") {
            $('[checkbox_id=' + checkbox.getAttribute("id") + ']').find('img').attr('src', 'images/panel/checkmark_black.png');
        }
        if (checkbox.getAttribute("display_style") == "gray") {
            $('[checkbox_id=' + checkbox.getAttribute("id") + ']').find('img').attr('src', 'images/panel/checkmark_gray.png');
        }
        $('[checkbox_id=' + checkbox.getAttribute("id") + ']').find('img').show();
        $('[checkbox_id=' + checkbox.getAttribute("id") + ']').parent().find('div[class=classificator_value_text]').css('color', '#fff');
    } else {
        setFakeCheckboxStyleTurnedOff(checkbox);
    }

}

function setFakeCheckboxStyleTurnedOff(checkbox) {
    $('[checkbox_id=' + checkbox.getAttribute("id") + ']').find('img').hide();
    $('[checkbox_id=' + checkbox.getAttribute("id") + ']').parent().find('div[class=classificator_value_text]').css('color', '#ccc');
}


function refreshPictures() {
    allPicturesLoaded = false;
    nextPageNum = 1;
    showFirstPage();

}

//sets checkbox state in relation of childrens
function setParentState(parentName) {
    $('input[name="' + parentName + '"]').unbind("change");
    allChildrenIsChecked = true;
    allChildrenIsUnchecked = true;
    allChildrenIsBlack = true;
    allChildrenIsGray = true;
    $('input[parent="' + parentName + '"]').each(function (index, element) {
        if (element.checked) {
            allChildrenIsUnchecked = false;
            if (element.getAttribute('display_style') == 'gray') {
                allChildrenIsBlack = false;
            } else {
                allChildrenIsGray = false;
            }
        } else {
            allChildrenIsChecked = false;
        }

    });

    if (allChildrenIsChecked) {
        $('input[name="' + parentName + '"]').attr("checked", "checked");
        if (allChildrenIsBlack) {
            $('input[name="' + parentName + '"]').attr("display_style", "black");
        } else {
            $('input[name="' + parentName + '"]').attr("display_style", "gray");
        }

    } else if (allChildrenIsUnchecked) {
        $('input[name="' + parentName + '"]').attr("checked", false);
        $('input[name="' + parentName + '"]').attr("display_style", "none");
    } else {
        $('input[name="' + parentName + '"]').attr("checked", true);
        $('input[name="' + parentName + '"]').attr("display_style", "gray");
    }
    if (($('input[name="' + parentName + '"]').attr("parent") != '') & (typeof $('input[name="' + parentName + '"]').attr("parent") != "undefined")) {
        setParentState($('input[name="' + parentName + '"]').attr("parent"));
    }
    $('input[name="' + parentName + '"]').bind("change", checkboxClickHandler);

}

//sets childrens checkboxes states in relation of parent
function setChildrensState(parentName) {
    $('input[name="' + parentName + '"]').unbind("change");
    $('input[parent="' + parentName + '"]').each(function (index, element) {

        if ($('input[name="' + parentName + '"]').attr("checked")) {
            element.checked = true;
            element.setAttribute('display_style', 'black');
        } else {
            element.checked = false;
            element.setAttribute('display_style', 'none');
        }
        setChildrensState(element.name);
    });
    $('input[name="' + parentName + '"]').bind("change", checkboxClickHandler);
}

function classificatorHeaderClickHandler() {
    if (!classificatorClearingProcess) {
        showClassificatorContent(this.getAttribute("classificator_id"));
    } else {
        classificatorClearingProcess = false;
    }
}

function showClassificatorContent(classificatorID) {
    $('div[classificator_id=' + classificatorID + '][class=classificator_body]').slideToggle('fast');
}

function hideClassificatorsContent(classificatorID) {
    $('div[class=classificator_body]').slideUp('fast');
}
<!--Конец скрптов отвечающих за чекбоксы на странице и их враперы-->


<!--Скрипт для выезжающей панели-->
$(function () {
    $('.panel').tabSlideOut({							//Класс панели
        tabHandle: '.panelButton',						//Класс кнопки
        pathToTabImage: 'images/panel/lupa.png',				//Путь к изображению кнопки
        pathToTabImageClose: 'images/panel/lupa_close1.png',			//Путь к изображению кнопки закрывающей панель
        imageHeight: '94px',						//Высота кнопки
        imageWidth: '46px',						//Ширина кнопки
        tabLocation: 'right',						//Расположение панели top - выдвигается сверху, right - выдвигается справа, bottom - выдвигается снизу, left - выдвигается слева
        speed: 100,								//Скорость анимации
        action: 'click',								//Метод показа click - выдвигается по клику на кнопку, hover - выдвигается при наведении курсора
        topPos: '5px',							//Отступ сверху
        fixedPosition: true						//Позиционирование блока false - position: absolute, true - position: fixed
    });
});
<!--Скрипты полноэкранной галереи-->
$(function () {
    $('#fullScreenGalleryRightSide').bind('click', closeFullScreenGalleryClickHandler);
    $('#fullScreenGalleryLeftSide').bind('click', backFullScreenGalleryClickHandler);
    $('.fullScreenGalleryNaviButton').bind('mouseover', fullScreenGalleryNaviButtonMouseOverHandler);
    $('.fullScreenGalleryNaviButton').bind('mouseout', fullScreenGalleryNaviButtonMouseOutHandler);
    $('#fullScreenPic').bind('click', fullScreenPicClickHandler);
    $('#fullScreenPic').bind('load', fullScreenPicLoadHandler);
    locateFullScreenGallaryControls();
    centerFullScreenPic();
})


$(document).keydown(function (e) {
    switch (e.which) {
        case 37: // left
            $('#fullScreenGalleryLeftSide').click();
            break;

        case 38: // up
            break;

        case 39: // right
            $('#fullScreenPic').click();
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
        $('#fullScreenPic').show();
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
    /*$('#fullScreenPic').css({
     position:'absolute',
     left: ($(window).width() - $('#fullScreenPic').outerWidth())/2,
     top: $(window).scrollTop() + ($(window).height() - $('#fullScreenPic').outerHeight())/2
     });*/
    $('#fullScreenPicContanier').css({
        position: 'absolute',
        left: ($(window).width() - $('#fullScreenPic').outerWidth()) / 2,
        top: $(window).scrollTop() + ($(window).height() - $('#fullScreenPic').outerHeight()) / 2,
        height: $('#fullScreenPic').height(),
        width: $('#fullScreenPic').width(),
        display: 'block'
    });
}

function fullScreenPicClickHandler() {
    nextPicture();
}
function backFullScreenGalleryClickHandler() {
    previousPicture();
}


//функция получает следующую картинку в полноэкранной галерее
function nextPicture() {
    if (nextPictureInWork == 0) {
        //флаг позволяет запускать функцию сключительно последовательно
        nextPictureInWork = 1;
        //отображаем указатель загрузки
        $("#upBlock").css('display', 'block');
        if (curPic_num < picturesCountByFilter) {
            nextPicNum = curPic_num + 1;
        } else {
            nextPicNum = 1;
        }
        replaceCurPictureByNext(nextPicNum);
        nextPictureInWork = 0;
    }
}

//функция получает предыдущую картинку в полноэкранной галерее
function previousPicture() {
    if (previousPictureInWork == 0) {
        //флаг позволяет запускать функцию сключительно последовательно
        previousPictureInWork = 1;
        if (curPic_num > 1) {
            nextPicNum = curPic_num - 1;
        } else {
            nextPicNum = picturesCountByFilter;
        }
        replaceCurPictureByNext(nextPicNum);
        previousPictureInWork = 0;
    }
}

function replaceCurPictureByNext(picNum) {
    var allParamsString = makePictureGetterParametersStringForPictureGet(picNum);
//alert(allParamsString);
    $.post("getPicture.php", allParamsString,
        //функция обработки полученных данных
        function (data) {
            if (trim(data) != '') {
                $('#fullScreenPic').hide();
                $("#fullScreenPicContanier").html(data);
                $('#fullScreenPic').bind('click', fullScreenPicClickHandler);
                needShowPicAfterLoad = 1;
                $('#fullScreenPic').bind('load', fullScreenPicLoadHandler);
                curPic_num = picNum;
            }
        }
    );
}
