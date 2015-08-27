<div id="main_content" class="mc_el">
    <div id="band1" class="band white">
        <div class="band_cnt  white">
            <div class="band_title">
                <div class="band_title_l container l">
                    VIDEO
                </div>
                <div class="band_title_r container r">

                </div>
            </div>
            <div class="band_body white">
                <div class="bigbox">
                    <div id="uniquePlayer-1" class="webPlayer light">
                        <div id="uniqueContainer-1" class="videoPlayer"></div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div id="band3" class="band grey">
        <div class="band_cnt  grey">
            <div class="band_title">
                <div class="band_title_l container l">

                </div>
                <div class="band_title_r container r">

                </div>
            </div>
            <div class="band_body">
                {{{for $i = 0 to $count-1 }}}
                <div class="grid_list_cell video" thumb_url="{{{$videos[$i] -> getThumbnail()}}}" style="background-image: url('{{{$videos[$i] -> getThumbnail()}}}')" video_path="{{{$videos[$i]-> getPath()}}}" >
                    <div class="details">
                        <p>{{{$videos[$i] -> getDescription($lang)}}}</p>
                    </div>
                </div>
                {{{/for}}}


            </div>
        </div>


        <!--end main_content-->



    </div>









