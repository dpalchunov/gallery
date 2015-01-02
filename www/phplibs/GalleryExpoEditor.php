<?php   
  require_once 'phplibs/ResourceService.php';
  class  GalleryExpoEditor {
    private static $template_engine;
    private static $resourceService;    

    public  function __construct() {
      global $template_engine, $resourceService;
      $resourceService = new ResourceService();
      $template_engine = $resourceService->getTemplateEngine(); 
    }
    
    public function editExposition() {
        global $template_engine, $resourceService; 
        if (isset($_GET['change_lang']) && $_GET['change_lang'] == 1) {
          $resourceService -> changeLang();
          header( 'Location: gallery.php' );          
        }
        $lang = $resourceService -> getLang();    
        $localizator = new Localizator();
        $headerGetter = HeaderGetter::getHeaderHtml($lang,'');
        $meta = HeaderGetter::getMeta();

        $classificatorsGetter = new ClassificatorsGetter($lang);
        $classifiactors_html_code = $classificatorsGetter -> getHTMLCode();
        $template_engine->assign('classificators',$classifiactors_html_code);
        $template_engine->assign('meta', $meta);
        $template_engine->assign('header', $headerGetter);
        $template_engine->assign('lang',$lang);
        $template_engine->assign('no_results',$localizator -> getText($lang, 'no_results'));
        $template_engine->display('gallery_expo_edit.tpl');
    }
  }
?>