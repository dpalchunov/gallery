<?php

require_once 'phplibs/ResourceService.php';

$actions = array(
    "common_action" => array ("type" => "everyone")
);

function common_action_handler() {
    if ($_COOKIE['greetingWasShown'] == 'true') {
        $page = new AboutPageViewer();
    } else {
        $page = new GreetingPageViewer();
    }
    $page -> show($_POST);
}

require_once './router.php';
?>