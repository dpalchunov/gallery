<?php

require_once 'phplibs/ResourceService.php';

$actions = array(
    "common_action" => array ("type" => "everyone")
);

function common_action_handler() {
    $aboutPage = new GreetingPageViewer();
    $aboutPage -> show($_POST);
}

require_once './router.php';
?>