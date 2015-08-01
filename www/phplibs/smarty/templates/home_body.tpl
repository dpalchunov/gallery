<div id="main_content" class="mc_el">
    <div id="slideshow" class="band white">
        {{{$persisted_intros}}}
    </div>

    <div id="band1" class="band white">
        <div class="band_cnt  white">
            <div class="band_title">
                <div class="band_title_l container l">
                    VIDEO
                </div>
                <div class="band_title_r container r">

                    SEE ALL VIDEOS
                </div>
            </div>
            <div class="band_body  black">
            </div>
        </div>
    </div>

    <div id="band2" class="band ">
        <div class="band_cnt">
            <div class="band_title">
                <div id="songs_band_title_l" class="band_title_l l container">
                    SONGS
                </div>
                <div class="band_title_r r container">
                    ALL MUSIC
                </div>
            </div>
            <div class="band_body">
                <div id="play_list" class="">
                    <div id="player_top" class="white">
                        <div id="player_icon" class="blue">


                        </div>
                        <div id="player_controls" class="">


                            <div id="player_buttons" class="container">
                                <div id="prev"></div>
                                <div id="player_mini_button" class="playing">
                                </div>
                                <div id="next"></div>

                                <div id="song_title" class="jp-title"></div>

                            </div>



                            <div id="player_outline_mini" class="">
                                <div id="progress_time_time"></div>
                                <div id="mini_inline">
                                    <div id="mini_progress"></div>
                                </div>
                                <div id="track_count_count"></div>
                            </div>
                        </div>
                    </div>
                    <div id="player_bottom" class="">


                        <ul>
                            {{{for $i = 0 to $count-1 }}}
                            <li>
                                <div class="song white" song_path="{{{$songs[$i] -> getPath()}}}">
                                    <div class="song_ico"
                                         style="background-image: url('./images/gallary/20150425101131.jpeg')"></div>
                                    <div class="song_name container ">
                                        {{{$songs[$i] -> getDescription($lang)}}}
                                    </div>
                                </div>
                            </li>
                             {{{/for}}}
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="band3" class="band white">

        <div class="band_cnt  white">
            <div class="band_title">
                <div class="band_title_l l container">
                    PHOTO
                </div>
                <div class="band_title_r r container">
                    SHOW ALL
                </div>
            </div>
            <div class="band_body">
                {{{for $i = 0 to $pic_count-1 }}}
                <div class="grid_list_cell picture" style="background-image: url('{{{$photos[$i] -> getSketchPath()}}}')" picpath="{{{$photos[$i]-> getPicPath()}}}" >
                    <div class="details"> </div>
                </div>
                {{{/for}}}

            </div>
        </div>
    </div>
</div>

<!--end main_content-->
