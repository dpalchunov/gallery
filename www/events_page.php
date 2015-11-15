<?php

require_once 'phplibs/ResourceService.php';
require_once './helpers.php';
actionHeader();

$actions = array(
    "common_action" => array ("type" => "everyone"),
    "save_events" => array ("type" => "everyone")
);

function common_action_handler() {

    $page = new EventsPageViewer();
    $page -> show($_POST);
}

function save_events_handler() {
    if (isset($_POST['events_content'])) {
        $man = new ContentObjManager();
        $obj = new ContentObj('events',base64_encode($_POST['events_content']));
        $response = $man ->update($obj);
    }  else {
        $response = 'events_content post attribute not set';
    }


    echo json_encode($response);


}

require_once './router.php';
?>