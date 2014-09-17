<?php
    require_once 'phplibs/ResourceService.php';
    $galleryEditHtmlGetter = new GalleryEditHtmlGetter();
    $gallery_html_code = $galleryEditHtmlGetter->generateAvasHtml();
    echo $gallery_html_code;
?>