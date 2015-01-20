
<?php   
  require_once 'phplibs/ResourceService.php';

  class  aHeaderGetter {

      public function __construct()
      {
      }

      public static function getHeaderHtml() {
          $resourceService = new ResourceService();
          $template_engine = $resourceService->getTemplateEngine();
          $nav = aHeaderGetter:: getNavMenuHtml();
          $template_engine-> assign('nav_menu',$nav);
          $headerHtml = $template_engine-> fetch('header.tpl');
          return  $headerHtml;
      }

      public static function getNavMenuHtml() {
          $resourceService = new ResourceService();
          $template_engine = $resourceService->getTemplateEngine();

          $html = $template_engine-> fetch('nav_menu.tpl');
          return  $html;
      }

      public static function getMeta() {
        return '<meta http-equiv="Content-Type" content="text/html;charset=utf-8">';
      }
  }
?>