//TODO add time gif when uploading picture (some big picture)
var cropperHandlerIsActive = true;

String.prototype.hashCode = function(){
    if (Array.prototype.reduce){
        return this.split("").reduce(function(a,b){a=((a<<5)-a)+b.charCodeAt(0);return a&a},0);
    }
    var hash = 0;
    if (this.length === 0) return hash;
    for (var i = 0; i < this.length; i++) {
        var character  = this.charCodeAt(i);
        hash  = ((hash<<5)-hash)+character;
        hash = hash & hash; // Convert to 32bit integer
    }
    return hash;
}

$(function() {
    $( "#slider" ).slider({ max: 100,
                            min: 0,
                            step: 1,
                            value:50 ,
                            slide: function( event, ui ) { slideHandler();},
                            stop: function( event, ui ) { slideHandler();}
                                    } );
});

function slideHandler() {
    setPreviewSize();
}

function setPreviewSize() {
    cropperHandlerIsActive = false;
    var data = $(".cropper_img").cropper("getData");
    var ratio = (data.height)/(data.width);

    var w = Math.round(440/100*$( "#slider" ).slider( "value" ));
    var h = Math.round(w*ratio);
    $('#cropper-preview').width(w);
    $('#cropper-preview').height(h);


    //refresh cropper to recalculate preview
    $(".cropper_img").cropper("setData",data);
    cropperHandlerIsActive = true;
}

function initCropper() {
    var $image = $(".cropper_img");
    $image.cropper({
        data: {
            x: 480,
            y: 60,
            width: 640,
            height: 360
        },
        preview: ".cropper-preview",
        done: function(data) {
//            console.log(data);
        }
    });

    setCropperHandler();

}

function setCropperHandler() {
    var $image = $(".cropper_img");
    $image.on("render.cropper",function() {if (cropperHandlerIsActive) {cropperChangeHandler();}})
}

function unCropperHandler() {
    var $image = $(".cropper_img");
    $image.on("render.cropper",function() {})
}


function cropperChangeHandler() {
    setPreviewSize();
}

$(document).ready(function(){


    var $image = $(".cropper_img");
    var currentSrc;
    initCropper();
    var savehref = $('#gallery_save_pic');
    savehref.click(function() {
        saveCropHandler();
    });

    var cancelhref = $('#gallery_cancel_pic');
    cancelhref.click(function() {
        cancelCropHandler();
    });

    addControlsClickHandlers();
    addFieldsChangeHandlers();

    $("#fileuploader").uploadFile({
        url:"./gallery_upload_pic.php",
        fileName:"myfile",
        onSuccess:function(files,json_data,xhr) {

            beforeUpload();
            var data = $.parseJSON(json_data);
            var img_w = data[1];
            var img_h = data[2];
            changeSrc(data[0]);
            img_tag_size = calc_img_size(img_w,img_h);
            afterUpload(img_tag_size);
            resizeDragAndDrop(img_tag_size);

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
        $("#slider").hide();
    }

    function changeSrc(data) {
        var d = new Date();
        currentSrc =  "./" + data
        var src = currentSrc + "?" + d.getTime();

        $image.cropper("setImgSrc", src);
    }

    function afterUpload(img_tag_size) {
        $("#uploaded_left").height(img_tag_size);
        $("#cropper-preview").height(219);
        $("#save_cancel").show();
        $("#cropper-preview").show();
        $("#slider").show();
        $("#cropper_div").show();
        $("#upload_label").text("+ upload another");
    }


    function calc_img_size(img_w,img_h) {
        return  img_h*600/img_w;
    }

    function resizeDragAndDrop(img_tag_size) {
        if (img_tag_size > 315) {
            h = img_tag_size - 275;
        }  else
        {
            h = 40;
        }

        $(".ajax-upload-dragdrop").css('height',parseInt(h));

    }

    function saveCropHandler () {
        $.ajax({
            type: "POST",
            url: "gallery_save_pic.php",
            data: { pic_src: currentSrc , pic_data: JSON.stringify($image.cropper("getData")), w: $('#cropper-preview').width() ,h: $('#cropper-preview').height()}
        })
            .done(function( msg ) {
                console.log(msg);
                hideUploadControls();
                reloadGallery();
                initCropper();
            });
    }

    function cancelCropHandler () {
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

    function reloadGallery() {
        $.ajax({
            type: "POST",
            url: "gallery_edit_get_gallery.php"
        })
            .done(function( msg ) {
                $("#gallery").html(msg);
                addControlsClickHandlers();
            });
    }

    function removeHandler(src) {
        $.ajax({
            type: "POST",
            url: "gallery_del_pic.php",
            data: { file_name: src }
        })
            .done(function( msg ) {
                reloadGallery();
            });
    }



    function addControlsClickHandlers() {
        var $removeButtons = $(".remove_href");

        $removeButtons.each(function() {
            $(this).click(function() {
                removeHandler($(this).attr("file_name"))
            });

            $(this).hover(function() {
                $("#" + $(this).attr("area")).css("background-color","#D16464");
            },function() {
                $("#" + $(this).attr("area")).css("background-color","#d2dfe3");
            });

        });

        var $saveButtons = $(".save_href");

        $saveButtons.each(function() {
            $(this).click(function() {
                removeHandler($(this).attr("file_name"))
            });

            $(this).hover(function() {
                $("#" + $(this).attr("area")).css("background-color","#5d9f7a");
            },function() {
                $("#" + $(this).attr("area")).css("background-color","#d2dfe3");
            });

        });

    }
    function addFieldsChangeHandlers() {
        var $inputs = $(".field_editor_input");

        $inputs.each(function() {
            $(this).change(function() {
                var $hashHolderID = $(this).attr("hash_holder");
                var $oldHash = $("#"+$hashHolderID).attr("hash");
                var $newHash = calcFormHash($hashHolderID);
                if ($oldHash != $newHash) {
                    $(".save_pic[area='" + $hashHolderID + "']").show();
                } else {
                    $(".save_pic[area='" + $hashHolderID + "']").hide();
                }
            });
        });
    }

    function calcFormHash(hash_holder_id) {
        var $fields = $("[hash_holder='" + hash_holder_id + "']");
        var $content = '';
        $fields.each(function() {
            $content += $(this).attr("value") + $(this).prop("checked");
        });
        var $hash = new String($content).hashCode();
        console.log($hash);
        return $hash;

    }

});
