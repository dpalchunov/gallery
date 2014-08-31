<?php   
  require_once 'phplibs/ResourceService.php';
  class  BuyPageViewer {
    private static $template_engine;
    private static $resourceService;    

    public  function __construct() {
      global $template_engine, $resourceService;
      $resourceService = new ResourceService();
      $template_engine = $resourceService->getTemplateEngine(); 
    }
    
    public function BuyContactsPage() {
        global $template_engine, $resourceService; 
        if ($_GET['change_lang'] == 1) {
          $resourceService -> changeLang();
          header( 'Location: buy.php' );          
        }
        $lang = $resourceService -> getLang();
        $localizator = new Localizator();
        $template_engine->assign('lang',$lang);          
        $template_engine->assign('change_lang',$localizator -> getText($lang, 'about_change_lang'));
        
        $template_engine->assign('buy_pic',$localizator -> getText($lang, 'buy_pic'));
        $template_engine->assign('buy_pic_price1',$localizator -> getText($lang, 'buy_pic_price1'));
        $template_engine->assign('buy_pic_price2',$localizator -> getText($lang, 'buy_pic_price2'));
        $template_engine->assign('buy_pic_price3',$localizator -> getText($lang, 'buy_pic_price3'));
        $template_engine->assign('buy_portret',$localizator -> getText($lang, 'buy_portret'));
        $template_engine->assign('buy_portret_price',$localizator -> getText($lang, 'buy_portret_price'));         
        
        $template_engine->display('buy.tpl');        
    }
  }
?>