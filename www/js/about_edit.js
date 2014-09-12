$(document).ready(function(){
    var $image = $(".cropper_img");
    var currentSrc;

    $image.cropper({
        aspectRatio: 575 / 301,
        data: {
            x: 480,
            y: 60,
            width: 640,
            height: 360
        },
        preview: ".cropper-preview",
        done: function(data) {
            console.log(data);
        }
        });

    var savehref = $('#about_save_ava');
    savehref.click(function() {
        saveCropHandler();
    });

    var cancelhref = $('#about_cancel_ava');
    cancelhref.click(function() {
        cancelCropHandler();
    });

    addRemoveClickHandlers();





    $("#fileuploader").uploadFile({
        url:"./about_upload_ava.php",
        fileName:"myfile",
        onSuccess:function(files,json_data,xhr) {
            beforeUpload();
            var data = $.parseJSON(json_data);
            var img_w = data[1];
            var img_h = data[2];
            changeSrc(data[0]);
            ufterUpload();
            resizeDragAndDrop(img_w,img_h);

        },
        uploadButtonClass:"green ajax-file-upload",
        showDone:false,
        showProgress:false,
        allowedTypes:"jpg,jpeg,png,gif"
    });

    function beforeUpload() {

        $("#cropper-preview").addClass("cropper-preview");
        $("#cropper_div").hide();
        $("#cropper-preview").hide();
    }

    function changeSrc(data) {
        var d = new Date();
        currentSrc =  "./" + data
        var src = currentSrc + "?" + d.getTime();

        $image.cropper("setImgSrc", src);
    }

    function ufterUpload() {

        $("#save_cancel").show();
        $("#cropper-preview").show();
        $("#cropper_div").show();
        $("#upload_label").text("+ upload another");
    }

    function resizeDragAndDrop(img_w,img_h) {
        //alert("test");
        var h;
        if (img_w < 600) {
            h = img_h;
        } else {
            var compression = img_w/600;
            h = img_h/compression;
        }
        if (h > 315) {
            h = h - 275;
        }  else
        {
            h = 40;
        }

        $(".ajax-upload-dragdrop").css('height',parseInt(h));

    }

    function saveCropHandler () {
        $.ajax({
            type: "POST",
            url: "about_save_ava.php",
            data: { avatar_src: currentSrc , avatar_data: JSON.stringify($image.cropper("getData"))}
        })
            .done(function( msg ) {
                hideUploadControls();
                reloadPersistedAvas();
            });
    }

    function cancelCropHandler () {
        hideUploadControls();
    }

    function hideUploadControls() {
        $image.cropper("setImgSrc", " ");
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
            .done(function( msg ) {
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
            .done(function( msg ) {
                reloadPersistedAvas();
            });
    }

    function addRemoveClickHandlers() {
        var $removeBottons = $(".remove_ava");

        $removeBottons.each(function() {
            $(this).click(function() {
                removeHandler($(this).attr("src"))
            });
        });
    }



});
