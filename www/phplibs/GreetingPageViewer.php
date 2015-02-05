<?php
require_once 'phplibs/ResourceService.php';
class  GreetingPageViewer extends Page
{

    function GreetingPageViewer() {
        parent::Page();
        global $js_scripts,$styles;
        $js_scripts = array("wellcome.js");
        $styles = array("greeting_style.css");
    }

    public function getHeadContent() {
        return '';
    }

    public function getHeader() {
        global  $resourceService;
        $lang = $resourceService -> getLang();
        return HeaderGetter::getHeaderHtml($lang,'about');
    }

    public function getNavMenu() {
        global  $resourceService;
        $lang = $resourceService -> getLang();
        return HeaderGetter::getNavMenuHtml($lang,'about');
    }

    public function getBody() {
        global $template_engine;
        return $template_engine->fetch('greeting_body.tpl');
    }

    public function getLabelsArray($lang) {
        return  array();
    }



}

?>