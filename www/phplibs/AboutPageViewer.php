<?php   
  require_once 'phplibs/ResourceService.php';
  class  AboutPageViewer {
    private static $template_engine;
    private static $resourceService;    

    public  function __construct() {
      global $template_engine, $resourceService;
      $resourceService = new ResourceService();
      $template_engine = $resourceService->getTemplateEngine(); 
    }
    
    public function showAboutPage() {
        global $template_engine, $resourceService; 
        if ($_GET['change_lang'] == 1) {
          $resourceService -> changeLang();
          header( 'Location: about.php' );          
        }
        $lang = $resourceService -> getLang();
        $localizator = new Localizator();
        $template_engine->assign('lang',$lang);          
        $template_engine->assign('main_text',$localizator -> getText( $lang, 'about_main_text'));
        $template_engine->assign('change_lang',$localizator -> getText($lang, 'about_change_lang'));        
        if ($_COOKIE['greetingWasShown'] == 'true') {
          $template_engine->assign('greetingClass',' class=display_none ');            
        } else {
          $template_engine->assign('greetingClass',' ');             
        }
        $template_engine->display('about.tpl');        
    }
  }
?>