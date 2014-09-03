$(document).ready(function(){
    var $image = $(".cropper_img")

    $image.cropper({
        aspectRatio: 16 / 9,
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
});
