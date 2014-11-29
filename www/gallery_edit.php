<?php
require_once 'phplibs/ResourceService.php';
$galleryEditor = new GalleryEditor();
if (isset($_POST['page'])) {
    $page = $_POST['page'];
} else {
    $page = 1;
}

$galleryEditor->editGallery($page);
?>