<?php   
  require_once 'phplibs/ResourceService.php';
  class  GallaryViewer {
    private static $template_engine;

    public  function __construct() {
      global $template_engine;
      $resourceService = new ResourceService();
      $template_engine = $resourceService->getTemplateEngine(); 
    }
    
    public showGallary() {
        global $template_engine; 
        $classificatorsGetter = new ClassificatorsGetter();
        $classifiactors_html_code = $classificatorsGetter -> getHTMLCode();
        $template_engine->assign('classificators',$classifiactors_html_code);
        $template_engine->display('gallery.tpl');        
    }
  }
?>