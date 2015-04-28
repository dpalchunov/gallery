<div id="main_content" class="mc_el">
    <div id="songs_editor_content">
        <div id="songs">
            {{{$songs}}}
        </div>
        <!-- end of persisted-->
        <div id="pagination">
            <hr>
            {{{$pagination}}}
            <br>
            <hr>
        </div>
        <div id="uploaded">
            <div id="uploaded_left">
                <div id="cropper_div" class="cropper_div">
                    <img id="cropper_image" class="cropper_img">
                </div>
            </div>
            <div id="uploaded_right">
                <div id="slider"></div>
                <div id="cropper-preview"></div>
                <div class="uploaded_img controls">
                    <div id="save_cancel">
                        <div class="green control">
                            <a id="songs_save_pic" href="javascript: void(0)">save&nbsp</a>
                        </div>
                        <div class="red control">
                            <a id="songs_cancel_pic" href="javascript: void(0)"> cancel</a>
                        </div>
                    </div>
                    <div class="fileuploader_wrapper">
                        <div id="fileuploader">
                            <a id="upload_label" href="">+ upload</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</div>
<!--end main_content-->