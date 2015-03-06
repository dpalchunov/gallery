<?php
class  PersistedIntrosGetter extends PersistedPicsGetter
{


    public function PersistedIntrosGetter()
    {
        global $path;
        $path =  './images/intros/*.*';

    }


    public function  generatePicsHtmlForEdit()
    {

        global $path;
        $objs_tmp = glob($path);
        $objs = array_reverse($objs_tmp);
        $objsHtml = '';
        foreach ($objs as $index => $file) {
            $objsHtml = $objsHtml .
                "<div class=\"persisted\">
              <div class=\"image\"><img src=\"$file\"></img></div>
                <div class=\"persisted_img_controls controls\">";
            $objsHtml = $objsHtml .
                "<div class=\"red remove\">

                  <a class=\"remove_obj\" src=\"{$file}\" href=\"javascript: void(0)\" > remove</a>
                 </div>
              </div>
            </div>";
        }
        return $objsHtml;
    }

    public function generatePicsHtmlForView() {
        global $path;
        $objs_tmp = glob($path);
        $objs = array_reverse($objs_tmp);
        $objsHtml = '';
        foreach ($objs as $file) {
            $objsHtml = $objsHtml .
            "<img src=\"{$file}\" >";
        }
        return $objsHtml;
    }
}

?>










