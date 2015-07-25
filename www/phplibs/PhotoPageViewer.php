<?php
require_once 'phplibs/ResourceService.php';
class  PhotoPageViewer extends Page
{

    function PhotoPageViewer() {
        parent::Page();
        global $js_scripts,$styles;
        $emp = $this ->emp;
        $js_scripts = array($emp."jquery.cycle2.min.js",'photo.js');
        $styles = array('photo.css');
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
        global $template_engine;
        $galleryHelper = new GalleryHelper();
        $picPaths = $galleryHelper -> getPhotosArray();
        $template_engine->assign('photos', $picPaths);
        $template_engine->assign('count', sizeof($picPaths));
        return $template_engine->fetch('photo_body.tpl');

    }

    public function getLabelsArray($lang) {
        $localizator = new Localizator();
        return  array('main_text_pre' => $localizator->getText($lang, 'about_main_text'));
    }
}

?>