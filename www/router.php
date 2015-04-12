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
    $page = new ErrorPageViewer();
    $page -> showPageContentOnly($_POST);
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