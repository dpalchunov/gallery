<?php

require_once 'phplibs/ResourceService.php';
require_once './helpers.php';
actionHeader();

$actions = array(
    "common_action" => array ("type" => "everyone")
);

function common_action_handler() {
    $page = new ErrorPageViewer404();
    $page -> show($_POST);
}

require_once './router.php';
?>