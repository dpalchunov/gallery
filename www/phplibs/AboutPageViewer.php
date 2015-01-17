<?php
require_once 'phplibs/ResourceService.php';
class  AboutPageViewer extends Page
{

    function AboutPageViewer() {
        parent::Page();
        global $js_scripts,$styles;
        $js_scripts = array('about.js');
        $styles = array('style.css');
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

    public function getBody() {
        global $template_engine, $resourceService;
        if ($_GET['change_lang'] == 1) {
            $resourceService->changeLang();
            header('Location: about.php');
        }
        $lang = $resourceService->getLang();
        $localizator = new Localizator();

        $template_engine->assign('lang', $lang);
        $template_engine->assign('main_text', $localizator->getText($lang, 'about_main_text'));
        if ($_COOKIE['greetingWasShown'] == 'true') {
            $template_engine->assign('greetingClass', ' class="display_none" ');
            $template_engine->assign('wrapper_class', ' class="inline_block" ');
        } else {
            $template_engine->assign('greetingClass', ' class="inline_block" ');
            $template_engine->assign('wrapper_class', ' class="display_none" ');
        }

        return $template_engine->fetch('about_body.tpl');
    }



}

?>