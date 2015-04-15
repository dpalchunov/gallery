<?php

function getmicrotime() {
    list($usec, $sec) = explode(" ", microtime());
    return ((float)$usec + (float)$sec);
}

function actionHeader() {
    if ( isset($_POST['action'])) {
        $action = $_POST['action'];
    } else {
        $action = "undefined_action";
    }

    if ( isset($_POST['part'])) {
        $part = $_POST['part'];
    } else {
        $part = "undefined_part";
    }

    header('action:'.$action);
    header('part:'.$part);
}

function getGUID(){
    if (function_exists('com_create_guid')){
        return com_create_guid();
    }else{
        mt_srand((double)microtime()*10000);//optional for php 4.2.0 and up.
        $charid = strtoupper(md5(uniqid(rand(), true)));
        $hyphen = chr(45);// "-"
        $uuid = chr(123)// "{"
            .substr($charid, 0, 8).$hyphen
            .substr($charid, 8, 4).$hyphen
            .substr($charid,12, 4).$hyphen
            .substr($charid,16, 4).$hyphen
            .substr($charid,20,12)
            .chr(125);// "}"
        return $uuid;
    }
}
?>