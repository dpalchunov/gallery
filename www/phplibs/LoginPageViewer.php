<?php
require_once 'phplibs/ResourceService.php';
class  LoginPageViewer extends Page
{

    function LoginPageViewer() {
        parent::Page();
        global $js_scripts,$styles;
        $js_scripts = array();
        $styles = array('login.css');
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

    public function getBody() {
        global $template_engine, $resourceService;
        $lang = $resourceService->getLang();
        $template_engine->assign('lang', $lang);
        return $template_engine->fetch('login_body.tpl');
    }

    public function getLabelsArray($lang) {
        return  array();
    }



}

?>