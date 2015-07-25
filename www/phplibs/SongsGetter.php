<?php
require_once 'phplibs/ResourceService.php';
class  SongsGetter
{

    public function __construct($language)
    {
        global $template_engine, $db, $lang;
        $resourceService = new ResourceService();
        $template_engine = $resourceService->getTemplateEngine();
        $db = $resourceService->getDBConnection();
        $lang = $language;
    }


    public function getSongsExposition($lang)
    {
        $pm = new SongsObjManager();
        $objectArray = $pm -> selectAllSongs();
        if ($objectArray != null) {
            $expoHTML = $this->getSongsHTML($objectArray, $lang);
            return $expoHTML;
        } else {
            return '';
        }
    }



    private function getSongsHTML($objs, $lang)
    {
        if (!(sizeof($objs) > 0)) {
            return '';
        };

        $songsHtmls = '';
        foreach ($objs as $obj) {
            $songHtml = $this -> getSketchHTMLCode($obj,$lang);
            $songsHtmls .= $songHtml;
        }

        return $songsHtmls;
    }


    private function getSketchHTMLCode($obj, $lang)
    {
        global $template_engine;

        $desc = $obj->getDescription($lang);
        $expo = $obj->getExpoPosition();
        $filename = $obj -> getFileName();
        $path = $obj -> getPath();;
        $id = $obj->getID();
        $template_engine->assign('song_id', $id);
        $template_engine->assign('song_desc_id', $id.'_desc');
        $template_engine->assign('song_path', $path);
        if ($expo != null){

            $left = $expo ->getLeft();
            $top = $expo ->getTop();
            $width = $expo ->getWidth();
            $ratio = $expo ->getRatio();


            $template_engine->assign('css_left', $left."%");
            $template_engine->assign('css_width', $width."%");
            $template_engine->assign('left', $left);
            $template_engine->assign('top', $top);
            $template_engine->assign('width', $width);
            $template_engine->assign('ratio', $ratio);


        } else {

        }

        $template_engine->assign('songDescription', $desc);
        $template_engine->assign('filename', $filename);

        $htmlCode = $template_engine->fetch('sketch_song.tpl');
        return $htmlCode;

    }


    public function getLabelsArray($lang)
    {
        $pm = new SongsObjManager();
        $objArray = $pm -> selectAllSongs();
        if ($objArray != null) {
            $res = $this->getLabels($objArray, $lang);
        } else {
            $res = array();
        }
        return $res;
    }

    private function getLabels($objs, $lang)
    {
        if (!(sizeof($objs) > 0)) {
            return '';
        };

        $all_labels = array();
        foreach ($objs as $obj) {
            $id = $obj->getID();
            $desc = $obj->getDescription($lang);
            $all_labels[$id.'_desc'] = $desc;
        }

        return $all_labels;
    }


}

?>