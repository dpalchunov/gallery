<?php   
  require_once 'phplibs/ResourceService.php';
  class  GalleryViewer {
    private static $template_engine;
    private static $resourceService;    

    public  function __construct() {
      global $template_engine, $resourceService;
      $resourceService = new ResourceService();
      $template_engine = $resourceService->getTemplateEngine(); 
    }
    
    public function showGallary() {
        global $template_engine, $resourceService; 
        if ($_GET['change_lang'] == 1) {
          $resourceService -> changeLang();
          header( 'Location: gallery.php' );          
        }
        $lang = $resourceService -> getLang();    
        $localizator = new Localizator();
     
      
        $classificatorsGetter = new ClassificatorsGetter($lang);
        $classifiactors_html_code = $classificatorsGetter -> getHTMLCode();
        $template_engine->assign('classificators',$classifiactors_html_code);
        $template_engine->assign('lang',$lang);
        $template_engine->assign('no_results',$localizator -> getText($lang, 'no_results'));         
        $template_engine->assign('change_lang',$localizator -> getText($lang, 'about_change_lang'));           
        $template_engine->display('gallery.tpl');        
    }
  }
?>