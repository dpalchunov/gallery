<?php

require_once 'phplibs/ResourceService.php';
require_once './helpers.php';
actionHeader();

$actions = array(
    "common_action" => array ("type" => "super_role")
);

function common_action_handler() {
    $galleryViewer = new GalleryExpoEditPageViewer();
    $galleryViewer -> show($_POST);
}
require_once './router.php';
?>