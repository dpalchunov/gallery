<?php
require_once 'phplibs/ResourceService.php';
class  GalleryEditPageViewer extends Page
{

    function GalleryEditPageViewer() {
        parent::Page();
        global $js_scripts,$styles,$emp;
        $emp = $this ->emp;
        $js_scripts = array($emp.'cropper.min.js',$emp.'jquery.uploadfile.min.js','gallery_edit.js');
        $styles = array('uploadfile.css','cropper.css','gallery_edit_style.css');
    }

    public function getHeadContent() {
        return '';
    }

    public function getHeader() {
        global  $resourceService;
        $lang = $resourceService -> getLang();
        return HeaderGetter::getHeaderHtml($lang,'none');
    }

    public function getNavMenu() {
        global  $resourceService;
        $lang = $resourceService -> getLang();
        return HeaderGetter::getNavMenuHtml($lang,'none');
    }

    public function getBody($params) {
        global $template_engine;
        if (isset($_POST['page'])) {
            $page = $_POST['page'];
        } else {
            $page = 1;
        }
        $galleryEditHtmlGetter = new GalleryHelper();
        $gallery_edit_html_code = $galleryEditHtmlGetter->getGalleryEditHTMLCode($page);
        $pagination = $galleryEditHtmlGetter->getPaginationHtml($page);
        $template_engine->assign('pagination', $pagination);
        $template_engine->assign('gallery', $gallery_edit_html_code);
        return $template_engine->fetch('gallery_edit_body.tpl');

    }

    public function getLabelsArray($lang) {
        return  array();
    }



}

?>