
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


          if ($active_button == 'home') {
              $template_engine->assign('home_active','active');
          } else {
              $template_engine->assign('home_active','');
          }
          if ($active_button == 'band') {
              $template_engine->assign('band_active','active');
          } else {
              $template_engine->assign('band_active','');
          }
          if ($active_button == 'music') {
              $template_engine->assign('music_active','active');
          } else {
              $template_engine->assign('music_active','');
          }
          if ($active_button == 'video') {
              $template_engine->assign('video_active','active');
          } else {
              $template_engine->assign('video_active','');
          }
          if ($active_button == 'photo') {
              $template_engine->assign('photo_active','active');
          } else {
              $template_engine->assign('photo_active','');
          }
          if ($active_button == 'lyrics') {
              $template_engine->assign('lyrics_active','active');
          } else {
              $template_engine->assign('lyrics_active','');
          }
          if ($active_button == 'contact') {
              $template_engine->assign('contact_active','active');
          } else {
              $template_engine->assign('contact_active','');
          }


          $html = $template_engine-> fetch('nav_menu.tpl');
          return  $html;
      }

      public static function getLabelsArray($lang) {
          $localizator = new Localizator();
          return  array('home_href' => $localizator->getText($lang, 'home_label'),
                       'band_href' => $localizator->getText($lang, 'band_label'),
                       'music_href' => $localizator->getText($lang, 'music_label'),
                       'video_href' => $localizator->getText($lang, 'video_label'),
                       'photo_href' => $localizator->getText($lang, 'photo_label'),
                       'lyrics_href' => $localizator->getText($lang, 'lyrics_label'),
                       'contact_href' => $localizator->getText($lang, 'contact_label'),
                       'lang_changer_href' => $localizator->getText($lang, 'change_lang_label'));
      }

      public static function getMeta() {
        return '<meta http-equiv="Content-Type" content="text/html;charset=utf-8">';
      }
  }
?>