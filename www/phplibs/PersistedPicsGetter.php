<?php
abstract class  PersistedPicsGetter
{

    public function PersistedPicsGetter()
    {

    }

    abstract function generatePicsHtmlForEdit();


    public function  generateJsArrayHtml()
    {

        global $path;

        $avas_tmp = glob($path);
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
        global $path;

        $avas_tmp = glob($path);
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
        global $path;
        $avas_tmp = glob($path);
        $avas = array_reverse($avas_tmp);
        return  $avas;
    }



}

?>










