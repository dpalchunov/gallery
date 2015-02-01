<?php   
  require_once 'phplibs/ResourceService.php';
  class  ContactsPageViewer extends Page {

      function ContactsPageViewer() {
          parent::Page();
          global $js_scripts,$styles;
          //$js_scripts = array('skype_check.js');
          $js_scripts = array();
          $styles = array('contacts_style.css');
      }

      public function getHeadContent() {
          global $template_engine;
          return $template_engine->fetch('contacts_head_content.tpl');
      }

      public function getHeader() {
          global  $resourceService;
          $lang = $resourceService -> getLang();
          return HeaderGetter::getHeaderHtml($lang,'contacts');
      }

      public function getNavMenu() {
          global  $resourceService;
          $lang = $resourceService -> getLang();
          return HeaderGetter::getNavMenuHtml($lang,'contacts');
      }

      public function getBody() {
          global $template_engine,$resourceService;
          $localizator = new Localizator();
          $lang = $resourceService -> getLang();
          $template_engine->assign('contacts_call_comment',$localizator -> getText($lang, 'contacts_call_comment'));
          $template_engine->assign('contacts_mail_comment',$localizator -> getText($lang, 'contacts_mail_comment'));
          $template_engine->assign('contacts_skype_comment',$localizator -> getText($lang, 'contacts_skype_comment'));
          $template_engine->assign('contacts_main_phrase',$localizator -> getText($lang, 'contacts_main_phrase'));
          $res =  $template_engine->fetch('contacts_body.tpl');
          return $res;
      }


      public function getLabelsArray($lang) {
          $localizator = new Localizator();
          return  array('contacts_main_phrase' => $localizator -> getText($lang, 'contacts_call_comment'),
              'contacts_mail_comment' => $localizator -> getText($lang, 'contacts_mail_comment'),
              'contacts_skype_comment' => $localizator -> getText($lang, 'contacts_skype_comment'),
              'contacts_call_comment' => $localizator -> getText($lang, 'contacts_call_comment'));
      }
  }
?>