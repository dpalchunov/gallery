<?php
require_once 'phplibs/ResourceService.php';
$galleryEditHtmlGetter = new GalleryEditHtmlGetter();
if (isset($_POST['active_page'])) {
    $page = $_POST['active_page'];
} else {
    $page = 1;
}
$gallery_html_code = $galleryEditHtmlGetter->getHTMLCode($page);
echo $gallery_html_code;
?>