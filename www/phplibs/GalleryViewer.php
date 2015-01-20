<?php   
  require_once 'phplibs/ResourceService.php';


  class  GalleryViewer extends Page {

    function GalleryViewer() {
        parent::Page();
        global $js_scripts,$styles;
        $js_scripts = array('gallery.js');
        $styles = array('gallary_style.css');

    }


      public function getHeadContent() {
          global $template_engine;
          return $template_engine->fetch('gallery_head_content.tpl');
      }


      public function getHeader() {
          global  $resourceService;
          $lang = $resourceService -> getLang();
          return HeaderGetter::getHeaderHtml($lang,'gallery');
      }

      public function getNavMenu() {
          global  $resourceService;
          $lang = $resourceService -> getLang();
          return HeaderGetter::getNavMenuHtml($lang,'gallery');
      }



      public function getBody() {
          global $template_engine;
          $res =  $template_engine->fetch('gallery_body.tpl');
          return $res;
      }
  }
?>