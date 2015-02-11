<?php
require_once 'phplibs/ResourceService.php';
class  GalleryExpoEditPageViewer extends Page
{

    function GalleryExpoEditPageViewer() {
        parent::Page();
        global $js_scripts,$styles;
        $js_scripts = array('gallery_expo.js','jquery.uploadfile.js');
        $styles = array('uploadfile.css','gallery_expo_style.css');
    }

    public function getHeadContent() {
        return '';
    }

    public function getHeader() {
        global  $resourceService;
        $lang = $resourceService -> getLang();
        return HeaderGetter::getHeaderHtml($lang,'none');
    }

    public function getNavMenu() {
        global  $resourceService;
        $lang = $resourceService -> getLang();
        return HeaderGetter::getNavMenuHtml($lang,'none');
    }

    public function getBody($params) {
        global $template_engine;
        $persistedAvasGetter = new PersistedAvasGetter();
        $persisted_avas_html_code = $persistedAvasGetter->generateAvasHtml();
        $template_engine->assign('persisted_avas',$persisted_avas_html_code);
        return $template_engine->fetch('gallery_expo_edit_body.tpl');

    }

    public function getLabelsArray($lang) {
        return  array();
    }



}

?>