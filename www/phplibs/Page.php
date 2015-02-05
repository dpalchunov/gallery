<?php
require_once 'phplibs/ResourceService.php';
abstract class  Page
{

    public function Page()
    {
        global $template_engine, $resourceService,$js_common_scripts,$common_styles;
        $resourceService = new ResourceService();
        $template_engine = $resourceService->getTemplateEngine();
        $js_common_scripts = array('jquery.js','jquery-ui.js','jquery.cookie.js','header.js','jquery.jplayer.min.js','player.js');
        $common_styles = array('nav_menu.css','header.css','jquery-ui.css','general.css');
    }

    abstract function getHeadContent();
    abstract function getHeader();
    abstract function getNavMenu();
    abstract function getBody();
    abstract function getLabelsArray($label);


    public function getHeaderLabels() {
        global  $resourceService;
        $lang = $resourceService -> getLang();
        return array_merge(HeaderGetter::getLabelsArray($lang),$this -> getLabelsArray($lang));
    }

    public function getHead() {
        global $template_engine;
        $css =  $this ->getStyles();
        $common_css = $this ->getCommonStyles();
        $scripts =  $this -> getAllScripts();
        $content = $this -> getHeadContent();
        $template_engine->assign('styles', $css);
        $template_engine->assign('common_styles', $common_css);
        $template_engine->assign('scripts', $scripts);
        $template_engine->assign('content', $content);
        return $template_engine->fetch('head.tpl');
    }

    public function getHeadContentAndStyles() {
        return $this -> getHeadContent() . $this -> getAllStyles();
    }
    public function getHeadContentAndHeaderStyle() {
        return $this -> getHeadContent() . $this -> getStylesByArray(array('header.css'));
    }



    public function showPage() {
        global $template_engine;
        $template_engine->assign('meta', $this -> getMeta());
        $template_engine->assign('head', $this -> getHead());
        $template_engine->assign('header', $this -> getPlayer());
        $template_engine->assign('header', $this -> getHeader());
        $template_engine->assign('body', $this -> getBody());
        $template_engine->display('page.tpl');
    }

    public function getPlayer() {
        global $template_engine;
        $player = $template_engine -> fetch('player.tpl');
        $template_engine->assign('player',$player);
    }

    public function getMeta() {
        global $template_engine;
        $meta = HeaderGetter::getMeta();
        $template_engine->assign('meta', $meta);
        return $template_engine->fetch('meta.tpl');
    }

    public function getCommonStyles() {
        global $template_engine,$common_styles;
        $template_engine->assign('styles', $common_styles);
        $template_engine->assign('count', sizeof($common_styles));
        $template_engine->assign('class', 'common_style');
        $res =  $template_engine->fetch('styles.tpl');
        return $res;
    }

    public function getCommonScripts() {
        global $template_engine,$js_common_scripts;
        $template_engine->assign('js_scripts', $js_common_scripts);
        $template_engine->assign('count', sizeof($js_common_scripts));
        $res =  $template_engine->fetch('scripts.tpl');
        return $res;
    }

    public function show($post) {

        $result = '';
        if (isset($post['part'])) {
            if ($post['part'] == 'body') {
                $result = $this -> getBody();
            } elseif ($post['part'] == 'head') {
                $result = $this -> getHead();
            } elseif ($post['part'] == 'head_content') {
                $result = $this -> getHeadContent();
            } elseif ($post['part'] == 'head_content_and_styles') {
                $result = $this -> getHeadContentAndStyles();
            } elseif ($post['part'] == 'head_content_and_header_style') {
                $result = $this -> getHeadContentAndHeaderStyle();
            } elseif ($post['part'] == 'header') {
                $result = $this -> getHeader();
            } elseif ($post['part'] == 'nav_menu') {
                $result = $this -> getNavMenu();
            } elseif ($post['part'] == 'scripts') {
                $result = json_encode($this -> getScriptsArray());
            } elseif ($post['part'] == 'page_styles') {
                $result = json_encode($this -> getPecuilarStylesArray() );
            } elseif ($post['part'] == 'header_labels') {
                $result = json_encode($this -> getHeaderLabels());
            }

            echo $result;
        } else {
            $this -> showPage();
        }
    }


    public function getStyles() {
        global $styles,$template_engine;
        $template_engine->assign('class', 'page_style');
        return $this -> getStylesByArray($styles);
    }

    public function getStylesByArray($styles) {
        global $template_engine;
        $template_engine->assign('styles', $styles);
        $template_engine->assign('count', sizeof($styles));
        $res =  $template_engine->fetch('styles.tpl');
        return $res;
    }

    public function getAAScriptsArray() {
        global $js_common_scripts,$js_scripts;
        $res = array_merge($js_common_scripts,$js_scripts);
        return $res;
    }

    public function getScriptsArray() {
        global $js_scripts;
        return $js_scripts;
    }

    public function getAllStylesArray() {
        global $common_styles,$styles;
        $res = array_merge($common_styles,$styles);
        return $res;
    }

    public function getPecuilarStylesArray() {
        global $styles;
        return $styles;
    }

    public function getScripts() {
        global $template_engine,$js_scripts;
        $template_engine->assign('js_scripts', $js_scripts);
        $template_engine->assign('count', sizeof($js_scripts));
        $res =  $template_engine->fetch('scripts.tpl');

        return $res;
    }

    public function getAllScripts() {
        $s1 =  $this ->getCommonScripts();
        $s2 =  $this -> getScripts();
        $scripts =  $s1 . $s2;
        return $scripts;
    }

    public function getAllStyles() {
        $s1 =  $this ->getCommonStyles();
        $s2 =  $this -> getStyles();
        $styles =   $s1 . $s2;
        return $styles;
    }
}

?>