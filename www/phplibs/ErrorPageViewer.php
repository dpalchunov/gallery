<?php
require_once 'phplibs/ResourceService.php';
class  ErrorPageViewer extends Page
{

    function ErrorPageViewer() {
        parent::Page();
        global $js_scripts,$styles;
        $js_scripts = array('');
        $styles = array('error.css');
    }

    public function getHeadContent() {
        return "";
    }

    public function getHeader() {
        return "";
    }

    public function getNavMenu() {
        return "";
    }

    public function getBody($params) {
        global $template_engine;
        return $template_engine->fetch('error.tpl');
    }

    public function getLabelsArray($lang) {
        return  array();
    }



}

?>