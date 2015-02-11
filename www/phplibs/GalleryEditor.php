<?php
require_once 'phplibs/ResourceService.php';
class  GalleryEditor
{
    public function __construct()
    {
        global $template_engine, $resourceService;
        $resourceService = new ResourceService();
        $template_engine = $resourceService->getTemplateEngine();
    }

    public function editGallery($page)
    {
        global $template_engine;

        $galleryEditHtmlGetter = new GalleryEditHtmlGetter();
        $gallery_edit_html_code = $galleryEditHtmlGetter->getHTMLCode($page);
        $pagination = $galleryEditHtmlGetter->getPaginationHtml($page);
        $template_engine->assign('pagination', $pagination);
        $template_engine->assign('gallery', $gallery_edit_html_code);
        $template_engine->display('gallery_edit.tpl');
    }


}

?>