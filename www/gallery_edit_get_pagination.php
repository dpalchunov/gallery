<?php
require_once 'phplibs/ResourceService.php';
$galleryEditHtmlGetter = new GalleryEditHtmlGetter();
if (isset($_POST['active_page'])) {
    $page = $_POST['active_page'];
} else {
    $page = 1;
}
$pagination_html_code = $galleryEditHtmlGetter->getPaginationHtml($page);
echo $pagination_html_code;
?>