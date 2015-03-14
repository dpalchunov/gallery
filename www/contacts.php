<?php

require_once 'phplibs/ResourceService.php';
$actions = array(
    "common_action" => array ("type" => "everyone")
);
function common_action_handler() {
    $contactsPage = new ContactsPageViewer();
    $contactsPage -> show($_POST);
}
require_once './router.php';
?>