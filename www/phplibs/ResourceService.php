<?php
function autoload_services($class_name)
{
    $file = 'phplibs/godb/' . $class_name . '.php';
    if (file_exists($file)) {
        require_once($file);
    } else {
        $file = 'phplibs/smarty/libs/' . $class_name . '.php';
        if (file_exists($file)) {
            require_once($file);
        } else {
            $file = 'phplibs/' . $class_name . '.php';
            if (file_exists($file)) {
                require_once($file);
            } else {
                $file = $class_name . '.php';
                if (file_exists($file)) {
                    require_once($file);
                }
            }
        }
    }
}

spl_autoload_register('autoload_services');
class  ResourceService
{

    public static function getDBConnection()
    {
        try {
            $db = goDB::getDB('StrunkovaDB');
        } catch (goDBExceptionDBNotFound $e) {
            $config = array(
                'name' => 'strunkovadb',
                'host' => '127.0.0.1',
                'port' => 3306,
                'username' => 'root',
                'passwd' => 'dbadba',
                'dbname' => 'strunkovadb',
                'charset' => 'utf8',
                'debug' => false);
            $db = new goDB($config);
        }
        return $db;
    }

    public static function getTemplateEngine()
    {
        $smarty = new Smarty();

        $smarty->setTemplateDir('phplibs/smarty/templates');
        $smarty->setCompileDir('phplibs/smarty/templates_c');
        $smarty->setCacheDir('phplibs/smarty/cache/');
        $smarty->setConfigDir('phplibs/smarty/configs/');
        $smarty->left_delimiter = '{{{';
        $smarty->right_delimiter = '}}}';

        return $smarty;
    }

    public static function getLang()
    {

        if ($_COOKIE['lang'] == '') {
            $expireDate = mktime(0, 0, 0, 1, 1, 2020);
            setcookie('lang', 'eng', $expireDate);
            return 'eng';
        } else {
            return $_COOKIE['lang'];
        }
    }

    public static function changeLang()
    {
        if ($_COOKIE['lang'] == 'rus') {
            $expireDate = mktime(0, 0, 0, 1, 1, 2020);
            setcookie('lang', 'eng', $expireDate,"/");
        } else if ($_COOKIE['lang'] == 'eng') {
            $expireDate = mktime(0, 0, 0, 1, 1, 2020);
            setcookie('lang', 'rus', $expireDate,"/");
        } else  {
            $expireDate = mktime(0, 0, 0, 1, 1, 2020);
            setcookie('lang', 'eng', $expireDate,"/");
        }

    }


}

?>