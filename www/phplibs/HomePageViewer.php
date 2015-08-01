<?php
require_once 'phplibs/ResourceService.php';
class  HomePageViewer extends Page
{

    function HomePageViewer() {
        parent::Page();
        global $js_scripts,$styles;
        $emp = $this ->emp;
        $js_scripts = array($emp."jquery.cycle2.min.js",'home.js');
        $styles = array('home.css','player.css');
    }

    public function getHeadContent() {
        global $template_engine;
        return $template_engine->fetch('home_head_content.tpl');
    }

    public function getHeader() {
        global  $resourceService;
        $lang = $resourceService -> getLang();
        return HeaderGetter::getHeaderHtml($lang,'home');
    }

    public function getNavMenu() {
        global  $resourceService;
        $lang = $resourceService -> getLang();
        return HeaderGetter::getNavMenuHtml($lang,'home');
    }

    public function getBody($params) {
        global $template_engine, $resourceService;
        $lang = $resourceService->getLang();

        $template_engine->assign('lang', $lang);

        $pic_man = new PictureObjManager();
        $pics = $pic_man->selectAllPics();
        $template_engine->assign('photos', $pics);
        $template_engine->assign('pic_count', sizeof($pics));


        $songsHelper = new SongsObjManager();
        $songs = $songsHelper -> selectAllSongs();
        $template_engine->assign('songs', $songs);
        $template_engine->assign('count', sizeof($songs));
        return $template_engine->fetch('home_body.tpl');
    }

    public function getLabelsArray($lang) {
        $localizator = new Localizator();
        return  array('main_text_pre' => $localizator->getText($lang, 'about_main_text'));
    }
}

?>