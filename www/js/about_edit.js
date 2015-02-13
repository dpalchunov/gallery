var cropperHandlerIsActive = true;


function initCropper() {
    $.fn.cropper;
    var $image = $(".cropper_img");
    $image.cropper({
        autoCropArea:1,
        zoomable:false,
        preview: ".cropper-preview",
        done: function (data) {
            //console.log(data);
        }
    });

    setCropperHandler();

}

function cropperChangeHandler() {
    setPreviewSize();
}

//den_todo does cropperHandlerIsActive works?
function setPreviewSize() {
    cropperHandlerIsActive = false;
    var data = $(".cropper_img").cropper("getData");
    var ratio = (data.height) / (data.width);

    var w = 350;
    var h = Math.round(w * ratio);
    $('#cropper-preview').width(w);
    $('#cropper-preview').height(h);


    //refresh cropper to recalculate preview
    $(".cropper_img").cropper("setData", data);
    cropperHandlerIsActive = true;
}


function setCropperHandler() {
    var $image = $(".cropper_img");
    $image.on("dragend.cropper", function () {
        if (cropperHandlerIsActive) {
            cropperChangeHandler();
        }
    })
    $image.on("built.cropper", function () {
        if (cropperHandlerIsActive) {
            cropperChangeHandler();
            $(window).scrollTop($(document).height());
        }
    })
}

$(document).ready(function () {
    var $image = $(".cropper_img");
    var currentSrc;
    initCropper();
    var savehref = $('#about_save_ava');
    savehref.click(function () {
        saveCropHandler();
    });

    var cancelhref = $('#about_cancel_ava');
    cancelhref.click(function () {
        cancelCropHandler();
    });

    addRemoveClickHandlers();

    $("#fileuploader").uploadFile({
        url: "./about_upload_ava.php",
        fileName: "myfile",
        onSuccess: function (files, json_data, xhr) {

            beforeUpload();
            var data = $.parseJSON(json_data);
            var img_w = data[1];
            var img_h = data[2];
            changeSrc(data[0]);
            img_tag_size = calc_img_size(img_w, img_h);
            afterUpload(img_tag_size);
            resizeDragAndDrop(img_tag_size);

        },
        uploadButtonClass: "green ajax-file-upload",
        showDone: false,
        showProgress: false,
        allowedTypes: "jpg,jpeg,png,gif"
    });

    function beforeUpload() {

        $("#cropper-preview").addClass("cropper-preview");
        $("#cropper_div").hide();
        $("#cropper-preview").hide();
    }

    function changeSrc(data) {
        var d = new Date();
        currentSrc = "./" + data
        var src = currentSrc + "?" + d.getTime();

        $image.cropper("replace", src);
    }

    function afterUpload(img_tag_size) {
        $("#uploaded_left").height(img_tag_size);
        $("#cropper-preview").height(219);
        $("#save_cancel").show();
        $("#cropper-preview").show();
        $("#cropper_div").show();
        $("#upload_label").text("+ upload another");
    }


    function calc_img_size(img_w, img_h) {
        return  img_h * 600 / img_w;
    }

    function resizeDragAndDrop(img_tag_size) {
        if (img_tag_size > 315) {
            h = img_tag_size - 275;
        } else {
            h = 40;
        }

        $(".ajax-upload-dragdrop").css('height', parseInt(h));

    }

    function saveCropHandler() {
        $('#loader').show();
        $(window).scrollTop(0,0);
        centerLoading();
        $.ajax({
            type: "POST",
            url: "about_save_ava.php",
            data: { avatar_src: currentSrc, avatar_data: JSON.stringify($image.cropper("getData"))}
        })
            .done(function (msg) {
                hideUploadControls();
                reloadPersistedAvas();
                initCropper();
                $('#loader').hide();
            });
    }

    function cancelCropHandler() {
        hideUploadControls();
        initCropper();
    }

    function hideUploadControls() {
        $image.cropper("replace", " ");
        $image.cropper("destroy");
        $("#uploaded_left").height(1);
        $("#cropper-preview").height(1);
        $("#save_cancel").hide();
        $(".ajax-upload-dragdrop").height(40);
        $("#upload_label").text("+ upload");
    }

    function reloadPersistedAvas() {
        $.ajax({
            type: "POST",
            url: "about_get_avas.php"
        })
            .done(function (msg) {
                $("#persisted").html(msg);
                addRemoveClickHandlers();
            });
    }

    function removeHandler(src) {
        $.ajax({
            type: "POST",
            url: "about_del_ava.php",
            data: { avatar_src: src }
        })
            .done(function (msg) {
                reloadPersistedAvas();
            });
    }

    function st1Handler(src) {
        $.ajax({
            type: "POST",
            url: "about_1st_ava.php",
            data: { avatar_src: src }
        })
            .done(function (msg) {
                reloadPersistedAvas();
            });
    }


    function addRemoveClickHandlers() {
        var $removeButtons = $(".remove_ava");

        $removeButtons.each(function () {
            $(this).click(function () {
                removeHandler($(this).attr("src"))
            });
        });

        var $stButtons = $(".st1_href");

        $stButtons.each(function () {
            $(this).click(function () {
                st1Handler($(this).attr("src"))
            });
        });
    }


});
