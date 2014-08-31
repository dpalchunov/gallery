<?php   
  require_once 'phplibs/ResourceService.php';
  class  EditPageViewer {
    private static $template_engine;
    private static $resourceService;    

    public  function __construct() {
      global $template_engine, $resourceService;
      $resourceService = new ResourceService();
      $template_engine = $resourceService->getTemplateEngine(); 
    }
    
    public function showEditPage() {
        global $template_engine, $resourceService; 
        if ($_GET['change_lang'] == 1) {
          $resourceService -> changeLang();
          header( 'Location: edit.php' );          
        }
        $lang = $resourceService -> getLang();
        $localizator = new Localizator();
        $template_engine->assign('lang',$lang);          
        $template_engine->assign('main_text',$localizator -> getText( $lang, 'about_main_text'));
        $template_engine->assign('change_lang',$localizator -> getText($lang, 'about_change_lang'));        
        $template_engine->display('edit.tpl');        
    }
  }
?>