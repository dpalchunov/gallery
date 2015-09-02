<?php
require_once 'phplibs/ResourceService.php';
class  VideoPageViewer extends Page
{

    function VideoPageViewer() {
        parent::Page();
        global $js_scripts,$styles;
        $emp = $this ->emp;
        $js_scripts = array($emp."jquery.cycle2.min.js",'jplayer.cleanskin.js','video.js');
        $styles = array('video.css','clear_player.css');
    }

    public function getHeadContent() {
        global $template_engine;
        return $template_engine->fetch('video_head_content.tpl');
    }

    public function getHeader() {
        global  $resourceService;
        $lang = $resourceService -> getLang();
        return HeaderGetter::getHeaderHtml($lang,'video');
    }

    public function getNavMenu() {
        global  $resourceService;
        $lang = $resourceService -> getLang();
        return HeaderGetter::getNavMenuHtml($lang,'video');
    }

    public function getBody($params) {
        global $template_engine, $resourceService;
        $lang = $resourceService->getLang();
        $localizator = new Localizator();
        $vid_man = new VideoObjManager();
        $videos = $vid_man->selectAllVideos();
        $template_engine->assign('videos', $videos);
        $template_engine->assign('count', sizeof($videos));
        $template_engine->assign('lang', $lang);
        $template_engine->assign('video_band_title_l', $localizator->getText($lang, 'video_band_title_l'));

        return $template_engine->fetch('video_body.tpl');
    }

    public function getLabelsArray($lang) {
        $localizator = new Localizator();
        $vh = new VideoHelper($lang);
        return  array_merge(array(
                'video_band_title_l' => $localizator->getText($lang, 'video_band_title_l')),
            $vh -> getLabelsArray($lang));
    }

}

?>