<?php
require_once 'phplibs/ResourceService.php';
class  ErrorPageViewer404 extends Page
{

    function ErrorPageViewer404() {
        parent::Page();
        global $js_scripts,$styles;
        $js_scripts = array('');
        $styles = array('error404.css');
    }

    public function getHeadContent() {
        return "";
    }


    public function getHeader() {
        global  $resourceService;
        $lang = $resourceService -> getLang();
        return HeaderGetter::getHeaderHtml($lang,'');
    }

    public function getNavMenu() {
        global  $resourceService;
        $lang = $resourceService -> getLang();
        return HeaderGetter::getNavMenuHtml($lang,'');
    }

    public function getBody($params) {
        global $template_engine;
        return $template_engine->fetch('error404.tpl');
    }

    public function getLabelsArray($lang) {
        return  array();
    }



}

?>