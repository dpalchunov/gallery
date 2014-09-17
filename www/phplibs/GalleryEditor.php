<?php
require_once 'phplibs/ResourceService.php';
class  GalleryEditor {
    private static $template_engine;
    private static $resourceService;

    public  function __construct() {
        global $template_engine, $resourceService;
        $resourceService = new ResourceService();
        $template_engine = $resourceService->getTemplateEngine();
    }

    public function editGallery() {
        global $template_engine, $resourceService;

        $galleryEditHtmlGetter = new GalleryEditHtmlGetter();
        $gallery_edit_html_code = $galleryEditHtmlGetter -> getHTMLCode();
        $template_engine->assign('gallery',$gallery_edit_html_code);
        $template_engine->display('gallery_edit.tpl');
    }
}
?>