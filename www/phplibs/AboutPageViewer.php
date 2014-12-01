<?php
require_once 'phplibs/ResourceService.php';
class  AboutPageViewer
{
    private static $template_engine;
    private static $resourceService;

    public function __construct()
    {
        global $template_engine, $resourceService;
        $resourceService = new ResourceService();
        $template_engine = $resourceService->getTemplateEngine();
    }

    public function showAboutPage()
    {
        global $template_engine, $resourceService;
        if ($_GET['change_lang'] == 1) {
            $resourceService->changeLang();
            header('Location: about.php');
        }
        $lang = $resourceService->getLang();
        $localizator = new Localizator();
        $persistedAvasGetter = new PersistedAvasGetter();
        $jsArrayHtml = $persistedAvasGetter->generateJsArrayHtml1();
        $headerGetter = HeaderGetter::getHeaderHtml($lang,'about');
        $meta = HeaderGetter::getMeta();
        $template_engine->assign('meta', $meta);
        $template_engine->assign('header', $headerGetter);

        $template_engine->assign('avas', $jsArrayHtml);
        $template_engine->assign('lang', $lang);
        $template_engine->assign('main_text', $localizator->getText($lang, 'about_main_text'));
        if ($_COOKIE['greetingWasShown'] == 'true') {
            $template_engine->assign('greetingClass', ' class="display_none" ');
            $template_engine->assign('wrapper_class', ' class="inline_block" ');
        } else {
            $template_engine->assign('greetingClass', ' class="inline_block" ');
            $template_engine->assign('wrapper_class', ' class="display_none" ');
        }

        $template_engine->display('about.tpl');
    }
}

?>