<?php
require_once 'phplibs/ResourceService.php';
class  AboutPageEditor {
    private static $template_engine;
    private static $resourceService;

    public  function __construct() {
        global $template_engine, $resourceService;
        $resourceService = new ResourceService();
        $template_engine = $resourceService->getTemplateEngine();
    }

    public function  generateAvasHtml() {

        syslog(LOG_INFO, "Неавторизованный клиент:");
        $avasHtml = '';
        foreach(glob('./images/slider/avas/*.*') as $file) {
            $avasHtml = $avasHtml.
               "<div class=\"persisted\">
                <div class=\"image\" style=\"background-image: url({$file}); \"></div>
                <div class=\"persisted_img_controls controls\"><div class=\"remove\"><a href=\"\" > remove</a></div></div>
            </div>";
        }
        return  $avasHtml;
    }

    public function editAboutPage() {
        global $template_engine, $resourceService;
        if ($_GET['change_lang'] == 1) {
            $resourceService -> changeLang();
            header( 'Location: about_edit.php' );
        }
        $lang = $resourceService -> getLang();
        $template_engine->assign('lang',$lang);
        $persisted_avas_html_code = $this->generateAvasHtml();
        $template_engine->assign('persisted_avas',$persisted_avas_html_code);

        $template_engine->display('about_edit.tpl');
    }


}
?>










