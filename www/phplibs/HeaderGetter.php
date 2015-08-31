
<?php   
  require_once 'phplibs/ResourceService.php';

  class  HeaderGetter {

      public function __construct()
      {
      }

      public static function getHeaderHtml($lang,$active_button) {
          $localizator = new Localizator();
          $resourceService = new ResourceService();
          $template_engine = $resourceService->getTemplateEngine();
          $nav = HeaderGetter:: getNavMenuHtml($lang,$active_button);
          $template_engine-> assign('nav_menu',$nav);
          $template_engine-> assign('change_lang',$localizator -> getText($lang, 'change_lang_label'));
          $headerHtml = $template_engine-> fetch('header.tpl') ;
          return  $headerHtml;
      }


      public static function getNavMenuHtml($lang,$active_button) {
          $resourceService = new ResourceService();
          $template_engine = $resourceService->getTemplateEngine();
          $localizator = new Localizator();

          $template_engine->assign('home', $localizator->getText($lang, 'home_label'));
          $template_engine->assign('band', $localizator->getText($lang, 'band_label'));
          $template_engine->assign('music', $localizator->getText($lang, 'music_label'));
          $template_engine->assign('video', $localizator->getText($lang, 'video_label'));
          $template_engine->assign('photo', $localizator->getText($lang, 'photo_label'));
          $template_engine->assign('lyrics', $localizator->getText($lang, 'lyrics_label'));
          $template_engine->assign('contact', $localizator->getText($lang, 'contact_label'));

          $html = $template_engine-> fetch('nav_menu.tpl');
          return  $html;
      }

      public static function getLabelsArray($lang) {
          $localizator = new Localizator();
          return  array('about_href' => $localizator->getText($lang, 'about_label'),
                       'gallery_href' => $localizator->getText($lang, 'gallery_label'),
                       'buy_href' => $localizator->getText($lang, 'contacts_label'),
                       'lang_changer_href' => $localizator->getText($lang, 'change_lang_label'));
      }

      public static function getMeta() {
        return '<meta http-equiv="Content-Type" content="text/html;charset=utf-8">';
      }
  }
?>