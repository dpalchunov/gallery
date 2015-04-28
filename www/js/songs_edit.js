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


$(document).ready(function () {
    destructor =  destructor;

    addControlsClickHandlers();
    addFieldsHandlers();
    addSubmitHandlers();
    setCurrentHashes();
    initPagination();

    $("#fileuploader").uploadFile({
        url: "./songs_edit.php",
        method: "POST",
        formData: { action: "edit_upload_song"},
        fileName: "myfile",
        onSuccess: function (files, json_data, xhr) {
            loadLastPage();

        },
        uploadButtonClass: "green ajax-file-upload",
        showDone: false,
        showProgress: false,
        allowedTypes: "mp3,mp4"
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
    centerLoading();
    $('#loader').show();
    var new_active_page = $(page).attr('value');
    reloadSongs(new_active_page,function() {
        reloadPagination(new_active_page,function() {
            $(window).scrollTop($(document).height());
            $('#loader').hide();
        })
    });
}


function isInt(n) {
    return n % 1 === 0;
}

function beforeUpload() {
    centerLoading();
    $('#loader').show();
}


function reloadSongs(active_page,done_func) {
    if(arguments.length==1) {
        reloadSongs1(active_page);
    }
    if(arguments.length==2) {
        reloadSongs2(active_page,done_func);
    }

}


function reloadSongs1(active_page) {
    reloadSongs(active_page,function() {});
}

function reloadSongs2(active_page,done_func) {
    $.ajax({
        type: "POST",
        shouldRetry: 3,
        url: "songs_edit.php",
        data: {action:"edit_get_songs",active_page: active_page}

    })
        .done(function (msg) {
            $("#songs").html(msg);
            addControlsClickHandlers();
            addFieldsHandlers();
            addSubmitHandlers();
            setCurrentHashes();
            done_func();
        });
};




function loadLastPage() {
    $.ajax({
        type: "POST",
        shouldRetry: 3,
        url: "songs_edit.php",
        data: {action:"edit_get_page_count"}
    })
        .done(function (count) {
            reloadSongs(count,function() {
                reloadPagination(count,function() {
                    $(window).scrollTop($(document).height());
                })
            });
        });
}

function reloadCurrentPage() {
    var cur = $('.page_href').filter('.active').attr('value');
    var to_load = cur;
    $.ajax({
        type: "POST",
        shouldRetry: 3,
        url: "songs_edit.php" ,
        data: {action:"edit_get_page_count"}
    })
        .done(function (count) {
            if (count< cur) {
                to_load = count;
            }
            reloadSongs(to_load,function() {
                reloadPagination(to_load,function() {
                })
            });
        });
}


function reloadPagination(active_page,done_func) {
    if(arguments.length==1) {
        reloadPagination1(active_page);
    }
    if(arguments.length==2) {
        reloadPagination2(active_page,done_func);
    }

}

function reloadPagination1(active_page) {
    reloadPagination(active_page,function(){});
}

function reloadPagination2(active_page,done_func) {
$.ajax({
    type: "POST",
    shouldRetry: 3,
    url: "songs_edit.php",
    data: {action:"edit_get_pagination",active_page: active_page}
})
    .done(function (msg) {
        $("#pagination").html('<hr>' + msg + '<br><hr>');
        initPagination();
        done_func();
    });
}

function removeHandler(src) {
    $.ajax({
        type: "POST",
        shouldRetry: 3,
        url: "songs_edit.php",
        data: {action:"edit_del_song", id: src }
    })
        .done(function (msg) {
            reloadCurrentPage();
        });
}


function saveHandler(formID, hashHolderID) {
    saveValuesRelations(hashHolderID, formID);
    $("#" + formID).submit();
    $(".save_song[area='" + hashHolderID + "']").hide();
    loadAndSetPaths();
    refreshHashByID(hashHolderID);
}


function addControlsClickHandlers() {
    var $removeButtons = $(".remove_href");

    $removeButtons.each(function () {
        $(this).click(function () {
            removeHandler($(this).attr("song_id"))
        });

        $(this).hover(function () {
            $("#" + $(this).attr("area")).css("background-color", "#D16464");
        }, function () {
            $("#" + $(this).attr("area")).css("background-color", "black");
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
            $("#" + $(this).attr("area")).css("background-color", "black");
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
            checkSongHash($(this));
        });
    });
}

function checkSongHash(input) {
    var $hashHolderID = $(input).attr("hash_holder");
    var $oldHash = $("#" + $hashHolderID).attr("hash");
    var $newHash = calcFormHash($hashHolderID);
    if ($oldHash != $newHash) {
        $(".save_song[area='" + $hashHolderID + "']").show();
    } else {
        $(".save_song[area='" + $hashHolderID + "']").hide();
    }
}


function addSubmitHandlers() {
    var $forms = $(".field_editor_form");

    $forms.each(function () {
        $(this).submit(function (e) {
            e.preventDefault();
            $.ajax({
                type: "POST",
                shouldRetry: 3,
                url: "./songs_edit.php",
                data: $.extend($(this),{action:"edit_update_song"}).serialize(),
                success: function (data) {
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
        $content += $(this).val() + $(this).attr("value") + $(this).prop("checked");
    });
    var $hash = new String($content).hashCode();
    return $hash;
}

function destructor() {
    $('.cropper-invisible').remove();
    $(".mc_el").remove();
}



