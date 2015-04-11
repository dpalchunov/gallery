<?php

function execute_action_handler($action) {
    $handler_name = $action . "_handler";
    if (function_exists($handler_name)){
        call_user_func_array($handler_name,array());
    } else {
        echo "action not supported";
        return;
    }
}

function is_under_ie9() {
    preg_match('/MSIE (.*?);/', $_SERVER['HTTP_USER_AGENT'], $matches);
    if(count($matches)<2){
        preg_match('/Trident\/\d{1,2}.\d{1,2}; rv:([0-9]*)/', $_SERVER['HTTP_USER_AGENT'], $matches);
    }

    if (count($matches)>1){
        //Then we're using IE
        $version = $matches[1];

        switch(true){
            case ($version<=8):
                //IE 8 or under!
                return true;
                break;
            default:
                return false;
        }
    }

    return false;
}

if (is_under_ie9()) {
    echo
    'К&nbsp;сожалению, текущая версия используемого Вами браузера устарела. <br>Это значит, что при посещении сайта работа некоторых сервисов и&nbsp;страниц может быть некорректной.</p>
<p>Для полноценного доступа к&nbsp;сайту Сбербанка рекомендуем установить более современный браузер из&nbsp;списка ниже.
<img src="./images/errors/chrome.png" alt="Google Chrome" title="Google Chrome">
<span>Google Chrome</span>
<a href="https://www.mozilla.org/ru/firefox/new/?utm_source=firefox-com&amp;utm_medium=referral" target="_blank">
<img src="./images/errors/ff.png" alt="Mozilla Firefox" title="Mozilla Firefox">
<span>Mozilla Firefox</span>
<a href="http://windows.microsoft.com/ru-ru/internet-explorer/download-ie" target="_blank">
<img src="./images/errors/ie.png" alt="Internet Explorer" title="Internet Explorer">
<span>Internet Explorer</span>
<a href="http://www.opera.com/ru/abtest/blue?utm_expid=8257061-42.BFlNHmURT8WFVsrrtCTgyg.1&amp;utm_referrer=http%3A%2F%2Fbrowsehappy.com%2F" target="_blank">
<img src="./images/errors/opera.png" alt="Opera" title="Opera">
<span>Opera</span>
';


    return;
}

session_start();
if ( isset($_POST['action'])) {
    $action = $_POST['action'];
} else {
    $action = "common_action";
}
if ( isset($_SESSION['state']) or $actions[$action]["type"] == "everyone"  ) {
    execute_action_handler($action);
    return;
} else {
    echo 'page not found';
    return;
}



?>