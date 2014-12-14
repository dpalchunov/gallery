
<?php   
  require_once 'phplibs/ResourceService.php';

  class  HeaderGetter {

      public function __construct()
      {
      }

      public static function getHeaderHtml() {
          $resourceService = new ResourceService();
          $template_engine = $resourceService->getTemplateEngine();

          $headerHtml = $template_engine-> fetch('header.tpl');
          return  $headerHtml;
      }

      public static function getMeta() {
        return '<meta http-equiv="Content-Type" content="text/html;charset=utf-8">';
      }
  }
?>