var cropperHandlerIsActive = true;
var $image;

function initCropper() {
    $image.cropper({
        autoCrop:"auto",
        autoCropArea: 1,
        zoomable: false,
        preview: ".cropper-preview",
        done: function (data) {
            //console.log(data);
        }
    });

    setCropperHandler();

}

function cropperChangeHandler() {
    cropperHandlerIsActive = false;
    setPreviewSize();
    cropperHandlerIsActive = true;
}

function setPreviewSize() {
    var data = $(".cropper_img").cropper("getData");
    var ratio = (data.height) / (data.width);

    var w = 350;
    var h = Math.round(w * ratio);
    $('#cropper-preview').width(w);
    $('#cropper-preview').height(h);


    //refresh cropper to recalculate preview
    $(".cropper_img").cropper("setData", data);
}


function setCropperHandler() {
    $image.on("dragmove.cropper", function () {
        if (cropperHandlerIsActive) {
            cropperChangeHandler();
        }
    })
    $image.on("built.cropper", function () {
        if (cropperHandlerIsActive) {
            cropperChangeHandler();
            $(window).scrollTop($(document).height());
            resizeDragAndDrop($('#cropper_div').height());
            $('#loader').hide();
            var i_data  = $image.cropper("getImageData")
            $image.cropper("setData", {width: i_data.naturalWidth, height: i_data.naturalHeight});
        }
    })
}

function afterUpload(img_tag_height) {
    $("#uploaded_left").height(img_tag_height);
    $("#cropper-preview").height(219);
    $("#save_cancel").show();
    $("#cropper-preview").show();
    $("#cropper_div").show();
    $("#upload_label").text("+ upload another");

}


function calc_img_size(img_w, img_h) {
    return  img_h * 600 / img_w;
}

function resizeDragAndDrop(img_tag_height) {
    if (img_tag_height > 315) {
        h = img_tag_height - 275;
    } else {
        h = 40;
    }

    $(".ajax-upload-dragdrop").css('height', parseInt(h));

}

$(document).ready(function () {
    destructor = destructor;

    $image = $(".cropper_img");
    var currentSrc;
    initCropper();
    var savehref = $('#wellcome_save_ava');
    savehref.click(function () {
        saveCropHandler();
    });

    var cancelhref = $('#wellcome_cancel_ava');
    cancelhref.click(function () {
        cancelCropHandler();
    });

    addRemoveClickHandlers();

    $("#fileuploader").uploadFile({
        method: "POST",
        url: "./wellcome_edit.php",
        fileName: "myfile",
        formData: {action:"edit_upload_ava"},
        onSuccess: function (files, json_data, xhr) {
            console.log(json_data);
            beforeUpload();
            var data = $.parseJSON(json_data);
            var img_w = data[1];
            var img_h = data[2];
           // destroy_cropper();
            initCropper();
            changeSrc(data[0]);
            img_tag_height = calc_img_size(img_w, img_h);
            afterUpload(img_tag_height);
        },
        uploadButtonClass: "green ajax-file-upload",
        showDone: false,
        showProgress: false,
        allowedTypes: "jpg,jpeg,png,gif"
    });

    function beforeUpload() {
        centerLoading();
        $('#loader').show();
        $("#cropper-preview").addClass("cropper-preview");
        $("#cropper_div").hide();
        $("#cropper-preview").hide();
        $("#cropper_image").hide();
    }

    function changeSrc(data) {
        var d = new Date();
        currentSrc = "./" + data
        var src = currentSrc + "?" + d.getTime();

        $image.cropper("replace", src);
    }



    function saveCropHandler() {
        $('#loader').show();
        $(window).scrollTop(0,0);
        centerLoading();
        $.ajax({
            type: "POST",
            url: "wellcome_edit.php",
            data: {action:"edit_save_intro", avatar_src: currentSrc, avatar_data: JSON.stringify($image.cropper("getData"))}
        })
            .done(function (msg) {
                hideUploadControls();
                reloadPersistedIntros();
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

    function reloadPersistedIntros() {
        $.ajax({
            type: "POST",
            url: "./wellcome_edit.php",
            data: {action:"get_intros"}
        })
            .done(function (msg) {
                $("#persisted").html(msg);
                addRemoveClickHandlers();
            });
    }

    function removeHandler(src) {
        $.ajax({
            type: "POST",
            url: "edit_helper.php",
            data: {action:"del_file", src: src }
        })
            .done(function (msg) {
                reloadPersistedIntros();
            });
    }

    function addRemoveClickHandlers() {
        var $removeButtons = $(".remove_obj");

        $removeButtons.each(function () {
            $(this).click(function () {
                removeHandler($(this).attr("src"))
            });
        });

    }
});

function destructor() {
    $('.cropper-invisible').remove();
}