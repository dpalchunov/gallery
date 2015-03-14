<?php

require_once 'phplibs/ResourceService.php';
require_once './helpers.php';

$actions = array(
    "common_action_" => array ("type" => "super_role"),
    "del_file" => array ("type" => "super_role")
);

function common_action_handler() {
    return;
}

function del_file_handler() {
    $res =unlink($_POST['src']);
    echo json_encode($res);
}

require_once './router.php';
?>
