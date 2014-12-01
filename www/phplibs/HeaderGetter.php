
<?php   
  require_once 'phplibs/ResourceService.php';

  class  HeaderGetter {

      public function __construct()
      {
      }

      public static function getHeaderHtml($lang,$active_button) {
          $resourceService = new ResourceService();
          $template_engine = $resourceService->getTemplateEngine();
          $localizator = new Localizator();

          $template_engine->assign('change_lang',$localizator -> getText($lang, 'change_lang_label'));

          $template_engine->assign('about', $localizator->getText($lang, 'about_label'));
          $template_engine->assign('gallery',$localizator->getText($lang, 'gallery_label'));
          $template_engine->assign('contacts',$localizator->getText($lang, 'contacts_label'));
          $template_engine->assign('buy',$localizator->getText($lang, 'order_label'));
          if ($active_button == 'about') {
              $template_engine->assign('about_active','active');
          } else {
              $template_engine->assign('about_active','');
          }
          if ($active_button == 'gallery') {
              $template_engine->assign('gallery_active','active');
          } else {
              $template_engine->assign('gallery_active','');
          }
          if ($active_button == 'contacts') {
              $template_engine->assign('contacts_active','active');
          } else {
              $template_engine->assign('contacts_active','');
          }
          if ($active_button == 'buy') {
              $template_engine->assign('buy_active','active');
          } else {
              $template_engine->assign('buy_active','');
          }

          $headerHtml = $template_engine-> display('header.tpl') ;
          return  $headerHtml;
      }

      public static function getMeta() {
        return '<meta http-equiv="Content-Type" content="text/html;charset=utf-8">';
      }
  }
?>