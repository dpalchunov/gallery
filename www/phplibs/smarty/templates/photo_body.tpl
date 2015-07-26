<div id="fullScreenGallery" class="mc_el">
    <div id="fullScreenGalleryLeftSide" class="fullScreenGalleryNaviButton"></div>
    <div id="fullScreenPicContainer">
        <img id="big_image" />
        <img id="resampled_image" />
    </div>
    <div id="fullScreenGalleryRightSide" class="fullScreenGalleryNaviButton"></div>
</div>
<div id="main_content" class="mc_el">
    <div id="slideshow" class="band white">
        {{{$persisted_intros}}}
    </div>

    <div id="band3" class="band white">

        <div class="band_cnt  white">
            <div class="band_body">
                {{{for $i = 0 to $count-1 }}}
                <div class="grid_list_cell picture" style="background-image: url('{{{$photos[$i]}}}')" picpath="{{{$photos[$i]}}}" >
                    <div class=""> </div>
                </div>
                {{{/for}}}

            </div>
        </div>
    </div>
</div>

<!--end main_content-->
