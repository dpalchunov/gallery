<?php   
  require_once 'phplibs/ResourceService.php';
  class  BuyPageViewer extends Page {

      public function getHeader() {
          global  $resourceService;
          $lang = $resourceService -> getLang();
          return HeaderGetter::getHeaderHtml($lang,'buy');
      }

      public function getHead() {
          global $template_engine;
          return $template_engine->fetch('buy_head.tpl');
      }

    public function BuyContactsPage() {
        global $template_engine, $resourceService; 
        if ($_GET['change_lang'] == 1) {
          $resourceService -> changeLang();
          header( 'Location: buy.php' );          
        }
        $lang = $resourceService -> getLang();
        $localizator = new Localizator();

        $meta = HeaderGetter::getMeta();
        $template_engine->assign('meta', $meta);
        $template_engine->assign('lang',$lang);
        $template_engine->assign('buy_pic',$localizator -> getText($lang, 'buy_pic'));
        $template_engine->assign('buy_pic_price1',$localizator -> getText($lang, 'buy_pic_price1'));
        $template_engine->assign('buy_pic_price2',$localizator -> getText($lang, 'buy_pic_price2'));
        $template_engine->assign('buy_pic_price3',$localizator -> getText($lang, 'buy_pic_price3'));
        $template_engine->assign('buy_portret',$localizator -> getText($lang, 'buy_portret'));
        $template_engine->assign('buy_portret_price',$localizator -> getText($lang, 'buy_portret_price'));         
        
        return $template_engine->fetch('buy_body.tpl');
    }
  }
?>