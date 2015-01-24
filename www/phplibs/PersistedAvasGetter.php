<?php
class  PersistedAvasGetter
{
    public function  generateAvasHtml()
    {
        $avas_tmp = glob('./images/slider/avas/*.*');
        $avas = array_reverse($avas_tmp);
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

    public function  generateJsArrayHtml()
    {

        $avas_tmp = glob('./images/slider/avas/*.*');
        $avas = array_reverse($avas_tmp);
        $cnt = count($avas);
        $jsArray = '[';
        if ($cnt > 0) {
            foreach ($avas as $index => $file) {
                $jsArray = $jsArray .
                    "\"url({$file})\"";
                if ($index < $cnt - 1) {
                    $jsArray = $jsArray . ",";
                }
            }
            $jsArray = $jsArray . "]";
        } else {
            $jsArray = "[]";
        }


        return $jsArray;
    }

    public function  generateJsArrayHtml1()
    {

        $avas_tmp = glob('./images/slider/avas/*.*');
        $avas = array_reverse($avas_tmp);
        $cnt = count($avas);
        $jsArray = '[';
        if ($cnt > 0) {
            foreach ($avas as $index => $file) {
                $jsArray = $jsArray .
                    "\"{$file}\"";
                if ($index < $cnt - 1) {
                    $jsArray = $jsArray . ",";
                }
            }
            $jsArray = $jsArray . "]";
        } else {
            $jsArray = "[]";
        }


        return $jsArray;
    }

    public function  getAvasArray()
    {

        $avas_tmp = glob('./images/slider/avas/*.*');
        $avas = array_reverse($avas_tmp);
        return  $avas;
    }



}

?>










