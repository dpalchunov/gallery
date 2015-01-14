<?php
require_once 'phplibs/ResourceService.php';
class  Page
{
    public function __construct()
    {
        global $template_engine, $resourceService;
        $resourceService = new ResourceService();
        $template_engine = $resourceService->getTemplateEngine();
    }

    public function showPage() {
        global $template_engine;
        $template_engine->assign('meta', $this -> getMeta());
        $template_engine->assign('head', $this -> getHead());
        $template_engine->assign('body', $this -> getBody());
        $template_engine->display('page.tpl');
    }

    public function getMeta() {
        global $template_engine;
        $meta = HeaderGetter::getMeta();
        $template_engine->assign('meta', $meta);
        return $template_engine->fetch('meta.tpl');
    }
}

?>