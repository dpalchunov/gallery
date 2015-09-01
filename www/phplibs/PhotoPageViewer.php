<?php
require_once 'phplibs/ResourceService.php';
class  PhotoPageViewer extends Page
{

    function PhotoPageViewer() {
        parent::Page();
        global $js_scripts,$styles;
        $emp = $this ->emp;
        $js_scripts = array($emp."jquery.cycle2.min.js",'photo.js');
        $styles = array('photo.css','fullscreen_gallery.css');
    }

    public function getHeadContent() {
        global $template_engine;
        return $template_engine->fetch('photo_head_content.tpl');
    }

    public function getHeader() {
        global  $resourceService;
        $lang = $resourceService -> getLang();
        return HeaderGetter::getHeaderHtml($lang,'photo');
    }

    public function getNavMenu() {
        global  $resourceService;
        $lang = $resourceService -> getLang();
        return HeaderGetter::getNavMenuHtml($lang,'photo');
    }

    public function getBody($params) {
        global $template_engine, $resourceService;;
        $pic_man = new PictureObjManager();
        $pics = $pic_man->selectAllPics();
        $template_engine->assign('photos', $pics);
        $template_engine->assign('count', sizeof($pics));
        $template_engine->assign('lang', $resourceService -> getLang());
        return $template_engine->fetch('photo_body.tpl');

    }

    public function getLabelsArray($lang) {
        $pg = new PicturesGetter($lang);
        return $pg -> getLabelsArray($lang);
    }
}

?>