<?php
require_once 'phplibs/ResourceService.php';
class  MusicPageViewer extends Page
{

    function MusicPageViewer() {
        parent::Page();
        global $js_scripts,$styles;
        $emp = $this ->emp;
        $js_scripts = array($emp."jquery.cycle2.min.js",'music.js');
        $styles = array('player.css','music.css');
    }

    public function getHeadContent() {
        global $template_engine;
        return $template_engine->fetch('music_head_content.tpl');
    }

    public function getHeader() {
        global  $resourceService;
        $lang = $resourceService -> getLang();
        return HeaderGetter::getHeaderHtml($lang,'music');
    }

    public function getNavMenu() {
        global  $resourceService;
        $lang = $resourceService -> getLang();
        return HeaderGetter::getNavMenuHtml($lang,'music');
    }

    public function getBody($params) {
        global $template_engine, $resourceService;
        $lang = $resourceService->getLang();
        $localizator = new Localizator();

        $template_engine->assign('lang', $lang);
        $songsHelper = new SongsObjManager();
        $songs = $songsHelper -> selectAllSongs();
        $template_engine->assign('songs', $songs);
        $template_engine->assign('count', sizeof($songs));
        return $template_engine->fetch('music_body.tpl');
    }

    public function getLabelsArray($lang) {
        $localizator = new Localizator();
        return  array('main_text_pre' => $localizator->getText($lang, 'about_main_text'));
    }
}

?>