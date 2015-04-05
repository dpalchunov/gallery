<?php

require_once 'phplibs/ResourceService.php';

$actions = array(
    "common_action" => array ("type" => "everyone")
);

function common_action_handler() {
    $page = new AboutPageViewer();
    $page -> show($_POST);
}

require_once './router.php';
?>