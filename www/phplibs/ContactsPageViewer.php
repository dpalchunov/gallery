<?php   
  require_once 'phplibs/ResourceService.php';
  class  ContactsPageViewer {
    private static $template_engine;
    private static $resourceService;    

    public  function __construct() {
      global $template_engine, $resourceService;
      $resourceService = new ResourceService();
      $template_engine = $resourceService->getTemplateEngine(); 
    }
    
    public function showContactsPage() {
        global $template_engine, $resourceService; 
        if ($_GET['change_lang'] == 1) {
          $resourceService -> changeLang();
          header( 'Location: contacts.php' );          
        }
        $lang = $resourceService -> getLang();
        $localizator = new Localizator();

        $headerGetter = HeaderGetter::getHeaderHtml($lang,'contacts');
        $meta = HeaderGetter::getMeta();
        $template_engine->assign('meta', $meta);
        $template_engine->assign('header', $headerGetter);

        $template_engine->assign('lang',$lang);

        $template_engine->assign('contacts_call_comment',$localizator -> getText($lang, 'contacts_call_comment'));
        $template_engine->assign('contacts_mail_comment',$localizator -> getText($lang, 'contacts_mail_comment'));
        $template_engine->assign('contacts_skype_comment',$localizator -> getText($lang, 'contacts_skype_comment'));
        $template_engine->assign('contacts_main_phrase',$localizator -> getText($lang, 'contacts_main_phrase'));         
        
        $template_engine->display('contacts.tpl');        
    }
  }
?>