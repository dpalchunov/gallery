<?php
require_once 'phplibs/ResourceService.php';
class  SongsEditPageViewer extends Page
{

    function SongsEditPageViewer() {
        parent::Page();
        global $js_scripts,$styles,$emp;
        $emp = $this ->emp;
        $js_scripts = array($emp.'jquery.uploadfile.min.js','songs_edit.js');
        $styles = array('uploadfile.css','songs_edit_style.css');
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
        $songsEditHtmlGetter = new SongsEditHtmlGetter();
        $songs_edit_html_code = $songsEditHtmlGetter->getHTMLCode($page);
        $pagination = $songsEditHtmlGetter->getPaginationHtml($page);
        $template_engine->assign('pagination', $pagination);
        $template_engine->assign('songs', $songs_edit_html_code);
        return $template_engine->fetch('songs_edit_body.tpl');

    }

    public function getLabelsArray($lang) {
        return  array();
    }



}

?>