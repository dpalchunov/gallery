<?php
require_once 'phplibs/ResourceService.php';
class  AboutEditPageViewer extends Page
{

    function AboutEditPageViewer() {
        parent::Page();
        global $js_scripts,$styles;
        $js_scripts = array('gallery_edit.js','cropper.js','jquery.uploadfile.js');
        $styles = array('uploadfile.css','about_edit_style.css');
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
        return $template_engine->fetch('about_edit_body.tpl');

    }

    public function getLabelsArray($lang) {
        return  array();
    }



}

?>