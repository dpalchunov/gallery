<?php
require_once 'phplibs/ResourceService.php';
class  HomePageViewer extends Page
{

    function HomePageViewer() {
        parent::Page();
        global $js_scripts,$styles;
        $emp = $this ->emp;
        $js_scripts = array($emp."jquery.cycle2.min.js",'jplayer.cleanskin.js','photo.js','home.js');
        $styles = array('home.css','player.css','fullscreen_gallery.css','clear_player.css');
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

        $vid_man = new VideoObjManager();
        $videos = $vid_man->selectAllVideos();
        $template_engine->assign('videos', $videos);
        $template_engine->assign('video_count', sizeof($videos));
        $persistedIntrosGetter = new PersistedIntrosGetter();
        $introsHTML = $persistedIntrosGetter->generatePicsHtmlForView();
        $template_engine->assign('persisted_intros', $introsHTML);

        $localizator = new Localizator();
        $template_engine->assign('video_band_title_l', $localizator->getText($lang, 'video_band_title_l'));
        $template_engine->assign('see_all_video_part_label', $localizator->getText($lang, 'see_all_video_part_label'));

        $template_engine->assign('songs_band_title_l', $localizator->getText($lang, 'songs_band_title_l'));
        $template_engine->assign('see_all_songs_part_label', $localizator->getText($lang, 'see_all_songs_part_label'));

        $template_engine->assign('photo_band_title_l', $localizator->getText($lang, 'photo_band_title_l'));
        $template_engine->assign('see_all_photos_part_label', $localizator->getText($lang, 'see_all_photos_part_label'));


        return $template_engine->fetch('home_body.tpl');
    }

    public function getLabelsArray($lang) {
        $localizator = new Localizator();
        return  array('main_text_pre' => $localizator->getText($lang, 'about_main_text'),
                      'video_band_title_l' => $localizator->getText($lang, 'video_band_title_l'),
                      'songs_band_title_l' => $localizator->getText($lang, 'songs_band_title_l'),
                      'see_all_songs_part_label' => $localizator->getText($lang, 'see_all_songs_part_label'),
                      'photo_band_title_l' => $localizator->getText($lang, 'photo_band_title_l'),
                      'see_all_photos_part_label' => $localizator->getText($lang, 'see_all_photos_part_label'),
                      'see_all_video_part_label' => $localizator->getText($lang, 'see_all_video_part_label'));
    }
}

?>