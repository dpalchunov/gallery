<?php

require_once 'phplibs/ResourceService.php';
$galleryViewer = new GalleryEditPageViewer();
$galleryViewer -> show($_POST);

?>