<?php
require_once 'phplibs/ResourceService.php';
$galleryEditHtmlGetter = new GalleryEditHtmlGetter();
$count = $galleryEditHtmlGetter->getPageCount($page);
echo $count;
?>