<?php
class  GalleryEditHtmlGetter {
    public function  getHTMLCode() {
        $pics_tmp = glob('./images/gallary/sketches/*.*');
        $pics = array_reverse($pics_tmp);
        $picsHtml = '';
        foreach($pics as $index => $file) {
            $picsHtml = $picsHtml.
                "<div class=\"gallery\">
                    <div class=\"pic\"\">
                        <img src=\"{$file}\"/>
                    </div>
                    <div class=\"pic_controls controls\">
                        <div class=\"red remove\">
                            <a class=\"remove_pic\" src=\"{$file}\" href=\"javascript: void(0)\" > remove</a>
                        </div>
                    </div>
                </div>";
        }
        return  $picsHtml;
    }
}
?>










