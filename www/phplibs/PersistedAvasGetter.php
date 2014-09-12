<?php
class  PersistedAvasGetter {
    public function  generateAvasHtml() {
        $avasHtml = '';
        foreach(glob('./images/slider/avas/*.*') as $file) {
            $avasHtml = $avasHtml.
                "<div class=\"persisted\">
                <div class=\"image\" style=\"background-image: url({$file}); \"></div>
                <div class=\"persisted_img_controls controls\"><div class=\"red remove\"><a class=\"remove_ava\" src=\"{$file}\" href=\"javascript: void(0)\" > remove</a></div></div>
            </div>";
        }
        return  $avasHtml;
    }
}
?>










