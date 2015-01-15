<?php   
  require_once 'phplibs/ResourceService.php';
  class  GalleryViewer extends Page {

    public function getHead() {
        global $template_engine;
        return $template_engine->fetch('gallery_head.tpl');

    }

    public function getHeader() {
        global  $resourceService;
        $lang = $resourceService -> getLang();
        return HeaderGetter::getHeaderHtml($lang,'gallery');
    }

    public function getBody() {
        global $template_engine, $resourceService;
        if (isset($_GET['change_lang']) && $_GET['change_lang'] == 1) {
            $resourceService -> changeLang();
            header( 'Location: gallery.php' );
        }
        $lang = $resourceService -> getLang();
        $localizator = new Localizator();

        $template_engine->assign('lang',$lang);
        $template_engine->assign('no_results',$localizator -> getText($lang, 'no_results'));
        return $template_engine->fetch('gallery_body.tpl');
    }
  }
?>