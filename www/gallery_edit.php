<?php

require_once 'phplibs/ResourceService.php';

session_start();
if ( isset($_SESSION['state'])) {
    $galleryViewer = new GalleryEditPageViewer();
    $galleryViewer -> show($_POST);
} else {
    echo 'page not found';
}


?>