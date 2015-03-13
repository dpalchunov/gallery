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