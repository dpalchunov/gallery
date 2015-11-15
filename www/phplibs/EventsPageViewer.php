<?php
require_once 'phplibs/ResourceService.php';
class  EventsPageViewer extends Page
{

    function EventsPageViewer() {
        parent::Page();
        global $js_scripts,$styles;
        $emp = $this ->emp;
        $js_scripts = array('events.js',$emp."content-tools.min.js");
        $styles = array('events_style.css','../content_tools/content-tools.min.css');
    }

    public function getHeadContent() {
        global $template_engine;
        $persistedAvasGetter = new PersistedAvasGetter();
        $jsArrayHtml = $persistedAvasGetter->generateJsArrayHtml1();
        $template_engine->assign('avas', $jsArrayHtml);
        return $template_engine->fetch('events_head_content.tpl');
    }

    public function getHeader() {
        global  $resourceService;
        $lang = $resourceService -> getLang();
        return HeaderGetter::getHeaderHtml($lang,'events');
    }

    public function getNavMenu() {
        global  $resourceService;
        $lang = $resourceService -> getLang();
        return HeaderGetter::getNavMenuHtml($lang,'events');
    }

    public function getBody($params) {
        global $template_engine, $resourceService;
        $lang = $resourceService->getLang();
        $localizator = new Localizator();


        $man = new ContentObjManager();
        $obj = $man -> selectByID('events');
        $template_engine->assign('lang', $lang);
        $template_engine->assign('events_content', base64_decode($obj-> getValue()));

        return $template_engine->fetch('events_body.tpl');
    }

    public function getLabelsArray($lang) {
        $localizator = new Localizator();
        return  array('main_text_pre' => $localizator->getText($lang, 'about_main_text'));
    }



}

?>