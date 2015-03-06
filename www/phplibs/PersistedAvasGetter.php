<?php
class  PersistedAvasGetter extends PersistedPicsGetter
{


    public function PersistedAvasGetter()
    {
        global $path;
        $path =  './images/slider/avas/*.*';

    }


    public function  generatePicsHtmlForEdit()
    {
        global $path;
        $objs_tmp = glob($path);
        $avas = array_reverse($objs_tmp);
        $avasHtml = '';
        foreach ($avas as $index => $file) {
            $avasHtml = $avasHtml .
                "<div class=\"persisted\">
              <div class=\"image\"><img src=\"$file\"></img></div>
                <div class=\"persisted_img_controls controls\">";
            if ($index > 0) {
                $avasHtml = $avasHtml .
                    "<div class=\"green st1\">
                        <a class=\"st1_href\" src=\"{$file}\" href=\"javascript: void(0)\" > 1st  </a>
                     </div>";
            };
            $avasHtml = $avasHtml .
                "<div class=\"red remove\">

                  <a class=\"remove_ava\" src=\"{$file}\" href=\"javascript: void(0)\" > remove</a>
                 </div>
              </div>
            </div>";
        }
        return $avasHtml;
    }
}

?>










