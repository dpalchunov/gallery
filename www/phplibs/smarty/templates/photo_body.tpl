<div id="main_content" class="mc_el">
    <div id="slideshow" class="band white">
        {{{$persisted_intros}}}
    </div>

    <div id="band3" class="band white">

        <div class="band_cnt  white">
            <div class="band_title">
            </div>
            <div class="band_body">
                {{{for $i = 0 to $count-1 }}}
                <div class="grid_list_cell" style="background-image: url('{{{$photos[$i]}}}')"></div>
                {{{/for}}}

            </div>
        </div>
    </div>
</div>

<!--end main_content-->
