<?php
require_once 'phplibs/ResourceService.php';
class  AboutPageViewer extends Page
{

    function AboutPageViewer() {
        parent::Page();
        global $js_scripts,$styles;
        $emp = $this ->emp;
        $js_scripts = array($emp."jquery.cycle2.min.js",'about.js');
        $styles = array('about_style.css');
    }

    public function getHeadContent() {
        global $template_engine;
        $persistedAvasGetter = new PersistedAvasGetter();
        $jsArrayHtml = $persistedAvasGetter->generateJsArrayHtml1();
        $template_engine->assign('avas', $jsArrayHtml);
        return $template_engine->fetch('about_head_content.tpl');
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

    public function getBody($params) {
        global $template_engine, $resourceService;
        $lang = $resourceService->getLang();
        $localizator = new Localizator();

        $template_engine->assign('lang', $lang);

        $persistedIntrosGetter = new PersistedIntrosGetter();
        $introsHTML = $persistedIntrosGetter->generatePicsHtmlForView();
        $template_engine->assign('persisted_intros', $introsHTML);
        $template_engine->assign('main_text', $localizator->getText($lang, 'about_main_text'));
        $player = $template_engine -> fetch('player_mini.tpl');
        $template_engine->assign('player_mini',$player);

        return $template_engine->fetch('about_body.tpl');
    }

    public function getLabelsArray($lang) {
        $localizator = new Localizator();
        return  array('main_text_pre' => $localizator->getText($lang, 'about_main_text'));
    }



}

?>