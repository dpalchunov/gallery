<?php
require_once 'phplibs/ResourceService.php';
class  SongsGetter
{

    public function getPicExposition($lang)
    {
        $pm = new PictureObjManager();
        $pictureObjectArray = $pm -> selectAllPics();
        if ($pictureObjectArray != null) {
            $expoHTML = $this->getPicturesHTML($pictureObjectArray, $lang);
            return $expoHTML;
        } else {
            return '';
        }
    }


    private function getPicturesHTML($pictures, $lang)
    {
        global $template_engine;
        if (!(sizeof($pictures) > 0)) {
            return '';
        };

        $pictureHtmls = '';
        foreach ($pictures as $i => $picture) {
            $picHtml = $this -> getSketchHTMLCode($picture,$lang,$i);
            $pictureHtmls .= $picHtml;
        }

        return $pictureHtmls;
    }


    private function getSketchHTMLCode($pictureObject, $lang, $zindex)
    {
        global $template_engine;

        $pictureSketchPath = $pictureObject->getSketchPath();
        $picturePath = $pictureObject->getPicPath();
        $pictureSequenceNumber = $pictureObject->getPosition() + 1;
        $picDescription = $pictureObject->getDescription($lang);
        $picRate = $pictureObject->getRate();
        $picExpo = $pictureObject->getExpoPosition();
        $id = $pictureObject->getID();
        $template_engine->assign('pic_id', $id);
        $template_engine->assign('pic_desc_id', $id.'_desc');
        $template_engine->assign('zindex', 0);
        if ($picExpo != null){

            $left = $picExpo ->getLeft();
            $top = $picExpo ->getTop();
            $width = $picExpo ->getWidth();
            $ratio = $picExpo ->getRatio();


            $template_engine->assign('css_left', $left."%");
            $template_engine->assign('css_width', $width."%");
            $template_engine->assign('left', $left);
            $template_engine->assign('top', $top);
            $template_engine->assign('width', $width);
            $template_engine->assign('ratio', $ratio);


        } else {

        }

        $picRateHtml = $this->makePicRateHtml($picRate);
        $template_engine->assign('picRate', $picRateHtml);
        $template_engine->assign('picDescription', $picDescription);
        $template_engine->assign('pictureSketchPath', $pictureSketchPath);
        $template_engine->assign('picPath', $picturePath);
        $template_engine->assign('sequenceNumber', $pictureSequenceNumber);

        $picHTMLCode = $template_engine->fetch('sketch.tpl');
        return $picHTMLCode;

    }


    public function getLabelsArray($lang)
    {
        $pm = new PictureObjManager();
        $pictureObjectArray = $pm -> selectAllPics();
        if ($pictureObjectArray != null) {
            $res = $this->getPicturesLabels($pictureObjectArray, $lang);
        } else {
            $res = array();
        }
        return $res;
    }

    private function getPicturesLabels($pictures, $lang)
    {
        if (!(sizeof($pictures) > 0)) {
            return '';
        };

        $all_labels = array();
        foreach ($pictures as $picture) {
            $id = $picture->getID();
            $picDescription = $picture->getDescription($lang);
            $all_labels[$id.'_desc'] = $picDescription;
        }

        return $all_labels;
    }


}

?>