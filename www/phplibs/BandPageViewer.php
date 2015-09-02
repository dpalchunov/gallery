<?php
require_once 'phplibs/ResourceService.php';
class  BandPageViewer extends Page
{

    function BandPageViewer() {
        parent::Page();
        global $js_scripts,$styles;
        $emp = $this ->emp;
        $js_scripts = array($emp."jquery.cycle2.min.js",'band.js');
        $styles = array('band.css');
    }

    public function getHeadContent() {
        global $template_engine;
        return $template_engine->fetch('band_head_content.tpl');
    }

    public function getHeader() {
        global  $resourceService;
        $lang = $resourceService -> getLang();
        return HeaderGetter::getHeaderHtml($lang,'band');
    }

    public function getNavMenu() {
        global  $resourceService;
        $lang = $resourceService -> getLang();
        return HeaderGetter::getNavMenuHtml($lang,'band');
    }

    public function getBody($params) {
        global $template_engine, $resourceService;
        $lang = $resourceService->getLang();
        $localizator = new Localizator();

        $template_engine->assign('lang', $lang);
        $template_engine->assign('band_about_denis', $localizator->getText($lang, 'band_about_denis'));
        $template_engine->assign('band_about_anton', $localizator->getText($lang, 'band_about_anton'));
        return $template_engine->fetch('band_body.tpl');
    }

    public function getLabelsArray($lang) {
        $localizator = new Localizator();
        return  array('band_about_denis' => $localizator->getText($lang, 'band_about_denis'),
                      'band_about_anton' => $localizator->getText($lang, 'band_about_anton'));
    }
}

?>