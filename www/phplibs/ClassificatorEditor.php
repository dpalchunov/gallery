<?php
require_once 'phplibs/ResourceService.php';
class  ClassificatorEditor
{
    private static $template_engine;
    private static $resourceService;

    public function __construct()
    {
        global $template_engine, $resourceService;
        $resourceService = new ResourceService();
        $template_engine = $resourceService->getTemplateEngine();
    }

    public function editClassificator()
    {
        global $template_engine, $resourceService;

        $ClassificatorEditHtmlGetter = new ClassificatorEditHtmlGetter();
        $classificator_edit_html_code = $ClassificatorEditHtmlGetter->getHTMLCode();
        $template_engine->assign('classificator', $classificator_edit_html_code);
        $template_engine->display('classificator_edit.tpl');
    }
}

?>