//den_todo add time gif when uploading picture (some big picture)
var cropperHandlerIsActive = true;

String.prototype.hashCode = function () {
    if (Array.prototype.reduce) {
        return this.split("").reduce(function (a, b) {
            a = ((a << 5) - a) + b.charCodeAt(0);
            return a & a
        }, 0);
    }
    var hash = 0;
    if (this.length === 0) return hash;
    for (var i = 0; i < this.length; i++) {
        var character = this.charCodeAt(i);
        hash = ((hash << 5) - hash) + character;
        hash = hash & hash; // Convert to 32bit integer
    }
    return hash;
}

$(function () {
    $("#slider").slider({ max: 150,
        min: 150,
        step: 1,
        value: 150,
        slide: function (event, ui) {
            slideHandler();
        },
        stop: function (event, ui) {
            slideHandler();
        }
    });
});

function slideHandler() {
    setPreviewSize();
}

function setPreviewSize() {
    cropperHandlerIsActive = false;
    var data = $(".cropper_img").cropper("getData");
    var ratio = (data.height) / (data.width);

    var w = Math.round(350 / 100 * $("#slider").slider("value"));
    var h = Math.round(w * ratio);
    $('#cropper-preview').width(w);
    $('#cropper-preview').height(h);


    //refresh cropper to recalculate preview
    $(".cropper_img").cropper("setData", data);
    cropperHandlerIsActive = true;
}

function initCropper() {
    $image = $(".cropper_img");
    $image.cropper({
        data: {
            x: 480,
            y: 60,
            width: 640,
            height: 360
        },
        preview: ".cropper-preview",
        done: function (data) {
//            console.log(data);
        }
    });

    setCropperHandler();

}

function setCropperHandler() {
    var $image = $(".cropper_img");
    $image.on("render.cropper", function () {
        if (cropperHandlerIsActive) {
            cropperChangeHandler();
        }
    })
}

function unCropperHandler() {
    var $image = $(".cropper_img");
    $image.on("render.cropper", function () {
    })
}


function cropperChangeHandler() {
    setPreviewSize();
}

$(document).ready(function () {


    var $image = $(".cropper_img");
    var currentSrc;
    initCropper();
    var savehref = $('#gallery_save_pic');
    savehref.click(function () {
        saveCropHandler();
    });

    var cancelhref = $('#gallery_cancel_pic');
    cancelhref.click(function () {
        cancelCropHandler();
    });

    addControlsClickHandlers();
    addFieldsHandlers();
    addSubmitHandlers();
    setCurrentHashes();
    loadAndSetPaths();
    initPagination();

    $("#fileuploader").uploadFile({
        url: "./gallery_upload_pic.php",
        fileName: "myfile",
        onSuccess: function (files, json_data, xhr) {

            beforeUpload();
            var data = $.parseJSON(json_data);
            var img_w = data[1];
            var img_h = data[2];
            changeSrc(data[0]);
            img_tag_height = calc_img_size(img_w, img_h);
            afterUpload(img_tag_height);
            resizeDragAndDrop(img_tag_height);

        },
        uploadButtonClass: "green ajax-file-upload",
        showDone: false,
        showProgress: false,
        allowedTypes: "jpg,jpeg,png,gif"
    });

});

function initPagination() {
    var page_hrefs = $('.page_href');
    $.each(page_hrefs, function () {
        $(this).click(function () {

            pageClickHandler($(this));
        });
    });
};

function pageClickHandler(page) {
    var new_active_page = $(page).attr('value');
    reloadGallery(new_active_page);
    reloadPagination(new_active_page);
    document.location.href = "#top";
}

function loadAndSetPaths() {
    $cl_vid_path = getClValues();
    $cl_k_v = new Array();
    var cl_paths = new Array($cl_vid_path);
    $.each($cl_vid_path, function (cl, vid_path) {
        var paths = new Array();
        var id_paths = new Array();
        $.each(vid_path, function (vid, path) {
            var pathArray = splitPath(path);
            var trimmedPath = joinPath(pathArray, 1, pathArray.length);
            paths.push(trimmedPath);
            id_paths.push({k: vid, v: trimmedPath});
        });
        cl_paths[cl] = paths;
        $cl_k_v[cl] = sortSourceArray(id_paths);
    });
    $(".cl_text_edit").each(function () {
        $(this).autocomplete({
            delay: 0,
            minLength: 0,
            source: cl_paths[$(this).attr("db_id")],
            select: function (a, b) {
                $(this).val(b.item.value);
                checkPicHash($(this));
            }
        });

        $(this).on("focus", function (event, ui) {
            $(this).trigger(jQuery.Event("keydown"));
            // Since I know keydown opens the menu, might as well fire a keydown event to the element
        });
    })
}

function splitPath(path) {
    var res = new Array();
    if (path != 'undefined' && path != undefined) {
        $.each(path.split('/'), function (i, v) {
            if (v.trim() != '') {
                res.push(v);
            }
        })
    }
    return res;
}

function joinPath(arr) {
    return joinPath(arr, 0, arr.length)
}

function joinPath(arr, leftBorder, rightBorder) {
    var sliced_arr = arr.slice(leftBorder, rightBorder);
    return sliced_arr.join('/');
}

function getClValues() {
    var data;
    $.ajax({
        type: "POST",
        url: "classificator_get_paths.php",
        data: {},
        async: false
    })
        .done(function (json_data) {
            data = $.parseJSON(json_data);
        });
    return data;
}


function saveValuesRelations(hashHolderID, formID) {
    var newClValues = new Object();
    $(".cl_text_edit[hash_holder='" + hashHolderID + "']").each(function () {
        var cl_id = $(this).attr("db_id");
        var path = $(this).attr("value").trim();
        newClValues[cl_id] = 0;
        if (path != '') {
            var res;
            res = searchVlIDbyPath(cl_id, path);
            if (res.rest_path.trim() != '') {
                var newClValue = createNewClValue(cl_id, res.vid, res.rest_path);
                if (newClValue > 0) {
                    newClValues[cl_id] = newClValue;
                }
            } else {
                newClValues[cl_id] = res.vid;
            }
        } else {
            newClValues[cl_id] = 'to_remove';
        }
    });
    var js_values = JSON.stringify(newClValues);


    $('#classification_for_' + formID).remove();
    $('<input />').attr('type', 'hidden')
        .attr('id', 'classification_for_' + formID)
        .attr('name', 'classification')
        .attr('value', js_values)
        .appendTo('#' + formID);


}

function isInt(n) {
    return n % 1 === 0;
}

function createNewClValue(cl_id, v_id, new_branch) {
    var created_vid = 0;
    var send_data;
    if (isInt(v_id)) {
        send_data = {cl_id: cl_id, v_id: v_id, new_branch: new_branch};
    } else {
        send_data = {cl_id: cl_id, new_branch: new_branch};

    }
    $.ajax({
        type: "POST",
        url: "classificator_add_vl_branch.php",
        data: send_data,
        async: false,
        success: function (json_data) {
            // console.log(json_data);  //den_debug
            var data = $.parseJSON(json_data);

            if (data['return_code'] == 0) {
                created_vid = data['res'];
            } else {

            }
        }
    });

    return parseInt(created_vid);
}

function searchVlIDbyPath(cl_db_id, path) {
    var pathPoints = splitPath(path);
    var pathLength = pathPoints.length;

    var vid = undefined;
    if (pathLength > 0) {
        var valuesTree = $cl_k_v[cl_db_id];
        var level = 0;
        var point = pathPoints[level];
        var pointFound = true;
        while (level < pathLength && pointFound) {
            var res = searchPoint(point, valuesTree, level);
            valuesTree = res.tree;
            if (res.vid > 0) {
                vid = res.vid;
            }
            pointFound = (valuesTree.length > 0);
            level++;
            point = pathPoints[level];
        }
        var restPath = '';

        if (!pointFound && level <= pathLength) {
            restPath = joinPath(pathPoints, level - 1, pathLength);
        }
    }
    f_ret = {vid: vid, rest_path: restPath};
    return f_ret;
}

function searchPoint(in_point, in_valuesTree, level) {
    var valuesTree = filterByLevel(in_valuesTree, level);
    //console.log('valuesTree:');
    //console.log(valuesTree);
    var point = in_point.toUpperCase();
    //console.log('point:' + point);
    var vid = 0;
    var resultTree = new Array();

    if (valuesTree.length > 0) {
        var i = 0;
        var currentPathArray;
        var currentPathArrayLength;
        var currentTreePoint;

        function iteration(i) {
            currentPathArray = splitPath(valuesTree[i].v);
            currentPathArrayLength = currentPathArray.length;
            currentTreePoint = currentPathArray[level].toUpperCase();
            //console.log('currentPathArray:');
            //console.log(currentPathArray);
            //console.log('currentTreePoint:' + currentTreePoint);

        }

        for (iteration(i); i < valuesTree.length && point >= currentTreePoint; i++) {
            //console.log('inside');
            iteration(i);
            if (point === currentTreePoint) {
                resultTree.push(valuesTree[i]);
                if (currentPathArray.length == (level + 1)) {
                    vid = valuesTree[i].k;
                }
            }

        }
    }

    res = {tree: resultTree, vid: vid}
    //console.log('res:' + res);
    //console.log(res);
    return res;
}

function filterByLevel(valuesTree, level) {
    res = new Array();
    $.each(valuesTree, function (i, v) {
        if (splitPath(v.v).length >= (level + 1)) {
            res.push(v);
        }
    })
    return res;
}

function sortSourceArray(cl_k_v) {
    return cl_k_v.sort(function (a, b) {
        var a_v = a.v.toUpperCase();
        var b_v = b.v.toUpperCase();
        res = 0;
        if (a_v > b_v) {
            res = 1;
        }
        if (a_v < b_v) {
            res = -1;
        }
        return res;
    })
}

function beforeUpload() {

    $("#cropper-preview").addClass("cropper-preview");
    $("#cropper_div").hide();
    $("#cropper-preview").hide();
    $("#slider").hide();
}

function changeSrc(data) {
    var d = new Date();
    currentSrc = "./" + data
    var src = currentSrc + "?" + d.getTime();
    var $image = $(".cropper_img");
    $image.cropper("setImgSrc", src);
}

function afterUpload(img_tag_size) {
    $("#uploaded_left").height(img_tag_height);
    $("#cropper-preview").height(219);
    $("#save_cancel").show();
    $("#cropper-preview").show();
    $("#slider").show();
    $("#cropper_div").show();
    $("#upload_label").text("+ upload another");
}


function calc_img_size(img_w, img_h) {
    return  img_h * 600 / img_w;
}

function resizeDragAndDrop(img_tag_size) {
    if (img_tag_height > 315) {
        h = img_tag_height - 275;
    } else {
        h = 40;
    }

    $(".ajax-upload-dragdrop").css('height', parseInt(h));

}

function saveCropHandler() {
    var $image = $(".cropper_img");
    $.ajax({
        type: "POST",
        url: "gallery_save_pic.php",
        data: { pic_src: currentSrc, pic_data: JSON.stringify($image.cropper("getData")), w: $('#cropper-preview').width(), h: $('#cropper-preview').height()}
    })
        .done(function (msg) {
            //console.log(msg);      //den_debug
            hideUploadControls();
            var active_page = $('.page_href').filter('.active').attr('value');
            reloadGallery(active_page);
            reloadPagination(active_page);
            initCropper();
        });
}

function cancelCropHandler() {
    hideUploadControls();
    initCropper();
}

function hideUploadControls() {
    $image.cropper("setImgSrc", " ");
    $image.cropper("destroy");
    $("#uploaded_left").height(1);
    $("#cropper-preview").height(1);
    $("#save_cancel").hide();
    $("#slider").hide();
    $(".ajax-upload-dragdrop").height(40);
    $("#upload_label").text("+ upload");
}

function reloadGallery(active_page) {
    $.ajax({
        type: "POST",
        url: "gallery_edit_get_gallery.php",
        data: {active_page: active_page}
    })
        .done(function (msg) {
            $("#gallery").html(msg);
            addControlsClickHandlers();
            addFieldsHandlers();
            addSubmitHandlers();
            setCurrentHashes();
            loadAndSetPaths();
        });
}

function reloadPagination(active_page) {
    $.ajax({
        type: "POST",
        url: "gallery_edit_get_pagination.php",
        data: {active_page: active_page}
    })
        .done(function (msg) {
            $("#pagination").html('<hr>' + msg + '<br><hr>');
            initPagination();
        });
}

function removeHandler(src) {
    $.ajax({
        type: "POST",
        url: "gallery_del_pic.php",
        data: { file_name: src }
    })
        .done(function (msg) {
            reloadGallery($('.page_href').filter('.active').attr('value'));
        });
}


function saveHandler(formID, hashHolderID) {
    saveValuesRelations(hashHolderID, formID);
    $("#" + formID).submit();
    $(".save_pic[area='" + hashHolderID + "']").hide();
    loadAndSetPaths();
    refreshHashByID(hashHolderID);
}


function addControlsClickHandlers() {
    var $removeButtons = $(".remove_href");

    $removeButtons.each(function () {
        $(this).click(function () {
            removeHandler($(this).attr("file_name"))
        });

        $(this).hover(function () {
            $("#" + $(this).attr("area")).css("background-color", "#D16464");
        }, function () {
            $("#" + $(this).attr("area")).css("background-color", "#d2dfe3");
        });

    });

    var $saveButtons = $(".save_href");

    $saveButtons.each(function () {
        $(this).click(function () {
            saveHandler($(this).attr("form_id"), $(this).attr("area"))
        });

        $(this).hover(function () {
            $("#" + $(this).attr("area")).css("background-color", "#5d9f7a");
        }, function () {
            $("#" + $(this).attr("area")).css("background-color", "#d2dfe3");
        });

    });

}


function addFieldsHandlers() {
    var inputs = $(".field_editor_input");
    addFieldsChangeHandlers(inputs);
}

function addFieldsChangeHandlers(inputs) {
    $(inputs).each(function () {
        $(this).keyup(function () {
            checkPicHash($(this));
        });
    });
}

function checkPicHash(input) {
    var $hashHolderID = $(input).attr("hash_holder");
    var $oldHash = $("#" + $hashHolderID).attr("hash");
    var $newHash = calcFormHash($hashHolderID);
    if ($oldHash != $newHash) {
        $(".save_pic[area='" + $hashHolderID + "']").show();
    } else {
        $(".save_pic[area='" + $hashHolderID + "']").hide();
    }
}


function addSubmitHandlers() {
    var $forms = $(".field_editor_form");

    $forms.each(function () {
        $(this).submit(function (e) {
            e.preventDefault();
            //         console.log($(this).serialize());  //den_debug
            $.ajax({
                type: "POST",
                url: "gallery_update_pic.php",
                data: $(this).serialize(),
                success: function (data) {
                    //    console.log(data);  //den_debug
                }
            })
        });
    });
}

function setCurrentHashes() {
    var $areas = $(".one_element");
    $areas.each(function () {
        $hash = calcFormHash($(this).attr('id'));
        $(this).attr('hash', $hash);
    });
}


function refreshHashByID(ID) {
    refreshHash($('#' + ID));
}

function refreshHash(hash_holder) {
    var hash = calcFormHash($(hash_holder).attr('id'));
    $(hash_holder).attr('hash', hash);
}

function calcFormHash(hash_holder_id) {
    var $fields = $("[hash_holder='" + hash_holder_id + "']");
    var $content = '';
    $fields.each(function () {
        $content += $(this).attr("value") + $(this).prop("checked");
    });
    var $hash = new String($content).hashCode();
//        console.log($hash);   //den_debug
    return $hash;

}


