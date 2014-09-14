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

    public function  generateJsArrayHtml() {

        $avas = glob('./images/slider/avas/*.*');
        $cnt = count($avas);
        $jsArray = '[';
        if ($cnt > 0) {
            foreach($avas as $index => $file){
                $jsArray = $jsArray.
                    "\"url({$file})\"";
                if ($index < $cnt-1) {
                    $jsArray = $jsArray.",";
                }
            }
            $jsArray = $jsArray. "]";
        }  else  {
            $jsArray = "[]";
        }


        return  $jsArray;
    }
}
?>










