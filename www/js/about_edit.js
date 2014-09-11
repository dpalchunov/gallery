$(document).ready(function(){
    var $image = $(".cropper_img");

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


    $("#fileuploader").uploadFile({
        url:"./about_upload_ava.php",
        fileName:"myfile",
        onSuccess:function(files,data,xhr) {
            beforeUpload();
            changeSrc(data);
            ufterUpload();
            resizeDragAndDrop();
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
        var newsrc = "./" + data + "?" + d.getTime();
        $image.cropper("setImgSrc", newsrc);
    }

    function ufterUpload() {

        $("#save_cancel").show();
        $("#cropper-preview").show();
        $("#cropper_div").show(400,function() {resizeDragAndDrop();});
    }

    function resizeDragAndDrop() {
        //alert("test");
        var h = $("#uploaded_left").height() - 240;
        $(".ajax-upload-dragdrop").css('height',parseInt(h));

    }
});
