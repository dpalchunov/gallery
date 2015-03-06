<?php
require_once 'phplibs/ResourceService.php';
require_once 'phplibs/PersistedAvasGetter.php';
class  AboutPageEditor {
    private static $template_engine;
    private static $resourceService;

    public  function __construct() {
        global $template_engine, $resourceService;
        $resourceService = new ResourceService();
        $template_engine = $resourceService->getTemplateEngine();
    }

    public function editAboutPage() {
        global $template_engine, $resourceService;
        if ($_GET['change_lang'] == 1) {
            $resourceService -> changeLang();
            header( 'Location: about_edit.php' );
        }
        $lang = $resourceService -> getLang();
        $headerGetter = HeaderGetter::getHeaderHtml($lang,'about_edit');
        $template_engine-> fetch('header.tpl');
        $meta = HeaderGetter::getMeta();
        $template_engine->assign('meta', $meta);
        $template_engine->assign('header', $headerGetter);
        $template_engine->assign('lang',$lang);
        $persistedAvasGetter = new PersistedAvasGetter();
        $persisted_avas_html_code = $persistedAvasGetter->generatePicsHtmlForEdit();
        $template_engine->assign('persisted_avas',$persisted_avas_html_code);

        $template_engine->display('about_edit.tpl');
    }


}
?>










