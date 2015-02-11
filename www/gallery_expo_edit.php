<?php

require_once 'phplibs/ResourceService.php';

session_start();
if ( isset($_SESSION['state'])) {
    $galleryViewer = new GalleryExpoEditPageViewer();
    $galleryViewer -> show($_POST);
} else {
    echo 'page not found';
}


?>