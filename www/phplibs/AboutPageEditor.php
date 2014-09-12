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
        $template_engine->assign('lang',$lang);
        $persistedAvasGetter = new PersistedAvasGetter();
        $persisted_avas_html_code = $persistedAvasGetter->generateAvasHtml();
        $template_engine->assign('persisted_avas',$persisted_avas_html_code);

        $template_engine->display('about_edit.tpl');
    }


}
?>










